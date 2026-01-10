<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view("admin.Pengumuman.index", [
            'pengumumans' => Pengumuman::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:250',
            'tanggal' => 'required',
            'gambar' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'required'
        ]);


        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $renameGambar = uniqid().'_'.$file->getClientOriginalName();

            $file->move('Berkas', $renameGambar);

            $validated['gambar'] = $renameGambar;
        }

        Pengumuman::create($validated);

        return redirect('admin/pengumuman')->with('success', "Berhasil menambahkan pengumuman");

    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view("admin.Pengumuman.edit", [
            'item' => $pengumuman
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|max:250',
            'tanggal' => 'required',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'required'
        ]);

        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $renameGambar = uniqid().'_'.$file->getClientOriginalName();

            $file->move('Berkas', $renameGambar);

            File::delete('Berkas/' . $pengumuman->gambar);

            $validated['gambar'] = $renameGambar;
        }

        $pengumuman->update($validated);

        return redirect('admin/pengumuman')->with('success', "Berhasil menambahkan pengumuman");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        File::delete('Berkas/' . $pengumuman->gambar);

        $pengumuman->delete();

        return back()->with('success', "Berhasil menghapus pengumuman");
    }
}
