<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Events;
use App\Models\Participants;
use App\Models\ParticipantsEvents;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $events = Events::All();
        return view('auth.register',compact('events'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'part_first_name' => ['required', 'string', 'max:100'],
            'part_family_name' => ['required','string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string',Password::min(8)
                                                ->mixedCase()
                                                ->numbers()
                                                ->symbols()
                        ],
            'part_birth_date' => ['nullable','date_format:Y-m-d']
        ],[],
        [
            'part_first_name' => 'First Name',
            'part_family_name' => 'Family Name',
            'email' => 'Email',
            'password' => 'Password',
            'part_birth_date' => 'Birth Date'
        ]);

        // Set a session to determine registration form failed to switch to registration form again once page is refreshed
        if ($validator->fails()) 
        {
            session(['register' => 'failed']);
        }

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try 
        {
            // Concatenate first and family name to save as name in users table
            $name = $data['part_first_name'].' '.$data['part_family_name'];
            // Store in users table
            $user = User::create([
                'name' => $name,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Assign User role to user
            $user->assignRole('User');

            // Filling and storing in participants table
            $modelparticipant = new Participants;
            $modelparticipant->fill($data);
            $modelparticipant->user_id = $user->id;
            $modelparticipant->save();

            // If exists an event, it store each one on participants_on_events table
            if (isset($data['events'])) 
            {
                foreach ($data['events'] as $event) 
                {
                    $model = new ParticipantsEvents;
                    $model->part_id = $modelparticipant->part_id;
                    $model->eve_id = $event;
                    $model->save();
                }
            }

            DB::commit();
            return $user;    
        } 
        catch (Exception $e) 
        {
            DB::rollBack();
            echo $e->getMessage();
        }
    }


}
