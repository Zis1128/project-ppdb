<?php

namespace App\Jobs\Notifications;

use App\Models\Pendaftaran;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPendaftaranResultWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pendaftaran;
    public $tries = 3;

    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function handle(WhatsAppService $whatsappService)
    {
        if ($this->pendaftaran->status === 'diterima') {
            $whatsappService->sendPendaftaranAccepted($this->pendaftaran);
        } else if ($this->pendaftaran->status === 'ditolak') {
            $whatsappService->sendPendaftaranRejected($this->pendaftaran);
        }
    }
}