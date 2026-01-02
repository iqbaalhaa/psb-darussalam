<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        $pendaftar = Registration::latest()->get();
        return view('admin.pendaftar.index', compact('pendaftar'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'wa' => 'required|string|max:20',
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
            'status' => 'required|in:pending,diterima,ditolak',
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
}
