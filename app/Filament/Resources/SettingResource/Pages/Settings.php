<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.pages.Settings';
    
    protected static ?string $title = 'Pengaturan Pembayaran';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // Midtrans
            'midtrans_enabled' => Setting::get('midtrans_enabled', false),
            'midtrans_environment' => Setting::get('midtrans_environment', 'sandbox'),
            'midtrans_client_key' => Setting::get('midtrans_client_key', ''),
            'midtrans_server_key' => Setting::get('midtrans_server_key', ''),
            'midtrans_merchant_id' => Setting::get('midtrans_merchant_id', ''),
            
            // Transfer Bank
            'transfer_bank_enabled' => Setting::get('transfer_bank_enabled', true),
            'bank_name' => Setting::get('bank_name', ''),
            'bank_account_number' => Setting::get('bank_account_number', ''),
            'bank_account_name' => Setting::get('bank_account_name', ''),
            
            // Biaya
            'biaya_pendaftaran' => Setting::get('biaya_pendaftaran', 250000),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Midtrans Section
                Section::make('Midtrans Payment Gateway')
                    ->description('Integrasi pembayaran online via Midtrans')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Toggle::make('midtrans_enabled')
                            ->label('Aktifkan Midtrans')
                            ->helperText('Aktifkan atau nonaktifkan pembayaran via Midtrans')
                            ->inline(false)
                            ->columnSpanFull(),

                        Select::make('midtrans_environment')
                            ->label('Environment')
                            ->options([
                                'sandbox' => 'Sandbox (Testing)',
                                'production' => 'Production (Live)',
                            ])
                            ->required()
                            ->helperText('Pilih Sandbox untuk testing, Production untuk live')
                            ->columnSpanFull(),

                        TextInput::make('midtrans_client_key')
                            ->label('Client Key')
                            ->placeholder('SB-Mid-client-xxxxxxxxxxxxxxxx')
                            ->helperText('Client Key dari Midtrans Dashboard')
                            ->columnSpanFull(),

                        TextInput::make('midtrans_server_key')
                            ->label('Server Key')
                            ->placeholder('SB-Mid-server-xxxxxxxxxxxxxxxx')
                            ->helperText('Server Key dari Midtrans Dashboard (rahasia)')
                            ->password()
                            ->revealable()
                            ->columnSpanFull(),

                        TextInput::make('midtrans_merchant_id')
                            ->label('Merchant ID')
                            ->placeholder('G123456789')
                            ->helperText('Merchant ID dari Midtrans Dashboard')
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('midtrans_help')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="p-4 bg-warning-50 border border-warning-200 rounded-lg">
                                    <p class="text-sm font-semibold text-warning-800 mb-2">📝 Cara Mendapatkan API Keys:</p>
                                    <ol class="text-sm text-warning-700 space-y-1 list-decimal list-inside">
                                        <li>Login ke <a href="https://dashboard.midtrans.com/" target="_blank" class="underline font-medium">Midtrans Dashboard</a></li>
                                        <li>Pilih Environment (Sandbox/Production)</li>
                                        <li>Menu Settings → Access Keys</li>
                                        <li>Copy Client Key dan Server Key</li>
                                        <li>Paste di form ini</li>
                                    </ol>
                                </div>
                            '))
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Transfer Bank Section
                Section::make('Transfer Bank Manual')
                    ->description('Pembayaran via transfer bank manual')
                    ->icon('heroicon-o-building-library')
                    ->schema([
                        Toggle::make('transfer_bank_enabled')
                            ->label('Aktifkan Transfer Bank')
                            ->helperText('Aktifkan atau nonaktifkan transfer bank manual')
                            ->inline(false)
                            ->columnSpanFull(),

                        TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->placeholder('Bank BRI')
                            ->columnSpanFull(),

                        TextInput::make('bank_account_number')
                            ->label('Nomor Rekening')
                            ->placeholder('1234567890')
                            ->columnSpanFull(),

                        TextInput::make('bank_account_name')
                            ->label('Nama Pemilik Rekening')
                            ->placeholder('SMK ISLAM YPI 2')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Biaya Pendaftaran Section
                Section::make('Biaya Pendaftaran')
                    ->description('Atur biaya pendaftaran PPDB')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        TextInput::make('biaya_pendaftaran')
                            ->label('Biaya Pendaftaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->helperText('Format: 250000 (tanpa titik atau koma)')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Simpan Pengaturan')
                ->icon('heroicon-o-check')
                ->submit('save'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('test_midtrans')
                ->label('Test Koneksi Midtrans')
                ->icon('heroicon-o-signal')
                ->color('success')
                ->action('testMidtrans'),
                
            Actions\Action::make('open_dashboard')
                ->label('Midtrans Dashboard')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url('https://dashboard.midtrans.com/', shouldOpenInNewTab: true),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Setting::clearCache();

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan!')
            ->success()
            ->send();
    }

    public function testMidtrans(): void
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

            Notification::make()
                ->title('Koneksi Midtrans Berhasil!')
                ->body('API Keys valid dan koneksi berhasil. Snap Token: ' . substr($snapToken, 0, 20) . '...')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Koneksi Midtrans Gagal!')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}