<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DeclinedRequest;

class RequestController extends Controller
{
 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.requests');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getListSched(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $year = $request->input('year');
        $month = $request->input('month');
        $date_range = $request->input('date_range');
        $perPage = 10; // Items per page
        $time_from_24 = date('H:i:s', strtotime($request->input('time_from')));
        $time_to_24 = date('H:i:s', strtotime($request->input('time_to')));
    
        $query = DB::table('schedule_events_view_v2')
        ->leftJoin('declined_requests', 'schedule_events_view_v2.schedule_id', '=', 'declined_requests.schedule_id')
        ->select(
            'schedule_events_view_v2.*',
            'declined_requests.reason as declined_reason',
            'declined_requests.referred_priest_id as declined_priest_id', // Fix here
            'declined_requests.created_at as declined_at'
        );
    
        $id_ = Auth::user()->id;
    
        if (!in_array(Auth::user()->role, ['admin', 'parish_priest'])) {
            $query->where(function ($q) use ($id_) {
                $q->where('schedule_events_view_v2.created_by', $id_)
                  ->orWhere('schedule_events_view_v2.assign_to', $id_);
            });  
        }
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('schedule_events_view_v2.created_by_name', 'like', '%' . $search . '%')
                    ->orWhere('schedule_events_view_v2.role', 'like', '%' . $search . '%')
                    ->orWhere('schedule_events_view_v2.purpose', 'like', '%' . $search . '%')
                    ->orWhere(function ($query) use ($search) {
                        $query->whereNotNull('schedule_events_view_v2.assign_to')
                              ->where('schedule_events_view_v2.assign_to', $search);
                    });
            });
        }
    
        if ($year) {
            $query->where('schedule_events_view_v2.year', $year);
        }
    
        if ($month) {
            $query->where('schedule_events_view_v2.month', $month);
        }
    
        if ($date_range) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
    
            $query->whereBetween('schedule_events_view_v2.s_date', [$start_date, $end_date]);
        }
    
        $total = $query->count();
        $sched = $query->orderBy('schedule_events_view_v2.s_date', 'desc')
                    ->skip(($page - 1) * $perPage)
                    ->take($perPage)
                    ->get();
    
        return response()->json([
            'data' => $sched,
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage
        ]);
    }



    public function getListComplete(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $year = $request->input('year');
        $month = $request->input('month');
        $date_range = $request->input('date_range');
        $perPage = 10; // Items per page

        $query = DB::table('schedule_events_view_v2')
            ->leftJoin('declined_requests', 'schedule_events_view_v2.schedule_id', '=', 'declined_requests.schedule_id')
            ->select(
                'schedule_events_view_v2.*',
                'declined_requests.reason as declined_reason',
                'declined_requests.referred_priest_id as declined_priest_id', // Fix here
                'declined_requests.created_at as declined_at'
            );


        $id_ = Auth::user()->id;
    
        if (!in_array(Auth::user()->role, ['admin', 'parish_priest'])) {
            $query->where(function ($q) use ($id_) {
                $q->where('schedule_events_view_v2.created_by', $id_)
                  ->orWhere('schedule_events_view_v2.assign_to', $id_);
            });  
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('schedule_events_view_v2.created_by_name', 'like', '%' . $search . '%')
                    ->orWhere('schedule_events_view_v2.role', 'like', '%' . $search . '%')
                    ->orWhere(function ($query) use ($search) {
                        $query->whereNotNull('schedule_events_view_v2.assign_to')
                            ->where('schedule_events_view_v2.assign_to', $search);
                    });
            });
        }

        if ($year) {
            $query->where('schedule_events_view_v2.year', $year);
        }

        if ($month) {
            $query->where('schedule_events_view_v2.month', $month);
        }

        if ($date_range) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            $query->whereBetween('schedule_events_view_v2.s_date', [$start_date, $end_date]);
        }

        // Filter by status == 2
        $query->where('schedule_events_view_v2.status', 4);

        $total = $query->count();
        $sched = $query->orderBy('schedule_events_view_v2.s_date', 'desc')
                    ->skip(($page - 1) * $perPage)
                    ->take($perPage)
                    ->get();

        return response()->json([
            'data' => $sched,
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage
        ]);
    }



    public function declineRequest(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        // Update the current schedule with the referred priest
        $schedule->assign_to = $request->priest_id;
        $schedule->assign_to_name = User::find($request->priest_id)->firstname . ' ' . User::find($request->priest_id)->lastname;
        $schedule->status = 3; // Assuming 3 means declined
        $schedule->save();

        // Optionally, log the decline reason in the DeclinedRequest table
        DeclinedRequest::create([
            'schedule_id' => $id,
            'referred_priest_id' => $request->priest_id,
            'reason' => $request->reason,
        ]);

        return response()->json(['success' => true, 'message' => 'Request updated with the referred priest successfully.']);
    }


    public function getRequestById($id)
    {
        $request = DB::table('schedules')->where('id', $id)->first();

        if (!$request) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $request]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteRequest($id)
    {
        $request = DB::table('schedules')->where('id', $id)->first();

        if (!$request) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        DB::table('schedules')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Request deleted successfully.']);
    }
    public function destroy(string $id)
    {
        //
    }
}
