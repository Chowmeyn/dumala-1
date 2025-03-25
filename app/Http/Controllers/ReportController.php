<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Announcement;
use App\Models\Marriage;

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
    
        foreach ($request->donors as $donor) {
            // Create the Donor entry
            Donor::create([
                'announcement_type' => $request->announcement_type,
                'project_name' => $request->project_name,
                'donor_name' => $donor['donor_name'],
                'donated_amount' => $donor['donated_amount'],
                'parent' => $parent,
                'short' => $short++,
                'status' => 'is_pending',
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
            'status' => 'is_pending',
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
    
        Announcement::create([
            'title' => $request->marriage_bann,
            'content' => $marriageEntries,
            'parent' => $parent,
            'announcement_type' => $request->announcement_type,
            'status' => 'is_pending',
        ]);
    
        return response()->json(['success' => 'Announcement saved successfully!', 'marriage' => $marriage]);
    }
    
    /**
     * Update an existing marriage announcement.
     */
    public function updateMarriage(Request $request, $id)
    {
        $marriage = Marriage::findOrFail($id);
    
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
            'status' => $request->status, // Allow status update
        ]);
    
        // Update related Announcement
        $announcement = Announcement::where('parent', $marriage->parent)
            ->where('announcement_type', $request->announcement_type)
            ->first();
    
        if ($announcement) {
            $announcement->update([
                'title' => $request->marriage_bann,
                'content' => $this->generateMarriageContent($request),
                'status' => $request->status,
            ]);
        }
    
        return response()->json(['success' => 'Announcement updated '.$marriage->parent.' - '.$request->announcement_type.' successfully!', 'marriage' => $marriage]);
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
        // Create a new announcement
        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_type' => $request->announcement_type,
            'parent' => $parent,
            'status' => 'is_pending',
        ]);

        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     */

    public function editMarriage($id)
    {
        $announcement = Marriage::findOrFail($id);
        return view('pages.create_announcement.marriage_edit', compact('announcement'));
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
