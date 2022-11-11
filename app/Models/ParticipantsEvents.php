<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantsEvents extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participants_on_events';

     /**
     * Obtain event info wich user is registered to.
     */
    public function event()
    {
        return $this->belongsTo(Events::class,'eve_id','eve_id');
    }

    /**
     * Obtain participant info wich user is going to.
     */
    public function participant()
    {
        return $this->belongsTo(Participants::class,'part_id','part_id');
    }
}
