<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DokumenSiswa;
use App\Models\Pendaftaran;
use App\Models\Persyaratan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DokumenUpload extends Component
{
    use WithFileUploads;

    public Pendaftaran $pendaftaran;
    public Persyaratan $persyaratan;
    public $file;
    public $existingDokumen;

    public function mount(Pendaftaran $pendaftaran, Persyaratan $persyaratan)
    {
        $this->pendaftaran = $pendaftaran;
        $this->persyaratan = $persyaratan;
        $this->loadExistingDokumen();
    }

    public function loadExistingDokumen()
    {
        $this->existingDokumen = DokumenSiswa::where('pendaftaran_id', $this->pendaftaran->id)
            ->where('persyaratan_id', $this->persyaratan->id)
            ->first();
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'file.required' => 'File harus dipilih',
            'file.mimes' => 'File harus berformat JPG, JPEG, PNG, atau PDF',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        try {
            // Delete old file if exists
            if ($this->existingDokumen && $this->existingDokumen->file_path) {
                if (Storage::disk('public')->exists($this->existingDokumen->file_path)) {
                    Storage::disk('public')->delete($this->existingDokumen->file_path);
                }
            }

            // Upload new file
            $filename = time() . '_' . $this->persyaratan->id . '_' . $this->file->getClientOriginalName();
            $path = $this->file->storeAs('dokumen_siswa', $filename, 'public');

            // Save or update to database
            if ($this->existingDokumen) {
                $this->existingDokumen->update([
                    'file_path' => $path,
                    'file_name' => $this->file->getClientOriginalName(),
                    'file_size' => $this->file->getSize(),
                    'status_verifikasi' => 'pending',
                    'catatan' => null,
                ]);
            } else {
                DokumenSiswa::create([
                    'pendaftaran_id' => $this->pendaftaran->id,
                    'persyaratan_id' => $this->persyaratan->id,
                    'file_path' => $path,
                    'file_name' => $this->file->getClientOriginalName(),
                    'file_size' => $this->file->getSize(),
                    'status_verifikasi' => 'pending',
                ]);
            }

            // Reload data
            $this->loadExistingDokumen();
            $this->reset('file');
            
            session()->flash('message', 'Dokumen berhasil diupload!');
            
            // Dispatch event to reload page (optional)
            $this->dispatch('dokumenUploaded');

        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());
            session()->flash('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    public function deleteDokumen()
    {
        if (!$this->existingDokumen) {
            session()->flash('error', 'Dokumen tidak ditemukan.');
            return;
        }

        // Check if pendaftaran is still draft or document is rejected
        if ($this->pendaftaran->status_pendaftaran !== 'draft' && 
            $this->existingDokumen->status_verifikasi !== 'rejected') {
            session()->flash('error', 'Dokumen tidak dapat dihapus setelah pendaftaran disubmit.');
            return;
        }

        try {
            // Delete file from storage
            if ($this->existingDokumen->file_path) {
                if (Storage::disk('public')->exists($this->existingDokumen->file_path)) {
                    Storage::disk('public')->delete($this->existingDokumen->file_path);
                }
            }

            // Delete from database
            $this->existingDokumen->delete();
            
            // Reload data
            $this->loadExistingDokumen();
            
            session()->flash('message', 'Dokumen berhasil dihapus!');
            
            // Dispatch event
            $this->dispatch('dokumenDeleted');

        } catch (\Exception $e) {
            Log::error('Delete error: ' . $e->getMessage());
            session()->flash('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dokumen-upload');
    }
}