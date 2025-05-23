<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date',
            'color' => 'nullable|string|max:7',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $event = new Event;
        $event->schedule_id = $request->schedule_id;
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->color = $request->color;
        $event->save();

        return response()->json(['success' => true, 'message' => 'Event saved successfully!', 'event' => $event]);
    }


    public function getEvents(Request $request)
    {
        $selectedIds = $request->input('ARRAY', []);  // Get the array of selected IDs, default to an empty array

        $events = DB::table('schedules AS s')
            ->where('s.status', '!=', 5)
            ->leftJoin('events AS e', 's.id', '=', 'e.schedule_id')
            ->leftJoin('liturgicals AS l', 'l.id', '=', 'e.liturgical_id')
            ->join('users AS u', 'u.id', '=', 's.created_by')
            ->select([
                's.id AS schedule_id',
                'u.profile_image AS profile_image',
                DB::raw("DATE_FORMAT(s.date, '%M %d, %Y') AS date"),
                DB::raw("DATE_FORMAT(s.date, '%Y') AS year"),
                DB::raw("DATE_FORMAT(s.date, '%M') AS month"),
                DB::raw("DATE_FORMAT(s.time_from, '%l:%i %p') AS time_from"),
                DB::raw("DATE_FORMAT(s.time_to, '%l:%i %p') AS time_to"),
                's.date AS s_date',
                'u.role AS role',
                's.venue AS venue',
                's.address AS address',
                's.purpose AS purpose',
                's.others AS others',
                's.sched_type AS sched_type',
                's.created_by AS created_by',
                's.created_by_name AS created_by_name',
                's.assign_to AS assign_to',
                's.assign_to_name AS assign_to_name',
                's.assign_by AS assign_by',
                's.status AS status',
                's.is_assign AS is_assign',
                's.created_at AS schedule_created_at',
                's.updated_at AS schedule_updated_at',
                'e.id AS event_id',
                'e.title AS event_title',
                'e.start AS event_start',
                'e.end AS event_end',
                'e.color AS event_color',
                'e.created_at AS event_created_at',
                'e.updated_at AS event_updated_at',
                'l.id AS liturgicals_id',
                'l.title AS liturgical_title',
                'l.requirements AS liturgical_requirement',
                'l.stipend AS liturgical_stipend'
            ]);

            if (!empty($selectedIds)) {
                $events = $events->where(function ($query) use ($selectedIds) {
                    $query->whereIn('s.assign_to', $selectedIds)
                          ->orWhere(function ($subQuery) use ($selectedIds) {
                              if (in_array('N/A', $selectedIds)) {
                                  $subQuery->whereNull('s.assign_to'); // Include unassigned schedules
                              }
                          });
                });
            } 
        // if (Auth::user()->role != "secretary") {
        //     // Filter by selected IDs if provided
        //     if (!empty($selectedIds)) {
        //         $events = $events->whereIn('s.assign_to', $selectedIds);
        //     } else {
        //         if (Auth::user()->role != "admin") {
        //             // Adjusted condition: checking for either `assign_to` being the authenticated user or `assign_to` being empty
        //             $events = $events->where(function ($query) {
        //                 $query->where('s.assign_to', Auth::user()->id)
        //                     ->orWhere('s.assign_to', ''); // Includes events where assign_to is empty
        //             });
        //         }
        //     }
        // }



        // Fetch events
        $events = $events->get();

        // Map and return the events as JSON
        $renamedEvents = $events->map(function ($event) {
            return [
                'id' => $event->event_id,
                'title' => $event->event_title,
                'start' => $event->event_start ? date('Y-m-d H:i:s', strtotime($event->event_start)) : null,
                'end' => $event->event_end ? date('Y-m-d H:i:s', strtotime($event->event_end)) : null,
                'color' => $event->event_color,
                'schedule_id' => $event->schedule_id,
                'start_time' => $event->event_start ? date('h:i A', strtotime($event->event_start)) : null,
                'end_time' => $event->event_end ? date('h:i A', strtotime($event->event_end)) : null,
                'venue' => $event->venue,
                'address' => $event->address,
                'purpose' => $event->purpose,
                'created_by' => $event->created_by_name,
                'assign_to' => $event->assign_to_name,
                'assign_to_id' => $event->assign_to,
                'status' => $event->status,
                'profile_image' => $event->profile_image,
                'role' => $event->role,
                'liturgical_title' => $event->liturgical_title,
                'liturgical_requirement' => $event->liturgical_requirement,
                'liturgical_stipend' => $event->liturgical_stipend,
                'formated_date' => $event->date
            ];
        });

        return response()->json($renamedEvents);
    }
}
