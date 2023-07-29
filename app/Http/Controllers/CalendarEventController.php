<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {  
            $data = CalendarEvent::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }

        return view('calendar');
    }

    public function calendarActions(Request $request)
    {
        switch ($request->type) {
           case 'create':
              $event = CalendarEvent::create([
                  'title' => $request->event_name,
                  'start' => $request->event_start,
                  'end' => $request->event_end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'edit':
              $event = CalendarEvent::find($request->id)->update([
                  'title' => $request->event_name,
                  'start' => $request->event_start,
                  'end' => $request->event_end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = CalendarEvent::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # ...
             break;
        }
    }
}
