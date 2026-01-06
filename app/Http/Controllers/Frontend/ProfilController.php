<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('frontend.dashboard.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp' => ['required', 'string', 'max:15'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_hp.required' => 'No. HP harus diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        try {
            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Delete old foto
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Upload new foto
                $file = $request->file('foto');
                $filename = 'profil_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profil', $filename, 'public');
                $validated['foto'] = $path;
            }

            // Update user
            $user->update($validated);

            return redirect()->route('dashboard.profil.index')
                ->with('success', 'Profil berhasil diupdate!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function ubahPassword()
    {
        return view('frontend.dashboard.profil.ubah-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'current_password.current_password' => 'Password lama tidak sesuai',
            'password.required' => 'Password baru harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        try {
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('dashboard.profil.ubah-password')
                ->with('success', 'Password berhasil diubah!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteFoto()
    {
        try {
            $user = auth()->user();

            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
                $user->update(['foto' => null]);
            }

            return back()->with('success', 'Foto profil berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}