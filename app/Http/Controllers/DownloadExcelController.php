<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Exports\PriestReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DownloadExcelController extends Controller
{
    public function generatePriestReport(Request $request)
    {
        // Get the required data first
        $priestId = $request->input('priest_id');
        $year = $request->input('year');
        $month = $request->input('month');
        $date_range = $request->input('date_range');
        $purpose = $request->input('purpose', 'all');

        // Log input parameters
        Log::info('Input Parameters:', [
            'priestId' => $priestId,
            'year' => $year,
            'purpose' => $purpose
        ]);

        // Check if view exists
        $viewExists = DB::select("SELECT * FROM information_schema.views WHERE table_name = 'schedule_events_view_v2'");
        Log::info('View exists:', ['exists' => !empty($viewExists)]);

        // First check if there's any data in the view at all
        $totalRecords = DB::table('schedule_events_view_v2')->count();
        Log::info('Total records in view:', ['count' => $totalRecords]);

        // Check records for this priest
        $priestRecords = DB::table('schedule_events_view_v2')
            ->where('assign_to', $priestId)
            ->count();
        Log::info('Records for priest:', ['priestId' => $priestId, 'count' => $priestRecords]);

        // Build the main query
        $query = DB::table('schedule_events_view_v2')
            ->select(
                'schedule_events_view_v2.assign_to_name',
                'schedule_events_view_v2.created_by_name',
                'schedule_events_view_v2.purpose',
                'schedule_events_view_v2.date',
                'schedule_events_view_v2.time_from',
                'schedule_events_view_v2.time_to',
                'schedule_events_view_v2.venue',
                'schedule_events_view_v2.address',
                'schedule_events_view_v2.status'
            )
            ->where('schedule_events_view_v2.status', 4);

        if ($priestId) {
            $query->where('schedule_events_view_v2.assign_to', $priestId);
        }

        if ($purpose !== 'all') {
            $query->where('schedule_events_view_v2.purpose', $purpose);
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

        // Log the final SQL query
        Log::info('Final SQL:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $priestReports = $query->get();
        Log::info('Query Results:', ['count' => $priestReports->count(), 'data' => $priestReports]);

        // Build dynamic filename
        $fileName = 'priest_report_';
        
        // Add priest name (get from first record if exists)
        if ($priestId) {
            $fileName .= str_replace(' ', '_', $priestReports->first()->assign_to_name) . '_';
        }
        
        // Add purpose if specified
        if ($purpose !== 'all') {
            $fileName .= str_replace(' ', '_', $purpose) . '_';
        }
        
        // Add year
        if ($year) {
            $fileName .= $year;
        }
        
        // Add month if specified
        if ($month) {
            $fileName .= '_' . str_pad($month, 2, '0', STR_PAD_LEFT);
        }
        
        // Add date range if specified
        if ($date_range) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start = date('M_d_Y', strtotime($start_date)); // Format: Apr_20_2025
            $end = date('M_d_Y', strtotime($end_date));     // Format: Apr_30_2025
            $fileName .= '_' . $start . '_to_' . $end;
        }
        
        $fileName .= '.xlsx';

        Excel::store(new PriestReportExport($priestReports), $fileName, 'public');
        return response()->json(['file' => asset('storage/' . $fileName)]);
    }
}
