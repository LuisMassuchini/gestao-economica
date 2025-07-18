<?php

namespace App\Http\Controllers;

use App\Models\ExportedReport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExportedReportController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $reports = $user->exportedReports()->latest()->paginate(10);
        return view('my-reports.index', compact('reports'));
    }

    public function download(ExportedReport $report)
    {
        // Garantir que o utilizador só pode descarregar os seus próprios relatórios
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        return Storage::download($report->file_path);
    }
}
