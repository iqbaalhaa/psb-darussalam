<?php

namespace App\Http\Controllers;

use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeSettingController extends Controller
{
    public function edit()
    {
        $setting = HomeSetting::first();

        return view('admin.home_settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_lead' => ['nullable', 'string'],
            'hero_muted' => ['nullable', 'string'],
            'wa_number_display' => ['nullable', 'string', 'max:50'],
            'wa_number_e164' => ['nullable', 'string', 'max:20'],
            'wa_default_text' => ['nullable', 'string'],
            'brochure_url' => ['nullable', 'string', 'max:255'],
            'hero_chip_location' => ['nullable', 'string', 'max:255'],
            'hero_chip_jenjang' => ['nullable', 'string', 'max:255'],
            'hero_chip_program' => ['nullable', 'string', 'max:255'],
            'biaya_formal_total' => ['nullable', 'string', 'max:255'],
            'biaya_nonformal_total' => ['nullable', 'string', 'max:255'],
            'biaya_formal_items' => ['nullable', 'string'],
            'biaya_nonformal_items' => ['nullable', 'string'],
            'syarat_umum_items' => ['nullable', 'string'],
            'berkas_items' => ['nullable', 'string'],
            'jadwal_title' => ['nullable', 'string', 'max:255'],
            'jadwal_subtitle' => ['nullable', 'string'],
            'jadwal_note' => ['nullable', 'string'],
            'jadwal_gelombang' => ['sometimes', 'array'],
            'jadwal_gelombang.*' => ['nullable', 'string', 'max:255'],
            'jadwal_pendaftaran' => ['sometimes', 'array'],
            'jadwal_pendaftaran.*' => ['nullable', 'string', 'max:255'],
            'jadwal_tes' => ['sometimes', 'array'],
            'jadwal_tes.*' => ['nullable', 'string', 'max:255'],
            'jadwal_pengumuman' => ['sometimes', 'array'],
            'jadwal_pengumuman.*' => ['nullable', 'string', 'max:255'],
            'jadwal_kuota' => ['sometimes', 'array'],
            'jadwal_kuota.*' => ['nullable', 'string', 'max:50'],
            'program_title' => ['nullable', 'string', 'max:255'],
            'program_subtitle' => ['nullable', 'string'],
            'visi_1' => ['nullable', 'string'],
            'visi_2' => ['nullable', 'string'],
            'misi_items' => ['sometimes', 'array'],
            'misi_items.*' => ['nullable', 'string', 'max:255'],
            'misi_target' => ['nullable', 'string'],
            'unggulan_program_items' => ['sometimes', 'array'],
            'unggulan_program_items.*' => ['nullable', 'string', 'max:255'],
            'unggulan_kegiatan_items' => ['sometimes', 'array'],
            'unggulan_kegiatan_items.*' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->has('jadwal_gelombang')) {
            $gel = $request->input('jadwal_gelombang', []);
            $pendaftaran = $request->input('jadwal_pendaftaran', []);
            $tes = $request->input('jadwal_tes', []);
            $pengumuman = $request->input('jadwal_pengumuman', []);
            $kuota = $request->input('jadwal_kuota', []);
            $rows = [];
            $count = max(count($gel), count($pendaftaran), count($tes), count($pengumuman), count($kuota));
            for ($i = 0; $i < $count; $i++) {
                $g = $gel[$i] ?? null;
                $p = $pendaftaran[$i] ?? null;
                $t = $tes[$i] ?? null;
                $pn = $pengumuman[$i] ?? null;
                $k = $kuota[$i] ?? null;
                if (($g && trim($g) !== '') || ($p && trim($p) !== '') || ($t && trim($t) !== '') || ($pn && trim($pn) !== '') || ($k && trim($k) !== '')) {
                    $rows[] = [
                        'gelombang' => $g,
                        'pendaftaran' => $p,
                        'tes' => $t,
                        'pengumuman' => $pn,
                        'kuota' => $k,
                    ];
                }
            }
            $data['jadwal_rows'] = $rows;
        }

        $visi1 = $request->input('visi_1');
        $visi2 = $request->input('visi_2');
        $misiList = $request->input('misi_items');
        $misiTarget = $request->input('misi_target');
        $unggulanList = $request->input('unggulan_program_items');
        $kegiatanList = $request->input('unggulan_kegiatan_items');
        if ($visi1 || $visi2 || $misiList || $misiTarget || $unggulanList || $kegiatanList) {
            if (is_string($misiList)) {
                $misiList = preg_split("/\r\n|\r|\n/", $misiList);
            }
            if (is_string($unggulanList)) {
                $unggulanList = preg_split("/\r\n|\r|\n/", $unggulanList);
            }
            if (is_string($kegiatanList)) {
                $kegiatanList = preg_split("/\r\n|\r|\n/", $kegiatanList);
            }
            $misiList = array_values(array_filter(($misiList ?? []), fn($v) => trim((string)$v) !== ''));
            $unggulanList = array_values(array_filter(($unggulanList ?? []), fn($v) => trim((string)$v) !== ''));
            $kegiatanList = array_values(array_filter(($kegiatanList ?? []), fn($v) => trim((string)$v) !== ''));
            $data['program_tabs'] = [
                'visi' => [
                    'visi_madrasah' => $visi1,
                    'arah_pendidikan' => $visi2,
                ],
                'misi' => [
                    'misi_items' => $misiList ?: [],
                    'target_lulusan' => $misiTarget,
                ],
                'unggulan' => [
                    'program_unggulan_items' => $unggulanList ?: [],
                    'kegiatan_penunjang_items' => $kegiatanList ?: [],
                ],
            ];
        }

        $setting = HomeSetting::first();

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $dir = public_path('landing/uploads');

            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($dir, $filename);

            $data['hero_image_path'] = 'landing/uploads/' . $filename;
        }

        if ($setting) {
            $setting->update($data);
        } else {
            $setting = HomeSetting::create($data);
        }

        return redirect()
            ->route('admin.home-settings.edit')
            ->with('success', 'Pengaturan halaman home berhasil disimpan.');
    }
}
