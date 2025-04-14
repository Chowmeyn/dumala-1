<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Donor;
use App\Models\Marriage;


class AnnouncementController extends Controller
{
 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.announcements');
    }
    public function fetchAnnouncements(Request $request)
    {
        try {
            $type = $request->input('type', 'all'); // Get the type from the request
    
            // Fetch announcements from the database based on the type
            if ($type === 'all') {
                $announcements = Announcement::where('status', $request->announcement_status)->orderBy('updated_at', 'desc')->paginate(10);
            } else {
                $announcements = Announcement::where('status', $request->announcement_status)->where('announcement_type', $type) // Assuming 'type' is the column for announcement type
                    ->orderBy('created_at', 'desc')->paginate(10);
            }
    
            return response()->json($announcements);
        } catch (\Exception $e) {
            // Log the error and return a JSON error response
            Log::error('Error fetching announcements: ' . $e->getMessage());
            return response()->json(['error' => 'Could not fetch announcements.'], 500);
        }
    }

    public function fetchAnnouncementsDash(Request $request)
    {
        try {
            $type = $request->input('type', 'all'); // Get the type from the request
    
            // Fetch announcements from the database based on the type
            if ($type === 'all') {
                $announcements = Announcement::where('status', $request->announcement_status)->orderBy('created_at', 'desc')->get();
            } else {
                $announcements = Announcement::where('status', $request->announcement_status)->where('announcement_type', $type) // Assuming 'type' is the column for announcement type
                    ->orderBy('created_at', 'desc')->get();
            }
    
            return response()->json($announcements);
        } catch (\Exception $e) {
            // Log the error and return a JSON error response
            Log::error('Error fetching announcements: ' . $e->getMessage());
            return response()->json(['error' => 'Could not fetch announcements.'], 500);
        }
    }

    public function marriage_bann()
    {
        return view('pages.create_announcement.marriage_bann');
    }

    public function post_regular_sched()
    {
        return view('pages.create_announcement.post_regular_sched');
    }

    public function project_financial()
    {
        return view('pages.create_announcement.project_financial');
    }

    public function public_announce()
    {
        return view('pages.create_announcement.public_announce');
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
    public function storePost(Request $request)
    {
        $data = Announcement::where('id', $request->id)->first();
        $data->status = $request->tab_data;

        $donor = Donor::where('announcement_type', $data->announcement_type)->where('parent', $data->parent)->first();
        if ($donor) {
            $donor->status = $request->tab_data;
            $donor->save();
        }

        $Marriage = Marriage::where('announcement_type', $data->announcement_type)->where('parent', $data->parent)->first();
        if ($Marriage) {
            $Marriage->status = $request->tab_data;
            $Marriage->save();
        }

        $data->save();
        
        return response()->json(['success' => '1']);
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
}
