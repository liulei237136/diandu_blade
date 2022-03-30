<?php

namespace Database\Factories;

use App\Models\Repository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commit>
 */
class CommitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $table->id();
        // $table->string('title');
        // $table->text('description')->default('');
        // $table->unsignedBigInteger('creator_id')->index();
        // $table->unsignedBigInteger('owner_id')->index();
        // $table->unsignedBigInteger('repository_id')->index();
        // $table->string('file_path')->default('');
        // $table->timestamps();
        $repo = Repository::find(rand(1,100));
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'creator_id' => $repo->user_id,
            'owner_id' => $repo->user_id,
            'repository_id' => $repo->id,
            'file_path' => '',
        ];
    }
}
