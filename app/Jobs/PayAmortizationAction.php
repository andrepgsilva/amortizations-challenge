<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\PayAmortizationsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PayAmortizationAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $scheduleDate,
        private PayAmortizationsService $payAmortizationsService,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->payAmortizationsService->execute($this->scheduleDate);
    }
}
