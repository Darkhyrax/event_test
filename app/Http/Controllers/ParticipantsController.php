<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\Events;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use DB;

class ParticipantsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participants = Participants::whereNotIn('part_id',[1])->get();
        return view('participants.index',compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('participants.form');
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
            'part_first_name' => 'required|string|max:100',
            'part_family_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->user_id,
            'password' => ['required_without:part_id','nullable', 'string',Password::min(8)
                                                ->mixedCase()
                                                ->numbers()
                                                ->symbols()
                        ],
            'part_birth_date' => 'nullable|date_format:Y-m-d'
        ],[],
        [
            'part_first_name' => 'First Name',
            'part_family_name' => 'Family Name',
            'email' => 'Email',
            'password' => 'Password',
            'part_birth_date' => 'Birth Date',
            'part_id' => 'Participant'
        ]);

        try 
        {
            if ($request->part_id) 
            {
                $model = Participants::findOrFail($request->part_id);
                $model->fill($request->all());
                $model->save();

                $modeluser = User::findOrFail($model->user_id);
                // Concatenate first and family name to save as name in users table
                $modeluser->name = $request->part_first_name.' '.$request->part_family_name;
                $modeluser->email = $request->email;
                 // if exists a password change 
                if ($request->password) 
                {
                    $modeluser->password = Hash::make($request->password);
                }
                $modeluser->save();

                $action = "edited";
            }
            else
            {
                // Store in users table
                $user = User::create([
                    'name' => $request->part_first_name.' '.$request->part_family_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Assign User role to user
                $user->assignRole('User');

                // Filling and storing in participants table
                $modelparticipant = new Participants;
                $modelparticipant->fill($request->all());
                $modelparticipant->user_id = $user->id;
                $modelparticipant->save();

                $action = "created";
            }

            DB::commit();
            return response()->json(['message' => "Participant {$action} successfully!"],201);    
        } 
        catch (Exception $e) 
        {
            DB::rollBack();
            echo $e->getMessage();
        }
        
    }

    public function edit($id)
    {
        $participant = Participants::findOrFail($id);
        return view('participants.form',compact('participant'));
    }

    public function destroy($id)
    {   
        $participant = Participants::findOrFail($id)->delete();
        return response()->json(['message' => "Participant deleted successfully!"],201); 
    }

    public function inactive($id,$action)
    {
        $participant = Participants::findOrFail($id);
        $participant->user->active = $action;
        $participant->user->save();
        $participant->events()->detach(); //Remove participant from events

        return response()->json(['message' => "Participant inactivated successfully!"],201); 
    }
}
