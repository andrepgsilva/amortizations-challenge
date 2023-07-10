<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Amortization;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\AmortizationDateExpired;
use Illuminate\Bus\Batchable;

class ProcessAmortizationPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Amortization $amortization,
        private Payment $payment
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payment = $this->payment;

        $payment->state = 'paid';
        $payment->save();

        $amortization = $this->amortization;

        if (now()->greaterThan($amortization->schedule_date)) {
            $paymentProfile = $payment->profile;
            
            $paymentProfile->notify(new AmortizationDateExpired($amortization));
        }
    }
}
