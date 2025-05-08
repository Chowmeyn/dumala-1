<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PriestReportExport;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class DownloadExcelController extends Controller
{
    public function downloadPriestReport(Request $request)
    {
        try {
            $priestId = $request->input('priest_id');
            $year = $request->input('year');

            $priestReports = Schedule::select(
                'users.name as priest_name',
                'schedules.purpose',
                'schedules.date',
                'schedules.time_from',
                'schedules.time_to',
                'schedules.venue',
                'schedules.status'
            )
            ->join('users', 'schedules.assign_to', '=', 'users.id')
            ->where('users.id', $priestId)
            ->whereYear('schedules.date', $year)
            ->get();

            $fileName = 'priest_report_' . $year . '.xlsx';
            
            $export = new PriestReportExport($priestReports);
            return $export->export($fileName);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating report: ' . $e->getMessage());
        }
    }
}
