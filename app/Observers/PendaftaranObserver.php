<?php

namespace App\Observers;

use App\Models\Pendaftaran;
use App\Models\Jurusan;

class PendaftaranObserver
{
    /**
     * Handle the Pendaftaran "updated" event.
     */
    public function updated(Pendaftaran $pendaftaran): void
    {
        // Cek jika status berubah menjadi 'accepted'
        if ($pendaftaran->isDirty('status_pendaftaran')) {
            $oldStatus = $pendaftaran->getOriginal('status_pendaftaran');
            $newStatus = $pendaftaran->status_pendaftaran;

            // Jika status berubah dari selain 'accepted' ke 'accepted'
            if ($oldStatus !== 'accepted' && $newStatus === 'accepted') {
                $this->handleAccepted($pendaftaran);
            }

            // Jika status berubah dari 'accepted' ke selain 'accepted'
            if ($oldStatus === 'accepted' && $newStatus !== 'accepted') {
                $this->handleRejectedOrCancelled($pendaftaran);
            }
        }

        // Cek jika jurusan_diterima berubah
        if ($pendaftaran->isDirty('jurusan_diterima') && $pendaftaran->status_pendaftaran === 'accepted') {
            $oldJurusanId = $pendaftaran->getOriginal('jurusan_diterima');
            $newJurusanId = $pendaftaran->jurusan_diterima;

            // Kurangi kuota di jurusan lama
            if ($oldJurusanId) {
                $oldJurusan = Jurusan::find($oldJurusanId);
                if ($oldJurusan) {
                    $oldJurusan->decrementKuotaTerpakai();
                }
            }

            // Tambah kuota di jurusan baru
            if ($newJurusanId) {
                $newJurusan = Jurusan::find($newJurusanId);
                if ($newJurusan) {
                    $newJurusan->incrementKuotaTerpakai();
                }
            }
        }
    }

    /**
     * Handle when pendaftaran accepted
     */
    private function handleAccepted(Pendaftaran $pendaftaran): void
    {
        // Tentukan jurusan yang diterima (defaultnya pilihan 1)
        $jurusanId = $pendaftaran->jurusan_diterima ?? $pendaftaran->jurusan_pilihan_1;

        if ($jurusanId) {
            // Set jurusan_diterima jika belum ada
            if (!$pendaftaran->jurusan_diterima) {
                $pendaftaran->update(['jurusan_diterima' => $jurusanId]);
            }

            // Increment kuota terpakai
            $jurusan = Jurusan::find($jurusanId);
            if ($jurusan) {
                $jurusan->incrementKuotaTerpakai();
            }
        }
    }

    /**
     * Handle when pendaftaran rejected or cancelled
     */
    private function handleRejectedOrCancelled(Pendaftaran $pendaftaran): void
    {
        // Decrement kuota di jurusan yang sebelumnya diterima
        if ($pendaftaran->jurusan_diterima) {
            $jurusan = Jurusan::find($pendaftaran->jurusan_diterima);
            if ($jurusan) {
                $jurusan->decrementKuotaTerpakai();
            }
        }
    }

    /**
     * Handle the Pendaftaran "deleted" event.
     */
    public function deleted(Pendaftaran $pendaftaran): void
    {
        // Jika pendaftaran yang diterima dihapus, kembalikan kuota
        if ($pendaftaran->status_pendaftaran === 'accepted' && $pendaftaran->jurusan_diterima) {
            $jurusan = Jurusan::find($pendaftaran->jurusan_diterima);
            if ($jurusan) {
                $jurusan->decrementKuotaTerpakai();
            }
        }
    }
}