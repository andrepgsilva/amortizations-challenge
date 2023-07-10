<?php

namespace App\Services;

use App\Models\Amortization;
use App\Jobs\ProcessAmortization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;

class PayAmortizationsService 
{
    /**
     * It pays all amortizations payments
     *
     * @param string $scheduleDate
     * 
     * @return void
     **/
    public function execute(string $scheduleDate)
    {
        $relationships = [
            'project:id,balance',
            'project.promoter:id,email,project_id',
            'payments:id,amount,state,amortization_id',
            'payments.profile:id,email'
        ];

        $amortizations_columns = [
            'amortizations.id', 
            'amortizations.project_id', 
            'amortizations.state',
        ];

        Amortization::with($relationships)
            ->where('schedule_date', '<=', $scheduleDate)
            ->where('amortizations.state', 'pending')
            ->select($amortizations_columns)
            ->chunkById(10000, function(Collection $amortizations) {
                    $batch = $amortizations->map(function($amortization) {
                        return new ProcessAmortization($amortization);
                    });

                    Bus::batch($batch)->onQueue('amortizations')->dispatch();
                }
            );
    }
}