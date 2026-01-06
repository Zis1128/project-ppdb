<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            'no_hp' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // Cek apakah role user exists, jika tidak buat
            $role = \Spatie\Permission\Models\Role::firstOrCreate(
                ['name' => 'user'],
                ['guard_name' => 'web']
            );
            
            // Assign role
            $user->assignRole('user');

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('dashboard.index')
                ->with('success', 'Registrasi berhasil! Silakan lengkapi data pendaftaran.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Registration Error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }
}