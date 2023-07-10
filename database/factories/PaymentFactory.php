<?php

namespace Database\Factories;

use App\Models\Amortization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    use WithFaker;

    private $state = ['pending', 'paid'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amortization_id' => Amortization::factory(),
            'amount' => 500,
            'state' => $this->state[$this->faker()->numberBetween(0, 1)],
        ];
    }
}
