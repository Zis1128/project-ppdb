<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\JalurMasuk;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::active()->first();
        $gelombangAktif = Gelombang::active()
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();
        
        $jurusans = Jurusan::active()->get();
        $jalurMasuks = JalurMasuk::active()->get();
        
        $settings = [
            'app_name' => Pengaturan::get('app_name', 'PPDB SMK'),
            'contact_email' => Pengaturan::get('contact_email'),
            'contact_phone' => Pengaturan::get('contact_phone'),
            'address' => Pengaturan::get('address'),
        ];

        return view('frontend.home', compact(
            'tahunAjaran',
            'gelombangAktif',
            'jurusans',
            'jalurMasuks',
            'settings'
        ));
    }

    public function tentang()
    {
        return view('frontend.tentang');
    }

    public function jurusan()
    {
         // Load jurusan dengan kuota_terpakai
    $jurusans = Jurusan::where('is_active', true)
        ->withCount([
            'pendaftaranDiterima as jumlah_diterima' => function ($query) {
                $query->where('status_pendaftaran', 'accepted');
            }
        ])
        ->orderBy('nama', 'asc')
        ->get();

    return view('frontend.jurusan', compact('jurusans'));
    }

   public function alurPendaftaran()
    {
    $gelombangAktif = Gelombang::where('is_active', true)
        ->where('tanggal_mulai', '<=', now())
        ->where('tanggal_selesai', '>=', now())
        ->first();

    $jalurMasuks = JalurMasuk::active()->get();

    return view('frontend.alur-pendaftaran', compact('gelombangAktif', 'jalurMasuks'));
    }


    public function kontak()
    {
        $settings = [
            'app_name' => Pengaturan::get('app_name', 'PPDB SMK'),
            'contact_email' => Pengaturan::get('contact_email'),
            'contact_phone' => Pengaturan::get('contact_phone'),
            'address' => Pengaturan::get('address'),
        ];

        return view('frontend.kontak', compact('settings'));
    }
}