<?php

namespace App\Jobs;

use App\Models\Amortization;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ProcessAmortizationPayment;
use App\Notifications\AmortizationDateExpired;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Bus;

class ProcessAmortization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Amortization $amortization
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $amortization = $this->amortization;

        $projectBalance = $this->amortization->project->balance;

        $this->amortization->project()->update([
            'balance' => $projectBalance - $amortization->amount,
        ]);

        $this->amortization->state = 'paid';
        $this->amortization->save();

        if (now()->greaterThan($amortization->schedule_date)) {
            $promoter = $amortization->project->promoter;
            $promoter->notify(new AmortizationDateExpired($amortization));
        }

        $paymentChunks = array_chunk($amortization->payments, 10000);

        foreach ($paymentChunks as $paymentChunk) {
            $batch = $paymentChunk->map(function($payment) use ($amortization) {
                return new ProcessAmortizationPayment($amortization, $payment);
            });

            Bus::batch($batch)->onQueue('payments')->dispatch();
        }
    }
}
