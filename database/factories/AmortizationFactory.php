<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Amortization>
 */
class AmortizationFactory extends Factory
{
    use WithFaker;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'schedule_date' => now()->addDays(10)->format('Y-m-d'),
            'state' => 'pending',
            'amount' => 500,
            'project_id' => 1
        ];
    }
}
