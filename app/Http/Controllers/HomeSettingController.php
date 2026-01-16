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
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

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
