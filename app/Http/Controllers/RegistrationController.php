<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;


class RegistrationController extends Controller
{
    public function index()
    {
        $pendaftar = Registration::with('user')->latest()->get();
        $tahunAjarans = TahunAjaran::latest()->get();
        return view('admin.pendaftar.index', compact('pendaftar', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'wa' => 'required|string|max:20',
            'tahun_ajaran' => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Mohon lengkapi semua field dengan benar.'
            ], 422);
        }

        // Create User
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'santri',
        ]);

        // Create Registration linked to User
        $registration = Registration::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jenjang' => $request->jenjang,
            'email' => $request->email,
            'wa' => $request->wa,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => 'pending'
        ]);

        // Optional: Auto login
        // Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil diterima. Silakan login menggunakan email dan password yang didaftarkan.',
            'data' => $registration
        ]);
    }

    public function show($id)
    {
        $pendaftar = Registration::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.pendaftar.show', compact('pendaftar'))->render();
        }
        return redirect()->route('admin.pendaftar.index');
    }

    public function update(Request $request, $id)
    {
        $pendaftar = Registration::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,incomplete_file,reject,accept',
        ]);

        $pendaftar->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status berhasil diperbarui!',
            'data' => $pendaftar
        ]);
    }

    public function massUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:registrations,id',
            'action' => 'required|string',
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $message = '';

        if ($action == 'delete') {
            $registrations = Registration::whereIn('id', $ids)->get();
            foreach ($registrations as $reg) {
                $userId = $reg->user_id;
                $reg->delete();
                if ($userId) {
                    User::where('id', $userId)->delete();
                }
            }
            $message = 'Data pendaftar terpilih berhasil dihapus!';
        } elseif (in_array($action, ['pending', 'accept', 'reject', 'incomplete_file'])) {
             Registration::whereIn('id', $ids)->update(['status' => $action]);
             $message = 'Status pendaftar terpilih berhasil diperbarui!';
        } else {
             return response()->json(['status' => 'error', 'message' => 'Aksi tidak valid.'], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function destroy($id)
    {
        $pendaftar = Registration::findOrFail($id);
        $user = User::find($pendaftar->user_id);
        
        $pendaftar->delete();
        
        if ($user) {
            $user->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data pendaftar berhasil dihapus!'
        ]);
    }

        public function detail($id)
    {

        $pendaftar = Registration::findOrFail($id);

        return view('admin.pendaftar.detail', [
            'data' => $pendaftar,
        ]);
    }

        public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,incomplete_file,reject,accept',
            'keterangan' => 'nullable|max:250',
        ]);

        $registration = Registration::findOrFail($id);

        $registration->update($validated);

        return back()->with('success', 'Berhasil mengubah status pendaftaran santri');
    }

        public function edit($id)
    {
        $data = Registration::findOrFail($id);

        return view('admin.pendaftar.edit', [
            'data' => $data,
        ]);
    }

        public function updateDataRegister(Request $request, $id)
    {

        $request->validate([

            'password' => 'nullable|string|max:30',

            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nisn' => 'required|string',
            'nik' => 'required|string',
            'alamat' => 'required|string',
            'asal_sekolah' => 'required|string',
            'anak_ke' => 'required|numeric',
            'jumlah_saudara' => 'required|numeric',
            'is_locked' => 'required',

            // =========================================

            // 'nama_ayah' => 'required|string',
            // 'nama_ibu' => 'required|string',
            // 'no_hp_wali' => 'required|string',
            // 'foto' => 'nullable|image|max:2048',
            // 'kk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // 'akte_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // 'ijazah_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Data Orang Tua
            // Data Ayah
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
            'kode_pos' => 'nullable|string',

            // Data Ibu
            'nama_ibu' => 'required|string',
            'nik_ibu' => 'required|string',
            'umur_ibu' => 'required|numeric',
            'tempat_lahir_ibu' => 'required|string',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_terakhir_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'alamat_lengkap_ibu' => 'required|string',
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

        $registration = Registration::where('id', $id)->firstOrFail();

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
            'password',
            '_token',
            '_method',
        ]);
        
        if ($request->hasFile('file_biodata')) {

            $fileBio = $request->file('file_biodata');

            $renameBio = uniqid().'_'.$fileBio->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_biodata);
            }

            $fileBio->move('Berkas', $renameBio);

            $data['file_biodata'] = $renameBio;
        }

        if ($request->hasFile('file_rapor')) {

            $fileRapor = $request->file('file_rapor');

            $renameRapor = uniqid().'_'.$fileRapor->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_rapor);
            }

            $fileRapor->move('Berkas', $renameRapor);

            $data['file_rapor'] = $renameRapor;
        }

        if ($request->hasFile('file_ijazah')) {

            $fileIjazah = $request->file('file_ijazah');

            $renameIjazah = uniqid().'_'.$fileIjazah->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_ijazah);
            }

            $fileIjazah->move('Berkas', $renameIjazah);

            $data['file_ijazah'] = $renameIjazah;
        }

        if ($request->hasFile('file_skl')) {

            $fileSkl = $request->file('file_skl');

            $renameSkl = uniqid().'_'.$fileSkl->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_skl);
            }

            $fileSkl->move('Berkas', $renameSkl);

            $data['file_skl'] = $renameSkl;
        }

        if ($request->hasFile('file_akta_kelahiran')) {

            $fileAkta = $request->file('file_akta_kelahiran');

            $renameAkta = uniqid().'_'.$fileAkta->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_akta_kelahiran);
            }

            $fileAkta->move('Berkas', $renameAkta);

            $data['file_akta_kelahiran'] = $renameAkta;
        }

        if ($request->hasFile('file_kk')) {

            $fileKK = $request->file('file_kk');

            $renameKK = uniqid().'_'.$fileKK->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_kk);
            }

            $fileKK->move('Berkas', $renameKK);

            $data['file_kk'] = $renameKK;
        }

        if ($request->hasFile('file_pas_foto')) {

            $filePasFoto = $request->file('file_pas_foto');

            $renamePasFoto = uniqid().'_'.$filePasFoto->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_pas_foto);
            }

            $filePasFoto->move('Berkas', $renamePasFoto);

            $data['file_pas_foto'] = $renamePasFoto;
        }

        if ($request->hasFile('file_ktp_ayah')) {

            $fileKtpAyah = $request->file('file_ktp_ayah');

            $renameKtpAyah = uniqid().'_'.$fileKtpAyah->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_ktp_ayah);
            }

            $fileKtpAyah->move('Berkas', $renameKtpAyah);

            $data['file_ktp_ayah'] = $renameKtpAyah;
        }

        if ($request->hasFile('file_ktp_ibu')) {

            $fileKtpIbu = $request->file('file_ktp_ibu');

            $renameKtpIbu = uniqid().'_'.$fileKtpIbu->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_ktp_ibu);
            }

            $fileKtpIbu->move('Berkas', $renameKtpIbu);

            $data['file_ktp_ibu'] = $renameKtpIbu;
        }

        if ($request->hasFile('file_kip')) {

            $fileKip = $request->file('file_kip');

            $renameKip = uniqid().'_'.$fileKip->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_kip);
            }

            $fileKip->move('Berkas', $renameKip);

            $data['file_kip'] = $renameKip;
        }

        if ($request->hasFile('file_bpjs')) {

            $fileBpjs = $request->file('file_bpjs');

            $renameKip = uniqid().'_'.$fileBpjs->getClientOriginalName();

            if ($registration->foto) {
                File::delete('Berkas/'.$registration->file_bpjs);
            }

            $fileBpjs->move('Berkas', $renameKip);

            $data['file_bpjs'] = $renameKip;
        }

        $registration->update($data);
        if ($request->password) {
            $user = User::where('id', $registration->user_id)->firstOrFail();

            $user->password = $request->password;
            $user->save();
        }

        return back()->with('success', 'Berhasil mengupdate data');
    }

        public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'password' => 'required|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Berhasil mengubah password');
    }

    public function updateStatusPembayaran(Request $request, $id) {

        $validated = $request->validate([
            'status_pembayaran' => 'required'
        ]);

        $registration = Registration::findOrFail($id);

        $registration->update($validated);

        return back()->with('success', 'Berhasil mengupdate status pembayaran');

    }

    public function dokPendaftaran($id) {
        $data = Registration::findOrFail($id);

    $pdf = Pdf::loadView('admin.pendaftar.dok_pendaftaran', [
        'data' => $data,
    ])->setPaper('A4', 'portrait');

    return $pdf->stream('formulir-pendaftaran.pdf');   
    }

    public function dokPernyataan($id) {
        $data = Registration::findOrFail($id);

        $pdf = Pdf::loadView('admin.pendaftar.dok_pernyataan', [
            'data' => $data
        ])
        ->setPaper('A4', 'portrait');

        return $pdf->stream('formulir-pernyataan-dummy.pdf');

    }

    public function dokJanjiSantri($id) {
        $data = Registration::findOrFail($id);

        return Pdf::loadView(
            'admin.pendaftar.dok_janji_santri',
            compact('data')
        )->stream('surat-pernyataan-dan-janji-santri.pdf');
    }

    public function dokSyaratPendaftaran() {
        return Pdf::loadView(
            'admin.pendaftar.dok_syarat_pendaftaran'
        )->setPaper('A4', 'portrait')
            ->stream('syarat-pendaftaran.pdf');
    }

    public function export(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required',
        ]);

        $query = Registration::query();

        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $registrations = $query->get();

        if ($registrations->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diexport.');
        }

        $jenis = $request->jenis_dokumen;

        // Jika user memilih laporan list (Excel/PDF List)
        if ($jenis === 'laporan_list') {
             // Redirect ke controller laporan untuk print
             return redirect()->route('admin.laporan.print', $request->all());
        }

        // Untuk export dokumen massal (ZIP)
        $zipFileName = 'export-' . $jenis . '-' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
        
        // Pastikan folder exists
        if (!File::exists(storage_path('app/public'))) {
            File::makeDirectory(storage_path('app/public'), 0755, true);
        }

        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($registrations as $reg) {
                $pdf = null;
                $filename = '';
                $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', $reg->nama);

                try {
                    if ($jenis === 'formulir_pendaftaran') {
                        $pdf = Pdf::loadView('admin.pendaftar.dok_pendaftaran', ['data' => $reg])->setPaper('A4', 'portrait');
                        $filename = 'Formulir_' . $safeName . '_' . $reg->id . '.pdf';
                    } elseif ($jenis === 'dokumen_pernyataan') {
                         $pdf = Pdf::loadView('admin.pendaftar.dok_pernyataan', ['data' => $reg])->setPaper('A4', 'portrait');
                         $filename = 'Pernyataan_' . $safeName . '_' . $reg->id . '.pdf';
                    } elseif ($jenis === 'janji_santri') {
                         $pdf = Pdf::loadView('admin.pendaftar.dok_janji_santri', ['data' => $reg]);
                         $filename = 'Janji_' . $safeName . '_' . $reg->id . '.pdf';
                    }

                    if ($pdf) {
                        $zip->addFromString($filename, $pdf->output());
                    }
                } catch (\Exception $e) {
                    // Skip failed PDFs or log error
                    continue;
                }
            }
            $zip->close();
        }

        if (File::exists($zipPath)) {
            return response()->download($zipPath)->deleteFileAfterSend(true);
        } else {
             return back()->with('error', 'Gagal membuat file export.');
        }
    }
}
