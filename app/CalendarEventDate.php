<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEventDate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calendar_events_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_at', 'calendar_event_id'];

    public function event()
    {
        return $this->belongsTo('App\CalendarEvent', 'calendar_events_id');
    }
}
