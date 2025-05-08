<?php

namespace App\Exports;

use Rap2Hpoutre\FastExcel\FastExcel;

class PriestReportExport
{
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function export($fileName)
    {
        return (new FastExcel($this->reports))->download($fileName, function ($item) {
            return [
                'Priest Name' => $item->priest_name,
                'Purpose' => $item->purpose,
                'Date' => $item->date,
                'Time' => $item->time_from . ' - ' . $item->time_to,
                'Venue' => $item->venue,
                'Status' => $this->getStatusText($item->status)
            ];
        });
    }

    private function getStatusText($status)
    {
        switch ($status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Accepted';
            case 3:
                return 'Declined';
            case 4:
                return 'Complete';
            case 5:
                return 'Archived';
            default:
                return 'Accepted by priest';
        }
    }
}