<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function dashboard()
    {
        $registration = Registration::where('user_id', Auth::id())->firstOrFail();
        return view('santri.dashboard', compact('registration'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nisn' => 'required|string',
            'nik' => 'required|string',
            'alamat' => 'required|string',
            'asal_sekolah' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'no_hp_wali' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'kk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akte_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $registration = Registration::where('user_id', Auth::id())->firstOrFail();

        if ($registration->is_locked) {
            return redirect()->route('santri.dashboard')->withErrors(['error' => 'Data sudah dikunci dan tidak dapat diubah.']);
        }

        $data = $request->except(['foto', 'kk_file', 'akte_file', 'ijazah_file', '_token', '_method']);
        
        // Lock the data
        $data['is_locked'] = true;

        if ($request->hasFile('foto')) {
            if ($registration->foto) Storage::delete('public/' . $registration->foto);
            $data['foto'] = $request->file('foto')->store('uploads/foto', 'public');
        }

        if ($request->hasFile('kk_file')) {
            if ($registration->kk_file) Storage::delete('public/' . $registration->kk_file);
            $data['kk_file'] = $request->file('kk_file')->store('uploads/berkas', 'public');
        }

        if ($request->hasFile('akte_file')) {
            if ($registration->akte_file) Storage::delete('public/' . $registration->akte_file);
            $data['akte_file'] = $request->file('akte_file')->store('uploads/berkas', 'public');
        }

        if ($request->hasFile('ijazah_file')) {
            if ($registration->ijazah_file) Storage::delete('public/' . $registration->ijazah_file);
            $data['ijazah_file'] = $request->file('ijazah_file')->store('uploads/berkas', 'public');
        }

        $registration->update($data);

        return redirect()->route('santri.dashboard')->with('success', 'Data berhasil diperbarui.');
    }
}
