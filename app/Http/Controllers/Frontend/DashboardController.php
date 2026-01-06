<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
       // $this->middleware(['auth', 'role:user']);
    }

    public function index()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        
        $pembayaran = null;
        if ($pendaftaran) {
            $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->first();
        }

        return view('frontend.dashboard.index', compact('pendaftaran', 'pembayaran'));
    }

    public function profil()
    {
        return view('frontend.dashboard.profil');
    }

    public function ubahPassword()
    {
        return view('frontend.dashboard.ubah-password');
    }
}