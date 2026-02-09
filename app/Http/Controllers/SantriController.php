<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SantriController extends Controller
{
    public function dashboard()
    {
        $registration = Registration::where('user_id', Auth::id())->firstOrFail();
        return view('santri.dashboard', compact('registration'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    public function update(Request $request)
    {
        Log::info('Update Biodata Santri Request:', $request->all());

        $request->validate([
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nisn' => 'required|string',
            'nik' => 'required|string',
            'alamat' => 'required|string',
            'asal_sekolah' => 'required|string',
            'anak_ke' => 'required|numeric',
            'jumlah_saudara' => 'required|numeric',
        
            'no_kk' => 'required|string', 
            'nama_ayah' => 'required|string',
            'nik_ayah' => 'required|string',
            'umur_ayah' => 'required|numeric',
            'tempat_lahir_ayah' => 'required|string',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_terakhir_ayah' => 'required|string',
            'alamat_lengkap_ayah' => 'required|string',
            'no_hp_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'kode_pos' => 'required|string',

            // Data Ibu
            'nama_ibu' => 'required|string',
            'nik_ibu' => 'required|string',
            'umur_ibu' => 'required|numeric',
            'tempat_lahir_ibu' => 'required|string',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_terakhir_ibu' => 'required|string',
            'alamat_lengkap_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'no_hp_ibu' => 'required|string',

            // Berkas
            'file_biodata' => 'nullable|file|mimes:pdf|max:2048',
            'file_rapor' => 'nullable|file|mimes:pdf|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf|max:2048',
            'file_skl' => 'nullable|file|mimes:pdf|max:2048',
            'file_akta_kelahiran' => 'nullable|file|mimes:pdf|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf|max:2048',
            'file_pas_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'file_ktp_ayah' => 'nullable|file|mimes:pdf|max:2048',
            'file_ktp_ibu' => 'nullable|file|mimes:pdf|max:2048',
            'file_kip' => 'nullable|file|mimes:pdf|max:2048',
            'file_bpjs' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $registration = Registration::where('user_id', Auth::id())->firstOrFail();

        if ($registration->is_locked) {
            return redirect()->route('santri.dashboard')->withErrors(['error' => 'Data sudah dikunci dan tidak dapat diubah.']);
        }

        $data = $request->except([
                    'file_biodata',
                    'file_rapor',
                    'file_ijazah',
                    'file_skl',
                    'file_akta_kelahiran',
                    'file_kk',
                    'file_pas_foto',
                    'file_ktp_ayah',
                    'file_ktp_ibu',
                    'file_kip',
                    'file_bpjs',
                    '_token',
                    '_method'
                ]);
                
        // Lock the data
        $data['is_locked'] = true;

        if ($request->hasFile('file_biodata')) {

            $fileBio = $request->file('file_biodata');

            $renameBio = uniqid() . '_' . $fileBio->getClientOriginalName();

            if ($registration->file_biodata) File::delete('Berkas/' . $registration->file_biodata);

            $fileBio->move('Berkas', $renameBio);
            
            $data['file_biodata'] = $renameBio; 
        }

        if ($request->hasFile('file_rapor')) {

            $fileRapor = $request->file('file_rapor');

            $renameRapor = uniqid() . '_' . $fileRapor->getClientOriginalName();

            if ($registration->file_rapor) File::delete('Berkas/' . $registration->file_rapor);

            $fileRapor->move('Berkas', $renameRapor);

            $data['file_rapor'] = $renameRapor; 
        }

        if ($request->hasFile('file_ijazah')) {

            $fileIjazah = $request->file('file_ijazah');

            $renameIjazah = uniqid() . '_' . $fileIjazah->getClientOriginalName();

            if ($registration->file_ijazah) File::delete('Berkas/' . $registration->file_ijazah);

            $fileIjazah->move('Berkas', $renameIjazah);

            $data['file_ijazah'] = $renameIjazah; 
        }

        if ($request->hasFile('file_skl')) {

            $fileSkl = $request->file('file_skl');

            $renameSkl = uniqid() . '_' . $fileSkl->getClientOriginalName();

            if ($registration->file_skl) File::delete('Berkas/' . $registration->file_skl);

            $fileSkl->move('Berkas', $renameSkl);

            $data['file_skl'] = $renameSkl; 
        }

        if ($request->hasFile('file_akta_kelahiran')) {

            $fileAkta = $request->file('file_akta_kelahiran');

            $renameAkta = uniqid() . '_' . $fileAkta->getClientOriginalName();

            if ($registration->file_akta_kelahiran) File::delete('Berkas/' . $registration->file_akta_kelahiran);

            $fileAkta->move('Berkas', $renameAkta);

            $data['file_akta_kelahiran'] = $renameAkta; 
        }

        if ($request->hasFile('file_kk')) {

            $fileKK = $request->file('file_kk');

            $renameKK = uniqid() . '_' . $fileKK->getClientOriginalName();

            if ($registration->file_kk) File::delete('Berkas/' . $registration->file_kk);

            $fileKK->move('Berkas', $renameKK);

            $data['file_kk'] = $renameKK; 
        }


        if ($request->hasFile('file_pas_foto')) {

            $filePasFoto = $request->file('file_pas_foto');

            $renamePasFoto = uniqid() . '_' . $filePasFoto->getClientOriginalName();

            if ($registration->file_pas_foto) File::delete('Berkas/' . $registration->file_pas_foto);

            $filePasFoto->move('Berkas', $renamePasFoto);

            $data['file_pas_foto'] = $renamePasFoto; 
        }

        if ($request->hasFile('file_ktp_ayah')) {

            $fileKtpAyah = $request->file('file_ktp_ayah');

            $renameKtpAyah = uniqid() . '_' . $fileKtpAyah->getClientOriginalName();

            if ($registration->file_ktp_ayah) File::delete('Berkas/' . $registration->file_ktp_ayah);

            $fileKtpAyah->move('Berkas', $renameKtpAyah);

            $data['file_ktp_ayah'] = $renameKtpAyah; 
        }

        if ($request->hasFile('file_ktp_ibu')) {

            $fileKtpIbu = $request->file('file_ktp_ibu');

            $renameKtpIbu = uniqid() . '_' . $fileKtpIbu->getClientOriginalName();

            if ($registration->file_ktp_ibu) File::delete('Berkas/' . $registration->file_ktp_ibu);

            $fileKtpIbu->move('Berkas', $renameKtpIbu);

            $data['file_ktp_ibu'] = $renameKtpIbu; 
        }

        if ($request->hasFile('file_kip')) {

            $fileKip = $request->file('file_kip');

            $renameKip = uniqid() . '_' . $fileKip->getClientOriginalName();

            if ($registration->file_kip) File::delete('Berkas/' . $registration->file_kip);

            $fileKip->move('Berkas', $renameKip);

            $data['file_kip'] = $renameKip; 
        }

        if ($request->hasFile('file_bpjs')) {

            $fileBpjs = $request->file('file_bpjs');

            $renameBpjs = uniqid() . '_' . $fileBpjs->getClientOriginalName();

            if ($registration->file_bpjs) File::delete('Berkas/' . $registration->file_bpjs);

            $fileBpjs->move('Berkas', $renameBpjs);

            $data['file_bpjs'] = $renameBpjs; 
        }

        // if ($request->hasFile('kk_file')) {
        //     if ($registration->kk_file) Storage::delete('public/' . $registration->kk_file);
        //     $data['kk_file'] = $request->file('kk_file')->store('uploads/berkas', 'public');
        // }

        // if ($request->hasFile('akte_file')) {
        //     if ($registration->akte_file) Storage::delete('public/' . $registration->akte_file);
        //     $data['akte_file'] = $request->file('akte_file')->store('uploads/berkas', 'public');
        // }

        // if ($request->hasFile('ijazah_file')) {
        //     if ($registration->ijazah_file) Storage::delete('public/' . $registration->ijazah_file);
        //     $data['ijazah_file'] = $request->file('ijazah_file')->store('uploads/berkas', 'public');
        // }

        $registration->update($data);

        return redirect()->route('santri.dashboard')->with('successLengkapiBerkas', 'Data berhasil diperbarui.');
    }
}
