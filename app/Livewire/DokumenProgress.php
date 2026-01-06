<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pendaftaran;
use App\Models\Persyaratan;
use App\Models\DokumenSiswa;

class DokumenProgress extends Component
{
    public Pendaftaran $pendaftaran;

    protected $listeners = ['dokumenUploaded' => '$refresh'];

    public function render()
    {
        $persyaratans = Persyaratan::all();
        $dokumens = DokumenSiswa::where('pendaftaran_id', $this->pendaftaran->id)->get();

        $totalWajib = $persyaratans->where('is_wajib', true)->count();
        $uploadedWajib = $dokumens
            ->whereIn('persyaratan_id', $persyaratans->where('is_wajib', true)->pluck('id'))
            ->count();
        $progress = $totalWajib > 0 ? ($uploadedWajib / $totalWajib) * 100 : 0;

        return view('livewire.dokumen-progress', compact('totalWajib', 'uploadedWajib', 'progress'));
    }
}