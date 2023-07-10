<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Queue\Queue;
use App\Models\Amortization;
use App\Jobs\ProcessAmortization;

class PayAmortizationsTest extends TestCase
{
    // use RefreshDatabase;

    protected $env = 'testing';

    /**
     * A basic feature test example.
     */
    public function test_if_the_project_balance_(): void
    {
        $scheduleDate = now()->addMonth()->format('Y-m-d');

        $projectBalance = 10000000000;
        $eachPaymentAmount = 500;
        $numberOfPayments = Amortization::where('state', 'paid')->count();

        $endpoint = '/api/pay-amortizations-payments/' . $scheduleDate;
        $response = $this->get($endpoint);

        $totalDebt = $numberOfPayments * $eachPaymentAmount;
        $newProjectBalance = $projectBalance - $totalDebt;

        $response->assertStatus(200);
        
        $this->assertEquals(
            $newProjectBalance, 
            Project::first()->balance
        );
    }
}
