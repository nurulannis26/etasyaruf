<?php

namespace App\Http\Controllers;

use App\Exports\DataTableExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportToExcel()
    {
        return Excel::download(new DataTableExport(), 'data.xlsx');
    }
}
