<?php

namespace Database\Seeders;

use App\Models\Commit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Commit::factory()->count(1000)->create();
    }
}
