<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\File;
use App\Models\Events;
use DB;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Events::all();
        return view('events.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'eve_name' => ['required','string','max:100',Rule::unique('events','eve_name')->ignore($request->eve_id,'eve_id')],
            'eve_location' => 'required|max:100|string',
            'eve_date' => 'required|date_format:Y-m-d\TH:i',
            'eve_end_date' => 'required|date_format:Y-m-d\TH:i',
            'eve_banner' => 'required_without:eve_id|mimes:jpg,jpeg,png'
        ],[],
        [
            'eve_name' => 'Name',
            'eve_location' => 'Location',
            'eve_date' => 'Begin date',
            'eve_end_date' => 'End date',
            'eve_banner' => 'Banner',
            'eve_id' => 'Event'
        ]);

        DB::beginTransaction();

        try 
        {
            if ($request->eve_id) 
            {
                $model = Events::findOrFail($request->eve_id);
                $action = "edited";
            }
            else
            {
                $model = new Events;
                $action = "created";
            }

            $events_folder = public_path("images/events");

            // If folder doesn't exist it creates a new one
            if (!File::exists($events_folder)) 
            {
                File::makeDirectory($events_folder);
            }

            // Validating when its an edit and it contains a new banner to delete the old banner
            if ($request->eve_id && $request->has('eve_banner') && File::exists($events_folder.'/'.$model->eve_banner)) 
            {
                File::delete($events_folder.'/'.$model->eve_banner);
            }

            if ($request->has('eve_banner')) 
            {
                //We get the last letters after the character "/" from the mimetype
                // We make the substring and start one position ahead were its located character "/" 
                $extension = substr( $request->eve_banner->getClientMimeType() , strpos( $request->eve_banner->getClientMimeType() ,'/' ) +1 );
                // Convert event name into lowercase and replace spaces with underscores (_)
                $filename = strtolower( str_replace(' ', '_', $request->eve_name) ).'.'.$extension;

                if ($request->file('eve_banner')->move($events_folder,$filename)) 
                {
                    $model->eve_banner = $filename;
                }
            }

            $model->fill($request->all());
            $model->save();

            DB::commit();
            return response()->json(['message' => "Event {$action} successfully!"],201);    
        } 
        catch (Exception $e) 
        {
            DB::rollBack();
            echo $e->getMessage();
        }
        
    }

    public function edit($id)
    {
        $event = Events::findOrFail($id);
        return view('events.form',compact('event'));
    }

    public function destroy($id)
    {   
        $event = Events::select('eve_id','eve_banner')->findOrFail($id);
        $event->participants()->detach(); //Remove all the participants from the event
        $event->delete(); //Delete event
        $events_folder = public_path("images/events");
        
        if (File::exists($events_folder.'/'.$event->eve_banner)) 
        {
            File::delete($events_folder.'/'.$event->eve_banner);
        }

        return response()->json(['message' => "Event deleted successfully!"],201); 
    }

    public function see_banner($id)
    {
        $event = Events::select('eve_banner')->findOrFail($id);
        $image = $event->eve_banner;
        return view('events.banner',compact('image'));
    }

    public function see_participants($id)
    {
        $participants = Events::findOrFail($id)->participants;
        return view('events.participants',compact('participants'));
    }

    public function participants_report(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $this->validate($request, [
                'from' => 'required|date|date_format:Y-m-d|before_or_equal:to',
                'to' => 'required|date|date_format:Y-m-d|after_or_equal:from',
                'event' => 'required|integer|exists:events,eve_id',
            ],[],[
                'from' => 'From',
                'to' => 'To',
                'event' => 'Event'
            ]);

            $from = date('m-d-Y',strtotime($request->from));
            $to = date('m-d-Y',strtotime($request->to));
            $events = DB::select("SELECT date(poe.created_at) as day, count(poe.part_id) as participants
                                FROM participants_on_events as poe
                                join participants part using (part_id)
                                where poe.eve_id = {$request->event}
                                and date(poe.created_at) between '{$request->from}' and '{$request->to}'
                                group by DAYOFMONTH(poe.created_at),MONTH(poe.created_at),poe.created_at
            ");

            // Transform into array
            $events = json_decode(json_encode($events), true);

            $view = view('events.graphic_report',compact('from','to','events'))->render();

            return response()->json(['view' => $view],201);
        }

        $events = Events::all();
        return view('events.form_report',compact('events'));
    }
}
