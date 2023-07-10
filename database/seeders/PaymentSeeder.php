<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Promoter;
use App\Jobs\SeedPayments;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectBalance = 10000000000;
        $project = Project::factory()->create(['balance' => $projectBalance]);

        $numberOfJobs = 10000;

        for ($i = 0; $i < $numberOfJobs; $i++) {
            SeedPayments::dispatch()->onQueue('seed');
        }

        Promoter::factory()->create([
            'email' => 'promoter@example.com',
            'project_id' => $project->id
        ]);
    }
}