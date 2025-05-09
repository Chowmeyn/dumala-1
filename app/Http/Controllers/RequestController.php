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
        // Get declined priest IDs for the view
        $declinedPriestIds = DeclinedRequest::pluck('referred_priest_id')->unique()->toArray();
        return view('pages.requests', compact('declinedPriestIds'));
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
        ->leftJoin('liturgicals', 'schedule_events_view_v2.purpose', '=', 'liturgicals.title') // Join with liturgicals table
        ->select(
            'schedule_events_view_v2.*',
            'liturgicals.requirements as purpose_requirements' // Fetch requirements from liturgicals table
        )
        ->where('schedule_events_view_v2.status', '!=', 4);
    
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

    public function getListCompletedLiturgical(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $year = $request->input('year');
        $month = $request->input('month');
        $date_range = $request->input('date_range');
        $priest_id = $request->input('priest_id');
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
    
        if ($priest_id) {
            $query->where('schedule_events_view_v2.assign_to', $priest_id);
        }
        
        $id_ = Auth::user()->id;
    
        if (!in_array(Auth::user()->role, ['admin', 'parish_priest', 'secretary'])) {
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
        try {
            DB::beginTransaction();
            
            $schedule = Schedule::find($id);
            if (!$schedule) {
                return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
            }
    
            if (!$request->priest_id) {
                return response()->json(['success' => false, 'message' => 'Please select a priest.'], 400);
            }
    
            if (!$request->reason) {
                return response()->json(['success' => false, 'message' => 'Please provide a reason.'], 400);
            }
        
            // Get the current authenticated user's ID (the declining priest)
            $decliningPriestId = Auth::id();
            
            // Check if this priest has already declined this request
            $existingDecline = DeclinedRequest::where('schedule_id', $id)
                ->where('referred_priest_id', $decliningPriestId)
                ->first();
                
            // Get the new priest's information
            $newPriest = User::find($request->priest_id);
            if (!$newPriest) {
                return response()->json(['success' => false, 'message' => 'Selected priest not found.'], 404);
            }
            
            // Update the schedule with the new referred priest
            $schedule->assign_to = $request->priest_id;
            $schedule->assign_to_name = $newPriest->firstname . ' ' . $newPriest->lastname;
            $schedule->status = 3; // Status for pending referral
            $schedule->save();
        
            // Log the decline with the current user's ID as the declining priest
            DeclinedRequest::create([
                'schedule_id' => $id,
                'referred_priest_id' => $decliningPriestId,
                'reason' => $request->reason,
            ]);
        
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Request declined and referred successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Decline request error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while processing the request.'], 500);
        }
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
