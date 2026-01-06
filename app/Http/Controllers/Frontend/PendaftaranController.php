<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\TahunAjaran;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\JalurMasuk;
use App\Models\Persyaratan;
use App\Models\DokumenSiswa;
use App\Models\Pengaturan;
use App\Models\Setting;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PendaftaranController extends Controller
{

    protected $midtransService; // TAMBAHKAN

    // TAMBAHKAN Constructor
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }



    public function index()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();
        return view('frontend.dashboard.pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        // Check if user already has pendaftaran
        if (Pendaftaran::where('user_id', auth()->id())->exists()) {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Anda sudah memiliki data pendaftaran.');
        }

        // Check if pendaftaran is open
        $gelombangAktif = Gelombang::active()
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        if (!$gelombangAktif) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Pendaftaran belum dibuka atau sudah ditutup.');
        }

        $tahunAjaran = TahunAjaran::active()->first();
        
        if (!$tahunAjaran) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Tahun ajaran belum diatur.');
        }

        $jurusans = Jurusan::active()->get();
        $jalurMasuks = JalurMasuk::active()->get();

        return view('frontend.dashboard.pendaftaran.create', compact(
            'tahunAjaran',
            'gelombangAktif',
            'jurusans',
            'jalurMasuks'
        ));
    }

    public function store(Request $request)
    {
        // Check if user already has pendaftaran
        if (Pendaftaran::where('user_id', auth()->id())->exists()) {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Anda sudah memiliki data pendaftaran.');
        }

        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'gelombang_id' => 'required|exists:gelombangs,id',
            'jalur_masuk_id' => 'required|exists:jalur_masuks,id',
            'nisn' => 'required|string|size:10|unique:pendaftarans,nisn',
            'nik' => 'required|string|size:16|unique:pendaftarans,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'no_hp_siswa' => 'required|string|max:15',
            'email_siswa' => 'required|email|max:255',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:15',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:15',
            'nama_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'no_hp_wali' => 'nullable|string|max:15',
            'penghasilan_ortu' => 'nullable|numeric',
            'asal_sekolah' => 'required|string|max:255',
            'npsn_sekolah' => 'nullable|string|max:8',
            'tahun_lulus' => 'required|integer|min:2010|max:' . (date('Y') + 1),
            'nilai_un' => 'nullable|numeric|min:0|max:100',
            'jurusan_pilihan_1' => 'required|exists:jurusans,id',
            'jurusan_pilihan_2' => 'nullable|exists:jurusans,id|different:jurusan_pilihan_1',
        ], [
            'nisn.size' => 'NISN harus 10 digit',
            'nisn.unique' => 'NISN sudah terdaftar',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'jurusan_pilihan_2.different' => 'Jurusan pilihan 2 harus berbeda dengan pilihan 1',
        ]);

        try {
            DB::beginTransaction();

            // Generate nomor pendaftaran
            $tahunAjaran = TahunAjaran::find($validated['tahun_ajaran_id']);
            $gelombang = Gelombang::find($validated['gelombang_id']);
            
            $lastNumber = Pendaftaran::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
                ->where('gelombang_id', $validated['gelombang_id'])
                ->max('no_pendaftaran');

            if ($lastNumber) {
                $lastNum = intval(substr($lastNumber, -4));
                $newNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNum = '0001';
            }

            $noPendaftaran = 'PPDB' . date('Y') . $gelombang->kode . $newNum;

            // Create pendaftaran
            $pendaftaran = Pendaftaran::create([
                'user_id' => auth()->id(),
                'no_pendaftaran' => $noPendaftaran,
                'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
                'gelombang_id' => $validated['gelombang_id'],
                'jalur_masuk_id' => $validated['jalur_masuk_id'],
                'nisn' => $validated['nisn'],
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'agama' => $validated['agama'],
                'alamat' => $validated['alamat'],
                'kelurahan' => $validated['kelurahan'],
                'kecamatan' => $validated['kecamatan'],
                'kota' => $validated['kota'],
                'provinsi' => $validated['provinsi'],
                'no_hp_siswa' => $validated['no_hp_siswa'],
                'email_siswa' => $validated['email_siswa'],
                'nama_ayah' => $validated['nama_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'no_hp_ayah' => $validated['no_hp_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                'no_hp_ibu' => $validated['no_hp_ibu'],
                'nama_wali' => $validated['nama_wali'],
                'pekerjaan_wali' => $validated['pekerjaan_wali'],
                'no_hp_wali' => $validated['no_hp_wali'],
                'penghasilan_ortu' => $validated['penghasilan_ortu'],
                'asal_sekolah' => $validated['asal_sekolah'],
                'npsn_sekolah' => $validated['npsn_sekolah'],
                'tahun_lulus' => $validated['tahun_lulus'],
                'nilai_un' => $validated['nilai_un'],
                'jurusan_pilihan_1' => $validated['jurusan_pilihan_1'],
                'jurusan_pilihan_2' => $validated['jurusan_pilihan_2'],
                'status_pendaftaran' => 'draft',
                'status_verifikasi' => 'pending',
            ]);

            // Create pembayaran record
            $biayaPendaftaran = Pengaturan::where('key', 'biaya_pendaftaran')->first();
            $jumlahBayar = $biayaPendaftaran ? $biayaPendaftaran->value : 250000;

            // Generate invoice number
            $lastInvoice = Pembayaran::whereYear('created_at', date('Y'))
                ->max('no_invoice');

            if ($lastInvoice) {
                $lastNum = intval(substr($lastInvoice, -4));
                $newNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNum = '0001';
            }

            $noInvoice = 'INV' . date('Ymd') . $newNum;

            Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'no_invoice' => $noInvoice,
                'jumlah' => $jumlahBayar,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('dashboard.pendaftaran.index')
                ->with('success', 'Data pendaftaran berhasil disimpan! Silakan lengkapi dokumen dan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        // Check ownership
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if can edit
        if ($pendaftaran->status_pendaftaran !== 'draft') {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Data pendaftaran yang sudah disubmit tidak dapat diedit.');
        }

        $tahunAjaran = $pendaftaran->tahunAjaran;
        $gelombangAktif = $pendaftaran->gelombang;
        $jurusans = Jurusan::active()->get();
        $jalurMasuks = JalurMasuk::active()->get();

        return view('frontend.dashboard.pendaftaran.edit', compact(
            'pendaftaran',
            'tahunAjaran',
            'gelombangAktif',
            'jurusans',
            'jalurMasuks'
        ));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        // Check ownership
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if can edit
        if ($pendaftaran->status_pendaftaran !== 'draft') {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Data pendaftaran yang sudah disubmit tidak dapat diedit.');
        }

        $validated = $request->validate([
            'jalur_masuk_id' => 'required|exists:jalur_masuks,id',
            'nisn' => 'required|string|size:10|unique:pendaftarans,nisn,' . $pendaftaran->id,
            'nik' => 'required|string|size:16|unique:pendaftarans,nik,' . $pendaftaran->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'no_hp_siswa' => 'required|string|max:15',
            'email_siswa' => 'required|email|max:255',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:15',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:15',
            'nama_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'no_hp_wali' => 'nullable|string|max:15',
            'penghasilan_ortu' => 'nullable|numeric',
            'asal_sekolah' => 'required|string|max:255',
            'npsn_sekolah' => 'nullable|string|max:8',
            'tahun_lulus' => 'required|integer|min:2010|max:' . (date('Y') + 1),
            'nilai_un' => 'nullable|numeric|min:0|max:100',
            'jurusan_pilihan_1' => 'required|exists:jurusans,id',
            'jurusan_pilihan_2' => 'nullable|exists:jurusans,id|different:jurusan_pilihan_1',
        ]);

        try {
            $pendaftaran->update($validated);

            return redirect()->route('dashboard.pendaftaran.index')
                ->with('success', 'Data pendaftaran berhasil diupdate!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function submit(Pendaftaran $pendaftaran)
    {
        // Check ownership
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already submitted
        if ($pendaftaran->status_pendaftaran !== 'draft') {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Pendaftaran sudah disubmit sebelumnya.');
        }

        // Check if all required documents are uploaded
        $persyaratanWajib = Persyaratan::where('is_wajib', true)->pluck('id');
        $uploadedDocs = DokumenSiswa::where('pendaftaran_id', $pendaftaran->id)
            ->whereIn('persyaratan_id', $persyaratanWajib)
            ->pluck('persyaratan_id');

        if ($persyaratanWajib->diff($uploadedDocs)->count() > 0) {
            return redirect()->route('dashboard.pendaftaran.dokumen', $pendaftaran)
                ->with('error', 'Harap lengkapi semua dokumen wajib terlebih dahulu.');
        }

        try {
            $pendaftaran->update([
                'status_pendaftaran' => 'submitted',
                'tanggal_daftar' => now(),
            ]);

            return redirect()->route('dashboard.pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil disubmit! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function dokumen(Pendaftaran $pendaftaran)
    {
        // Check ownership
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $persyaratans = Persyaratan::active()->get();
        $dokumens = DokumenSiswa::where('pendaftaran_id', $pendaftaran->id)->get();

        return view('frontend.dashboard.pendaftaran.dokumen', compact(
            'pendaftaran',
            'persyaratans',
            'dokumens'
        ));
    }

    public function pembayaran()
{
    $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

    if (!$pendaftaran) {
        return redirect()->route('dashboard.index')
            ->with('error', 'Anda belum memiliki data pendaftaran.');
    }

    $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->first();

    // Payment settings - GET FROM SETTING MODEL
    $midtransEnabled = Setting::get('midtrans_enabled', false);
    $transferBankEnabled = Setting::get('transfer_bank_enabled', true);
    $biayaPendaftaran = Setting::get('biaya_pendaftaran', 250000);

    // Debug: Log values (TEMPORARY - HAPUS SETELAH TESTING)
    \Log::info('Payment Settings:', [
        'midtrans_enabled' => $midtransEnabled,
        'transfer_bank_enabled' => $transferBankEnabled,
        'biaya_pendaftaran' => $biayaPendaftaran,
    ]);

    // Bank info
    $bankName = Setting::get('bank_name', 'Bank BRI');
    $bankAccountNumber = Setting::get('bank_account_number', '1234567890');
    $bankAccountName = Setting::get('bank_account_name', 'SMK ISLAM YPI 2');

    return view('frontend.dashboard.pembayaran.index', compact(
        'pendaftaran',
        'pembayaran',
        'midtransEnabled',
        'transferBankEnabled',
        'biayaPendaftaran',
        'bankName',
        'bankAccountNumber',
        'bankAccountName'
    ));

    }

/**
 * Upload bukti pembayaran
 */
public function uploadBukti(Request $request)
{
    \Log::info('=== UPLOAD BUKTI DIPANGGIL ===');
    \Log::info('Request Data:', $request->all());
    \Log::info('Files:', $request->allFiles());
    
    $user = auth()->user();
    $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

    if (!$pendaftaran) {
        return redirect()->route('dashboard.index')
            ->with('error', 'Anda belum memiliki data pendaftaran.');
    }

    \Log::info('Pendaftaran found:', ['id' => $pendaftaran->id]);

    // Validasi input
    $validated = $request->validate([
        'metode_pembayaran' => 'required|in:Transfer Bank,Setor Tunai',
        'tanggal_bayar' => 'required|date',
        'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:2048',
    ], [
        'metode_pembayaran.required' => 'Metode pembayaran harus dipilih',
        'tanggal_bayar.required' => 'Tanggal bayar harus diisi',
        'bukti_pembayaran.required' => 'Bukti pembayaran harus diupload',
        'bukti_pembayaran.image' => 'File harus berupa gambar',
        'bukti_pembayaran.mimes' => 'Format gambar harus jpeg, jpg, atau png',
        'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB',
    ]);

    \Log::info('Validation passed');

    // Get or create pembayaran record
    $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->first();

    if (!$pembayaran) {
        \Log::info('Creating new pembayaran...');
        
        // Generate invoice number
        $lastInvoice = Pembayaran::whereYear('created_at', date('Y'))
            ->max('no_invoice');

        if ($lastInvoice) {
            $lastNum = intval(substr($lastInvoice, -4));
            $newNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNum = '0001';
        }

        $noInvoice = 'INV' . date('Ymd') . $newNum;
        $biayaPendaftaran = Setting::get('biaya_pendaftaran', 250000);

        try {
            $pembayaran = Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'no_invoice' => $noInvoice,
                'jumlah' => $biayaPendaftaran,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'payment_type' => 'manual', // ✅ SET payment_type
                'tanggal_bayar' => $validated['tanggal_bayar'],
                'status' => 'pending',
            ]);
            
            \Log::info('✅ Pembayaran created:', ['id' => $pembayaran->id]);
            
        } catch (\Exception $e) {
            \Log::error('❌ Failed to create pembayaran:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal membuat record pembayaran: ' . $e->getMessage());
        }
    }

    // Handle file upload
    try {
        \Log::info('Uploading bukti file...');
        
        // Delete old bukti if exists
        if ($pembayaran->bukti_pembayaran && Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
            \Log::info('Old bukti deleted:', ['path' => $pembayaran->bukti_pembayaran]);
        }

        // Store new file
        $file = $request->file('bukti_pembayaran');
        $fileName = 'bukti_' . $pendaftaran->no_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti-pembayaran', $fileName, 'public');
        
        \Log::info('✅ File uploaded:', ['path' => $path]);

        // Update pembayaran
        $updated = $pembayaran->update([
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'payment_type' => 'manual', // ✅ Pastikan manual
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'bukti_pembayaran' => $path,
            'status' => 'pending',
            'catatan' => null,
            // Clear Midtrans fields jika ada
            'midtrans_order_id' => null,
            'midtrans_transaction_id' => null,
            'midtrans_transaction_status' => null,
        ]);
        
        \Log::info('Update result:', [
            'updated' => $updated,
            'pembayaran_id' => $pembayaran->id,
        ]);

        // Verify update
        $pembayaran->refresh();
        \Log::info('✅ Pembayaran after update:', [
            'id' => $pembayaran->id,
            'bukti_pembayaran' => $pembayaran->bukti_pembayaran,
            'status' => $pembayaran->status,
        ]);

        return redirect()->route('dashboard.pembayaran.index')
            ->with('success', 'Bukti pembayaran berhasil diupload! Silakan tunggu verifikasi dari panitia.');

    } catch (\Exception $e) {
        \Log::error('❌ Upload bukti failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->back()
            ->with('error', 'Gagal upload bukti: ' . $e->getMessage())
            ->withInput();
    }
}
    /**
 * Pay with Midtrans
 */
public function payWithMidtrans()
{
    \Log::info('=== PAY WITH MIDTRANS DIPANGGIL ===');
    
    $user = auth()->user();
    \Log::info('User:', ['id' => $user->id, 'email' => $user->email]);
    
    $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

    if (!$pendaftaran) {
        \Log::error('Pendaftaran tidak ditemukan untuk user:', ['user_id' => $user->id]);
        return redirect()->route('dashboard.index')
            ->with('error', 'Anda belum memiliki data pendaftaran.');
    }
    
    \Log::info('Pendaftaran ditemukan:', [
        'id' => $pendaftaran->id,
        'no_pendaftaran' => $pendaftaran->no_pendaftaran,
    ]);

    // Check if Midtrans is enabled
    if (!Setting::get('midtrans_enabled', false)) {
        return redirect()->back()
            ->with('error', 'Pembayaran online sedang tidak tersedia');
    }

    // Get or create pembayaran record
    $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->first();
    
    \Log::info('Pembayaran existing:', $pembayaran ? [
        'id' => $pembayaran->id,
        'no_invoice' => $pembayaran->no_invoice,
        'status' => $pembayaran->status,
    ] : ['status' => 'TIDAK ADA']);

    // If no pembayaran record exists, create new one
    if (!$pembayaran) {
        \Log::info('Membuat pembayaran baru...');
        
        $biayaPendaftaran = Setting::get('biaya_pendaftaran', 250000);

        // Generate invoice number
        $lastInvoice = Pembayaran::whereYear('created_at', date('Y'))
            ->max('no_invoice');

        if ($lastInvoice) {
            $lastNum = intval(substr($lastInvoice, -4));
            $newNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNum = '0001';
        }

        $noInvoice = 'INV' . date('Ymd') . $newNum;
        
        \Log::info('Invoice number generated:', ['no_invoice' => $noInvoice]);

        try {
            $pembayaran = Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'no_invoice' => $noInvoice,
                'jumlah' => $biayaPendaftaran,
                'metode_pembayaran' => 'Midtrans',
                'payment_type' => 'midtrans',
                'tanggal_bayar' => now(),
                'status' => 'pending',
            ]);
            
            \Log::info('✅ Pembayaran berhasil dibuat:', [
                'id' => $pembayaran->id,
                'no_invoice' => $pembayaran->no_invoice,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('❌ Gagal membuat pembayaran:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal membuat record pembayaran: ' . $e->getMessage());
        }
    }

    // If payment already verified, redirect
    if ($pembayaran->status === 'verified') {
        return redirect()->route('dashboard.pembayaran.index')
            ->with('info', 'Pembayaran Anda sudah terverifikasi');
    }

    // Update payment to midtrans if it was manual before
    $pembayaran->update([
        'payment_type' => 'midtrans',
        'metode_pembayaran' => 'Midtrans',
        'tanggal_bayar' => now(),
        'status' => 'pending',
        'bukti_pembayaran' => null,
        'catatan' => null,
    ]);
    
    \Log::info('Pembayaran updated to midtrans:', ['id' => $pembayaran->id]);

    // Create Midtrans transaction
    \Log::info('Creating Midtrans transaction...');
    
    $result = $this->midtransService->createTransaction($pendaftaran, $pembayaran);
    
    \Log::info('Midtrans create transaction result:', $result);

    if (!$result['success']) {
        \Log::error('❌ Gagal create Midtrans transaction:', ['message' => $result['message']]);
        
        return redirect()->back()
            ->with('error', 'Gagal membuat transaksi: ' . $result['message']);
    }
    
    // Verify pembayaran updated with order_id
    $pembayaran->refresh();
    \Log::info('✅ Pembayaran setelah create transaction:', [
        'id' => $pembayaran->id,
        'midtrans_order_id' => $pembayaran->midtrans_order_id,
        'status' => $pembayaran->status,
    ]);

    return view('frontend.dashboard.pembayaran.midtrans', [
        'snapToken' => $result['snap_token'],
        'clientKey' => Setting::get('midtrans_client_key'),
    ]);
}

   /**
 * Payment finish callback
 */
public function paymentFinish(Request $request)
{
    // LOG EVERYTHING
    \Log::channel('daily')->info('==========================================');
    \Log::channel('daily')->info('PAYMENT FINISH DIPANGGIL!');
    \Log::channel('daily')->info('Request Data:', $request->all());
    \Log::channel('daily')->info('Order ID:', [$request->order_id]);
    \Log::channel('daily')->info('==========================================');

    $orderId = $request->order_id;

    if (!$orderId) {
        \Log::channel('daily')->error('Order ID tidak ada di request!');
        return redirect()->route('dashboard.pembayaran.index')
            ->with('error', 'Order ID tidak ditemukan');
    }

    // Get payment
    $pembayaran = Pembayaran::where('midtrans_order_id', $orderId)->first();

    if (!$pembayaran) {
        \Log::channel('daily')->error('Pembayaran tidak ditemukan:', ['order_id' => $orderId]);
        return redirect()->route('dashboard.index')
            ->with('error', 'Pembayaran tidak ditemukan');
    }

    \Log::channel('daily')->info('Pembayaran ditemukan:', [
        'id' => $pembayaran->id,
        'status_sekarang' => $pembayaran->status,
    ]);

    // OPSI 1: Langsung update tanpa cek API (untuk testing)
    try {
        \Log::channel('daily')->info('Mencoba update status ke verified...');
        
        $pembayaran->status = 'verified';
        $pembayaran->midtrans_transaction_status = 'success';
        $pembayaran->paid_at = now();
        $pembayaran->tanggal_bayar = now();
        $pembayaran->catatan = 'Pembayaran terverifikasi otomatis';
        $pembayaran->save();
        
        \Log::channel('daily')->info('UPDATE BERHASIL!', [
            'status_baru' => $pembayaran->fresh()->status,
        ]);
        
        return redirect()->route('dashboard.pembayaran.success')
            ->with('success', 'Pembayaran berhasil diverifikasi!');
        
    } catch (\Exception $e) {
        \Log::channel('daily')->error('UPDATE GAGAL!', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return redirect()->route('dashboard.pembayaran.index')
            ->with('error', 'Gagal update status: ' . $e->getMessage());
    }
}

    /**
     * TAMBAHKAN METHOD BARU - Payment success page
     */
    public function paymentSuccess()
    {
        return view('frontend.dashboard.pembayaran.success');
    }

    /**
     * TAMBAHKAN METHOD BARU - Payment pending page
     */
    public function paymentPending()
    {
        return view('frontend.dashboard.pembayaran.pending');
    }

    /**
     * TAMBAHKAN METHOD BARU - Payment failed page
     */
    public function paymentFailed()
    {
        return view('frontend.dashboard.pembayaran.failed');
    }

    /**
     * TAMBAHKAN METHOD BARU - Webhook handler for Midtrans notification
     */
    public function paymentWebhook(Request $request)
    {
        $result = $this->midtransService->handleNotification($request->all());

        if ($result['success']) {
            return response()->json(['message' => 'Notification handled']);
        }

        return response()->json(['message' => 'Failed to handle notification'], 400);
    }





    public function cetakFormulir()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        if (!$pendaftaran || $pendaftaran->status_pendaftaran === 'draft') {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Silakan submit pendaftaran terlebih dahulu.');
        }

        return view('frontend.dashboard.cetak.formulir', compact('pendaftaran'));
    }

    public function cetakKartu()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        if (!$pendaftaran || $pendaftaran->status_pendaftaran !== 'accepted') {
            return redirect()->route('dashboard.pendaftaran.index')
                ->with('error', 'Kartu peserta hanya dapat dicetak setelah pendaftaran diterima.');
        }

        return view('frontend.dashboard.cetak.kartu', compact('pendaftaran'));
    }

    /**
 * Auto verify payment after Midtrans success (via AJAX)
 */
public function autoVerify(Request $request)
{
    \Log::info('=== AUTO VERIFY DIPANGGIL ===');
    \Log::info('Request Data:', $request->all());
    
    $orderId = $request->order_id;
    
    if (!$orderId) {
        \Log::error('Order ID tidak ada di request!');
        return response()->json([
            'success' => false, 
            'message' => 'Order ID tidak ada'
        ]);
    }
    
    \Log::info('Mencari pembayaran dengan order_id:', ['order_id' => $orderId]);
    
    // Cari pembayaran by order_id
    $pembayaran = Pembayaran::where('midtrans_order_id', $orderId)->first();
    
    if (!$pembayaran) {
        // FALLBACK: Cari pembayaran terbaru user yang pending
        \Log::warning('Pembayaran tidak ditemukan dengan order_id, mencoba fallback...');
        
        $user = auth()->user();
        if ($user && $user->pendaftaran) {
            $pembayaran = Pembayaran::where('pendaftaran_id', $user->pendaftaran->id)
                ->where('payment_type', 'midtrans')
                ->where('status', 'pending')
                ->latest()
                ->first();
            
            if ($pembayaran) {
                \Log::info('Pembayaran ditemukan via fallback:', ['id' => $pembayaran->id]);
                
                // Update order_id yang sebenarnya
                $pembayaran->midtrans_order_id = $orderId;
                $pembayaran->save();
            }
        }
        
        if (!$pembayaran) {
            \Log::error('Pembayaran TIDAK DITEMUKAN sama sekali!', [
                'order_id' => $orderId,
                'user_id' => auth()->id(),
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Pembayaran tidak ditemukan'
            ]);
        }
    }
    
    \Log::info('Pembayaran ditemukan:', [
        'id' => $pembayaran->id,
        'no_invoice' => $pembayaran->no_invoice,
        'status_lama' => $pembayaran->status,
    ]);
    
    try {
        // Update status ke verified
        $pembayaran->status = 'verified';
        $pembayaran->midtrans_transaction_status = 'success';
        $pembayaran->paid_at = now();
        $pembayaran->tanggal_bayar = now();
        $pembayaran->catatan = 'Pembayaran terverifikasi otomatis via Midtrans';
        $pembayaran->save();
        
        \Log::info('✅ UPDATE BERHASIL!', [
            'id' => $pembayaran->id,
            'status_baru' => $pembayaran->fresh()->status,
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Status berhasil diupdate ke verified'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('❌ UPDATE GAGAL!', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return response()->json([
            'success' => false, 
            'message' => 'Gagal update: ' . $e->getMessage()
        ]);
    }
}
}       