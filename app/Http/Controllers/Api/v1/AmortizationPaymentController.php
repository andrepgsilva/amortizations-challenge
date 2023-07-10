<?php

namespace App\Http\Controllers\Api\v1;

use App\Jobs\PayAmortizationAction;
use App\Http\Controllers\Controller;
use App\Helpers\Validation\ValidateDate;
use App\Services\PayAmortizationsService;

class AmortizationPaymentController extends Controller
{
    public function __construct(
        private PayAmortizationsService $payAmortizationsService
    ) {}

    public function __invoke(string $scheduleDate)
    {
        if (! ValidateDate::execute($scheduleDate)) {
            return response()->json([
                'message' => 'Date is not valid.'
            ], 400);
        }

        PayAmortizationAction::dispatch(
            $scheduleDate, 
            $this->payAmortizationsService
        );
    }
}
