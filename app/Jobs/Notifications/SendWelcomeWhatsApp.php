<?php

namespace App\Jobs\Notifications;

use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $tries = 3;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(WhatsAppService $whatsappService)
    {
        $whatsappService->sendWelcomeMessage($this->user);
    }
}