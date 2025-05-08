<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Announcement;
use App\Models\Marriage;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
 
    /**
     * Display a listing of the resource.
     */

    public function report_total()
    {
        return view('pages.report_total');
    }

    public function report_annual()
    {
        return view('pages.reports.annually');
    }

    public function report_month()
    {
        return view('pages.reports.monthly');
    }

    public function report_week()
    {
        return view('pages.reports.weekly');
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
    public function storeDonor(Request $request)
    {
        $short = 1;
        $parent = 1;
    
        // Get the last parent number from the Announcement model
        $data = Announcement::where('announcement_type', $request->announcement_type)
            ->orderBy('parent', 'desc')
            ->first();
    
        if ($data) {
            $parent = (int)$data->parent + 1;
        }
    
        $donorEntries = []; // Array to hold donor entries for announcement content

        $user_role = Auth::user() ? Auth::user()->role : 'N/A';
        $status = $user_role === 'parish_priest' ? 'is_posted' : 'is_pending';

        foreach ($request->donors as $donor) {
            // Create the Donor entry
            Donor::create([
                'announcement_type' => $request->announcement_type,
                'project_name' => $request->project_name,
                'donor_name' => $donor['donor_name'],
                'donated_amount' => $donor['donated_amount'],
                'parent' => $parent,
                'short' => $short++,
                'status' => $status,
            ]);
    
            // Add to donorEntries for announcement content
            $donorEntries[] = '<li><strong>Donor name:</strong> ' . $donor['donor_name'] . ' -  ₱ ' . number_format($donor['donated_amount'], 2) . '</li>';
        }
    
        // Create an Announcement entry with the donor info
        Announcement::create([
            'title' => $request->project_name,
            'content' => '<ul>' . implode('', $donorEntries) . '</ul>', // Convert array to unordered list
            'parent' => $parent,
            'announcement_type' => $request->announcement_type,
            'status' => $status,
        ]);
    
        return response()->json(['message' => 'Donors and announcements saved successfully!']);
    }
    public function storeMarriage(Request $request)
    {
        $data = Announcement::where('announcement_type', $request->announcement_type)
            ->orderBy('parent', 'desc')
            ->first();
        $parent = $data ? (int)$data->parent + 1 : 1;
    
        $marriage = Marriage::create([
            'announcement_type' => $request->announcement_type,
            'marriage_bann' => $request->marriage_bann,
            'groom_name' => $request->groom_name,
            'bride_name' => $request->bride_name,
            'groom_age' => $request->groom_age,
            'bride_age' => $request->bride_age,
            'groom_address' => $request->groom_address,
            'bride_address' => $request->bride_address,
            'groom_parents' => $request->groom_parents,
            'bride_parents' => $request->bride_parents,
            'parent' => $parent,
            'status' => 'is_pending',
        ]);
    
        // Generate marriage entry content
        $marriageEntries = $this->generateMarriageContent($request);
    
        $user_role = Auth::user() ? Auth::user()->role : 'N/A';
        $status = $user_role === 'parish_priest' ? 'is_posted' : 'is_pending';

        Announcement::create([
            'title' => $request->marriage_bann,
            'content' => $marriageEntries,
            'parent' => $parent,
            'announcement_type' => $request->announcement_type,
            'status' => $status,
        ]);
    
        return response()->json(['success' => 'Announcement saved successfully!', 'marriage' => $marriage]);
    }
    
    /**
     * Update an existing marriage announcement.
     */
    public function updateMarriage(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Get the associated marriage record
        $marriage = Marriage::where('parent', $announcement->parent)
            ->where('announcement_type', $announcement->announcement_type)
            ->first();
            
        if (!$marriage) {
            return response()->json(['error' => 'Marriage record not found'], 404);
        }
        
        // Update the marriage record
        $marriage->update([
            'announcement_type' => $request->announcement_type,
            'marriage_bann' => $request->marriage_bann,
            'groom_name' => $request->groom_name,
            'bride_name' => $request->bride_name,
            'groom_age' => $request->groom_age,
            'bride_age' => $request->bride_age,
            'groom_address' => $request->groom_address,
            'bride_address' => $request->bride_address,
            'groom_parents' => $request->groom_parents,
            'bride_parents' => $request->bride_parents,
            'status' => $request->status,
        ]);
        
        // Update the announcement
        $announcement->update([
            'title' => $request->marriage_bann,
            'content' => $this->generateMarriageContent($request),
            'status' => $request->status,
        ]);
    
        return response()->json(['success' => 'Announcement updated successfully!', 'marriage' => $marriage]);
    }
    
    /**
     * Generate marriage entry content as an HTML table.
     */
    private function generateMarriageContent($request)
    {
        return '<table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4>Groom Information</h4>
                    <strong>Groom name:</strong> ' . $request->groom_name . '<br>
                    <strong>Groom age:</strong> ' . $request->groom_age . '<br>
                    <strong>Groom address:</strong> ' . $request->groom_address . '<br>
                    <strong>Groom parents name:</strong> ' . $request->groom_parents . '<br>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4>Bride Information</h4>
                    <strong>Bride name:</strong> ' . $request->bride_name . '<br>
                    <strong>Bride age:</strong> ' . $request->bride_age . '<br>
                    <strong>Bride address:</strong> ' . $request->bride_address . '<br>
                    <strong>Bride parents name:</strong> ' . $request->bride_parents . '<br>
                </td>
            </tr>
        </table>';
    }


    public function editPublic($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('pages.create_announcement.public_announce_edit', compact('announcement'));
    }

    public function updatePublic(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_type' => $request->announcement_type,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    public function storePublic(Request $request)
    {
        $data = Announcement::where('announcement_type', $request->announcement_type)
        ->orderBy('parent', 'desc')
        ->first();
        $parent = 1;
        if ($data) {
            $parent = (int)$data->parent + 1;
        }
        $user_role = Auth::user() ? Auth::user()->role : 'N/A';
        $status = $user_role === 'parish_priest' ? 'is_posted' : 'is_pending';

        // Create a new announcement
        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_type' => $request->announcement_type,
            'parent' => $parent,
            'status' => $status,
        ]);

        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     */

    public function editMarriage($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Get the associated marriage record
        $marriage = Marriage::where('parent', $announcement->parent)
            ->where('announcement_type', $announcement->announcement_type)
            ->first();
            
        if (!$marriage) {
            return redirect()->route('anouncements')->with('error', 'Marriage record not found');
        }
        
        return view('pages.create_announcement.marriage_edit', compact('announcement', 'marriage'));
    }


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

    public function editDonor($id)
    {
        // Fetch the announcement
        $announcement = Announcement::findOrFail($id);

        // Fetch the donors related to this announcement
        $donors = Donor::where('parent', $announcement->parent)->get();

        return view('pages.create_announcement.project_financial_edit', compact('announcement', 'donors'));
    }



    public function updateDonor(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        // Update Announcement details
        $announcement->update([
            'title' => $request->project_name,
            'announcement_type' => $request->announcement_type,
            'status' => $request->status,
        ]);

        // Delete existing donors for this announcement
        Donor::where('parent', $announcement->parent)->delete();

        // Store updated donors
        $donorEntries = [];
        $short = 1;

        foreach ($request->donors as $donor) {
            Donor::create([
                'announcement_type' => $request->announcement_type,
                'project_name' => $request->project_name,
                'donor_name' => $donor['donor_name'],
                'donated_amount' => $donor['donated_amount'],
                'parent' => $announcement->parent,
                'short' => $short++,
                'status' => $request->status,
            ]);

            // Add donor data for announcement content
            $donorEntries[] = '<li><strong>Donor name:</strong> ' . $donor['donor_name'] . ' - ₱ ' . number_format($donor['donated_amount'], 2) . '</li>';
        }

        // Update Announcement content
        $announcement->update([
            'content' => '<ul>' . implode('', $donorEntries) . '</ul>',
        ]);

        return response()->json(['message' => 'Announcement updated successfully!']);
    }
}

