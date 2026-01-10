<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::latest()->get();
        return view('admin.tahun.index', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $isActive = $request->has('is_active');

        if ($isActive) {
            // Nonaktifkan semua tahun ajaran lain
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjaran::create([
            'nama' => $request->nama,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.tahun.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function updateStatus($id)
    {
        $tahun = TahunAjaran::findOrFail($id);

        if (!$tahun->is_active) {
            // Jika mau mengaktifkan, nonaktifkan yang lain dulu
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
            $tahun->update(['is_active' => true]);
        } else {
            // Jika mau menonaktifkan
            $tahun->update(['is_active' => false]);
        }

        return redirect()->route('admin.tahun.index')->with('success', 'Status tahun ajaran diperbarui.');
    }
    
    public function destroy($id)
    {
        $tahun = TahunAjaran::findOrFail($id);
        $tahun->delete();
        
        return redirect()->route('admin.tahun.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
