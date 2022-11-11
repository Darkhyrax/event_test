<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'eve_name',
        'eve_location',
        'eve_date',
        'eve_end_date'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'eve_id';

    /**
    * Participants on event.
    */
    public function participants()
    {
        return $this->belongsToMany('App\Models\Participants','participants_on_events','eve_id','part_id');
    }
}
