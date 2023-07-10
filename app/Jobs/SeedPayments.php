<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SeedPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $eachPaymentAmount = 500;
        $chunkSize = 100;

        Payment::factory()->count($chunkSize)->create([
            'state' => 'pending',
            'amount' => $eachPaymentAmount,
        ]);

        for ($i = 0; $i < 2; $i++) {
            $payments = Payment::take(2)->get();

            if (Profile::count() < 2) {
                Profile::factory()->create([
                    'email' => 'profile@example.com',
                    'payment_id' => $payments[0]->id
                ]);
        
                Profile::factory()->create([
                    'email' => 'profileTwo@example.com',
                    'payment_id' => $payments[1]->id
                ]);
        
                // Update two amortizations to expired
                $payments[0]->amortization->schedule_date = now()->format('Y-m-d');
                $payments[0]->amortization->save();
        
                $payments[1]->amortization->schedule_date = now()->format('Y-m-d');
                $payments[1]->amortization->save();
            }
        }
    }
}
