<?php

namespace Database\Seeders;

use App\Models\Repository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepositoriesSeeder extends Seeder
{

    use WithoutModelEvents;

    public function run()
    {
        Repository::factory()->count(3)->create();
    }
}
