<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CalendarEventResource;
use App\CalendarEventDate;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = CalendarEventDate::with('event')->latest()->get();   
        $array_events = array();
        
        for ($i= 0; $i < count($events); $i++) {
            array_push($array_events, [
                'name'  =>  $events[$i]['event']['label'],
                'start' =>  $events[$i]['event_at'],
                'end'   =>  $events[$i]['event_at'],
                'color' =>  $events[$i]['event']['code'],
                'timed' =>   false
            ]);
        }

        return CalendarEventResource::collection($array_events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request){
                $calendarEventLastId = DB::table('calendar_events')->insertGetId([
                    'label' =>  $request->label,
                    'code'  =>  $request->code,
                    'created_at'    =>  now(),
                    'updated_at'    =>  now()
                ]);

                for ($i = 0; $i < count($request->event_at); $i++) {
                    DB::table('calendar_events_dates')->insert([
                        'event_at'  =>  $request->event_at[$i],
                        'calendar_events_id'    =>  $calendarEventLastId,
                        'created_at'    =>  now(),
                        'updated_at'    =>  now()
                    ]);
                }
            });

            return new calendarEventResource([
                'error'  => false,
                'message'   =>  "Added new event successful!"
            ]);
        } catch (\Exception $e) {
            return new calendarEventResource([
                'error' =>  true,
                'message'  =>   $e->getMessage()
            ]);
        }
    }
}
