<?php

namespace App\Jobs\Notifications;

use App\Models\Pembayaran;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentVerifiedWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pembayaran;
    public $tries = 3;

    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function handle(WhatsAppService $whatsappService)
    {
        $whatsappService->sendPaymentVerified($this->pembayaran);
    }
}