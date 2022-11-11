<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Participants;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creación del usuario
        $user = User::create([
            'name' => 'Night Hyrax',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ]);

        // We assign role administrator
        $user->assignRole('Administrator');

        // Create admin as participant too
        Participants::create([
            'part_first_name' => 'Night',
            'part_family_name' => 'Hyrax',
            'part_birth_date' => '2000-01-01',
            'user_id' => $user->id
        ]);

        // We create fake random users with password 'password' and assign user role and create on participants table
        \App\Models\User::factory()->count(5)->create()->each(function ($user) 
        {
            $user->assignRole('User');
            $explode = explode(" ", $user->name); //We use space as separator to get like a first and family name
            Participants::create([
                'part_first_name' => $explode[0],
                'part_family_name' => $explode[1],
                'part_birth_date' => date('Y-m-d',strtotime(mt_rand(1262055681,1262055681))), //Random birth date
                'user_id' => $user->id
            ]);
        });
    }
}
