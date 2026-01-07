<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $message;
    public $tries = 3;
    public $timeout = 120;
    public $backoff = [60, 180, 300]; // Retry after 1min, 3min, 5min

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        Log::info('Processing WhatsApp job', [
            'phone' => $this->phone,
            'attempt' => $this->attempts(),
        ]);

        $result = $whatsappService->sendMessage($this->phone, $this->message);

        if (!$result['success']) {
            Log::error('WhatsApp job failed', [
                'phone' => $this->phone,
                'error' => $result['message'],
                'attempt' => $this->attempts(),
            ]);

            // Retry if not last attempt
            if ($this->attempts() < $this->tries) {
                throw new \Exception($result['message']);
            }
        }

        Log::info('WhatsApp job completed', [
            'phone' => $this->phone,
            'success' => $result['success'],
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('WhatsApp job permanently failed', [
            'phone' => $this->phone,
            'error' => $exception->getMessage(),
        ]);
    }
}