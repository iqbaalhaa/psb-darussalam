<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjarans = TahunAjaran::latest()->get();
        
        $query = Registration::with('user');

        // Filter Tahun Ajaran (Match exact string if stored as string "2025/2026", or ID if relation)
        // Based on RegistrationController/Dashboard, it seems 'tahun_ajaran' might be stored directly or implied.
        // Let's check Registration migration/model to be sure. 
        // For now assuming 'tahun_ajaran' column exists or we filter by created_at year.
        // Wait, I should check the Registration model first to see how year is stored. 
        // In dashboard: Registration::where('tahun_ajaran', date('Y'))->count(); 
        // So it seems 'tahun_ajaran' column exists.

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $laporan = $query->latest()->paginate(10);

        return view('admin.laporan.index', compact('laporan', 'tahunAjarans'));
    }

    public function print(Request $request)
    {
        $query = Registration::with('user');

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $laporan = $query->latest()->get();
        $filters = $request->all();

        $pdf = Pdf::loadView('admin.laporan.print', compact('laporan', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-psb-' . date('Y-m-d') . '.pdf');
    }
}
