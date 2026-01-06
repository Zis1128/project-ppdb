<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('group', 'payment')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Setting::clearCache();

        return redirect()
            ->back()
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function testMidtrans()
    {
        try {
            \Midtrans\Config::$serverKey = Setting::get('midtrans_server_key');
            \Midtrans\Config::$isProduction = Setting::get('midtrans_environment') === 'production';
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Test connection
            $params = [
                'transaction_details' => [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 10000,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'message' => 'Koneksi Midtrans berhasil!',
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Koneksi Midtrans gagal: ' . $e->getMessage(),
            ], 500);
        }
    }
}