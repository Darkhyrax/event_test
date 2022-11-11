<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_first_name',
        'part_family_name',
        'part_birth_date'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'part_id';

    /**
     * Obtain user info.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * Participations on events.
    */
    public function events()
    {
        return $this->belongsToMany("App\Models\Events",'participants_on_events','part_id','eve_id');
    }

    protected static function boot() 
    {
        parent::boot();

        self::deleting(function($participant) 
        {
            $participant->user->delete(); //Delete as user too
        });
    }
}
