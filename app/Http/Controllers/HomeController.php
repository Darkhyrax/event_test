<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\ParticipantsEvents;
use App\Models\Events;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $info = Participants::where('user_id',Auth::user()->id)->firstOrFail();
        // Get events what is currently happening or is going to happen
        $participant_events = $info->events()->where([['eve_date','>=',date('Y-m-d')],['part_id',$info->part_id]])->orWhere([['eve_end_date','>=',date('Y-m-d')],['part_id',$info->part_id]])->get();

        return view('home',compact('info','participant_events'));
    }

    public function register_participation(Request $request)
    {
        $participant = Participants::where('user_id',Auth::user()->id)->firstOrFail();

        if ($request->isMethod('post')) 
        {
            foreach ($request->event as $event) 
            {
                $participant->events()->attach($event,['created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            }

            return response()->json(['message' => "Registered Sucesfully!"],201);    
        }

        // List of events where participant hasn't signed up yet
        $events = Events::whereDoesntHave('participants', function ($query) use ($participant) 
        {
             $query->where('participants_on_events.part_id',$participant->part_id);
        })->get();

        return view('register_participation',compact('events'));
    }
}
