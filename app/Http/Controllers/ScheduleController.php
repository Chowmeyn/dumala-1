<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Event;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.schedules');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [];
        $event_id = '';
        if ($request->input('sched_type') == 'own_sched') {
            $validated = $request->validate([
                // 'date' => 'required|date',
                // 'time_from' => 'required|date_format:H:i',
                // 'time_to' => 'required|date_format:H:i|after:time_from',
                'venue' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'purpose' => 'required|string|max:255',
                'others' => 'nullable|string|max:255',
            ]);

            $time_from_24 = date('H:i:s', strtotime($request->input('time_from')));
            $time_to_24 = date('H:i:s', strtotime($request->input('time_to')));
            $date_now = $request->input('date');


            $validated['date'] = $date_now;
            $validated['time_from'] = $time_from_24;
            $validated['time_to'] = $time_to_24;

            $validated['sched_type'] = $request->input('sched_type');
            $validated['created_by'] = Auth::user()->id;
            $validated['created_by_name'] = Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname;
            $validated['assign_to'] =  $request->input('assign_to');
            $validated['assign_by'] =  Auth::user()->id;
            $validated['status'] = '1';
            $validated['is_assign'] = '0';


            // Insert the schedule
            $schedule = Schedule::create($validated);

            $event = new Event;
            $event->liturgical_id = $request->input('liturgical_id');
            $event->schedule_id = $schedule->id;
            $event->title =  $request->input('purpose');
            $event->start = $date_now . ' ' . $time_from_24;
            $event->end =  $date_now . ' ' . $time_to_24;
            $event->color = '#348fe2';
            $event->save();

            $users_role = User::whereIn('role', ['admin', 'parish_priest'])->get();

            $user_role_ids = $users_role->pluck('id')->toArray();

            $assign_to = $request->input('assign_to');
            if ($assign_to) {
                $user_role_ids[] = $assign_to;
            }

            $data = [
                'type' => 'private',
                'image_path' => Auth::user()->profile_image,
                'name' => Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname,
                'user' => Auth::user()->id,
                'user_to' => '0',
                'title' => $request->input('purpose'),
                'description' => Auth::user()->prefix . " " . Auth::user()->firstname . " " . Auth::user()->lastname . ' added an unassigned ' . $request->input('purpose'),
                'url' => '/request',
                'where' => $user_role_ids,
            ];
        } else {

            // #348fe2
            $time_from_24 = date('H:i:s', strtotime($request->input('time_from')));
            $time_to_24 = date('H:i:s', strtotime($request->input('time_to')));
            $date_now = $request->input('date');

            $user_name = User::where('id', $request->input('assign_to'))->first();
            $user_name_f = ($user_name->prefix == '') ? '' : $user_name->prefix . '.' . ' ' . $user_name->firstname . ' ' . $user_name->lastname;

            $validated['purpose'] = 'Mass Schedule';

            $validated['date'] = $date_now;
            $validated['time_from'] = $time_from_24;
            $validated['time_to'] = $time_to_24;

            $validated['sched_type'] = $request->input('sched_type');
            $validated['created_by'] = Auth::user()->id;
            $prefix = Auth::user()->prefix ?? ''; // Null coalescing operator
            $validated['created_by_name'] = Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname;
            $validated['assign_to'] =  $request->input('assign_to');
            $validated['assign_by'] =  Auth::user()->id;
            $validated['status'] = '1';
            $validated['is_assign'] = '1';
            $validated['assign_to_name'] = $user_name_f;


            // Insert the schedule
            $schedule = Schedule::create($validated);

            $event = new Event;
            $event->liturgical_id = $request->input('liturgical_id');
            $event->schedule_id = $schedule->id;
            $event->title =  'Mass Schedule';
            $event->start = $date_now . ' ' . $time_from_24;
            $event->end =  $date_now . ' ' . $time_to_24;
            $event->color = '#348fe2';
            $event->save();

            $users_role = User::whereIn('role', ['admin', 'parish_priest'])->get();

            $user_role_ids = $users_role->pluck('id')->toArray();

            $assign_to = $request->input('assign_to');
            if ($assign_to) {
                $user_role_ids[] = $assign_to;
            }

            $data = [
                'type' => 'private',
                'image_path' => Auth::user()->profile_image,
                'name' => Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname,
                'user' => Auth::user()->id,
                'user_to' => $request->input('assign_to'),
                'title' => 'Mass Schedule',
                'description' => Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname . ' assigned ' . $user_name_f . ' to the mass schedule.',
                'url' => '/request',
                'where' => $user_role_ids,
            ];
        }

        send_notification($data);


        return response()->json(['message' => 'Schedule created successfully!'], 200);
    }


    public function assign_priest(Request $request)
    {
        try {
            $prefix = Auth::user()->prefix ?? '';
            $full = empty($prefix)
                ? ''
                : "{$prefix}. " . Auth::user()->firstname . " " . Auth::user()->lastname;

            $user = User::where('id', $request->input('user_id'))->first();
            $user_name_f = $user->prefix . ' ' . $user->firstname . ' ' . $user->lastname;

            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }

            $sched = Schedule::where('id', $request->input('sched_id'))->first();

            if (!$sched) {
                return response()->json(['message' => 'Schedule not found.'], 404);
            }

            $sched->assign_to = $user->id;

            $sched->assign_to_name = ($user->prefix == '') ? $user->firstname . ' ' . $user->lastname : $user->prefix . '.' . ' ' . $user->firstname . ' ' . $user->lastname;
            $sched->is_assign = '1';
            $sched->status = $request->input('status',1);

            $sched->save();

            $users_role = User::whereIn('role', ['admin', 'parish_priest'])->get();

            $user_role_ids = $users_role->pluck('id')->toArray();

            if ($user->id) {
                $user_role_ids[] = $user->id;
                $user_role_ids[] = $sched->created_by;
            }

            $data = [
                'type' => 'private',
                'image_path' => $user->profile_image,
                'name' => $user_name_f,
                'user' => $user->id,
                'user_to' => $user->id,
                'title' => $user->purpose,
                'description' => $full . ' assigned ' . $user_name_f . ' to the ' . $user->purpose . '.',
                'url' => '/request',
                'where' => $user_role_ids,
            ];

            send_notification($data);


            return response()->json(['status' => 1, 'message' => 'Assign successful!'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
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
    public function destroy(string $id)
    {
        //
    }

    public function storeOrUpdate(Request $request)
    {
        $data = [];
        $event_id = $request->input('schedId'); // Check if an ID is provided for update
        $isUpdate = !empty($event_id);

        $sched_type = $request->input('sched_type');

        $time_from_24 = date('H:i:s', strtotime($request->input('time_from')));
        $time_to_24 = date('H:i:s', strtotime($request->input('time_to')));
        $date_now = $request->input('date');

        // Check if the date and time are already taken with status "accepted by parish priest"
        $existingSchedule = Schedule::where('date', $date_now)
            ->where('time_from', $time_from_24)
            ->where('time_to', $time_to_24)
            ->where('status', '2')
            ->first();

        if ($existingSchedule) {
            return response()->json([
                'message' => 'Date and time is taken'
            ], 400);
        }

        if ($sched_type != 'mass_sched') {
            $validated = $request->validate([
                'venue' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'purpose' => 'required|string|max:255',
                'others' => 'nullable|string|max:255',
            ]);
        }

        $validated['date'] = $date_now;
        $validated['time_from'] = $time_from_24;
        $validated['time_to'] = $time_to_24;
        $validated['sched_type'] = $sched_type;
        $validated['created_by'] = Auth::user()->id;
        $validated['created_by_name'] = Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname;
        $validated['assign_to'] = $request->input('assign_to');
        $validated['assign_by'] = Auth::user()->id;
        $validated['status'] = '1';
        $validated['is_assign'] = ($sched_type === 'own_sched') ? '0' : '1';

        if ($sched_type === 'mass_sched') {
            $user = User::find($request->input('assign_to'));
            $user_name_f = $user ? (($user->prefix ? $user->prefix . '.' : '') . ' ' . $user->firstname . ' ' . $user->lastname) : 'N/A';
            $validated['purpose'] = 'Mass Schedule';
            $validated['assign_to_name'] = $user_name_f;
        }

        if ($isUpdate) {
            $schedule = Schedule::findOrFail($event_id);
            $schedule->update($validated);
        } else {
            $schedule = Schedule::create($validated);
        }

        $eventData = [
            'liturgical_id' => $request->input('liturgical_id'),
            'schedule_id' => $schedule->id,
            'title' => $validated['purpose'],
            'start' => $date_now . ' ' . $time_from_24,
            'end' => $date_now . ' ' . $time_to_24,
            'color' => '#348fe2',
        ];

        if ($isUpdate) {
            $event = Event::where('schedule_id', $event_id)->first();
            if ($event) {
                $event->update($eventData);
            }
        } else {
            Event::create($eventData);
        }

        $users_role = User::whereIn('role', ['admin', 'parish_priest'])->get();
        $user_role_ids = $users_role->pluck('id')->toArray();
        if ($request->input('assign_to')) {
            $user_role_ids[] = $request->input('assign_to');
        }

        $data = [
            'type' => 'private',
            'image_path' => Auth::user()->profile_image,
            'name' => Auth::user()->prefix . ' ' . Auth::user()->firstname . " " . Auth::user()->lastname,
            'user' => Auth::user()->id,
            'user_to' => $request->input('assign_to') ?? '0',
            'title' => $validated['purpose'],
            'description' => Auth::user()->prefix . " " . Auth::user()->firstname . " " . Auth::user()->lastname .
                ($isUpdate ? ' updated ' : ' added ') . $validated['purpose'],
            'url' => '/request',
            'where' => $user_role_ids,
        ];

        send_notification($data);

        return response()->json([
            'message' => $isUpdate ? 'Schedule updated successfully!' : 'Schedule created successfully!'
        ], 200);
    }


    public function completeSched(Request $request){
        $schId = $request->input('sched_id');
        $schedule = Schedule::findOrFail($schId);
        $schedule->status = 4;
        $schedule->save();

        return response()->json([
            'message' => "Success Complete Schedule!"
        ], 200);

    }
    
   
    public function archiveSched(Request $request){
        $schId = $request->input('sched_id');
        $schedule = Schedule::findOrFail($schId);
        $schedule->status = 5;
        $schedule->save();

        return response()->json([
            'message' => "Success Archive Schedule!"
        ], 200);

    }

}
