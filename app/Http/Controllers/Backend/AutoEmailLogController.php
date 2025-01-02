<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AutoEmailLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AutoEmailLogController extends Controller
{
    public function autoEmailLogs(): View
    {
        return view('backend.mail.auto_email_logs');
    }

    public function export(Request $request, $type = null)
    {
        $records = AutoEmailLog::select('*');
        if ($type == null) {
            $records->whereDate('created_at', '>=', $request->get('start_date'));
            $records->whereDate('created_at', '<=', $request->get('end_date'));
        }
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'S. No.');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Date');
        $sheet->setCellValue('F1', 'Time');
        $sheet->setCellValue('G1', 'Subject');
        $sheet->setCellValue('H1', 'Script');
        $sheet->setCellValue('I1', 'Body');
        $i = 2;
        foreach ($records->get() as $key => $item) {
            $user = $item->user;
            $sheet->setCellValue("A$i", $key + 1);
            $sheet->setCellValue("B$i", getFullName($user));
            $sheet->setCellValue("C$i", $user->email ?? 'NA');
            $sheet->setCellValue("D$i", $user->phone_no ?? 'NA');
            $sheet->setCellValue("E$i", date('Y-m-d', strtotime($item->created_at)));
            $sheet->setCellValue("F$i", date('H:i:s', strtotime($item->created_at)));
            $sheet->setCellValue("G$i", $item->email_subject);
            $sheet->setCellValue("H$i", $item->source_script);
            $sheet->setCellValue("I$i", $item->message);
            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        $fileName = 'auto_email_logs_'.date('Y-m-d').'.xls';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }
}
