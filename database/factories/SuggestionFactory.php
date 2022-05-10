<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suggestion>
 */
class SuggestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $table->string('title');
        // $table->text('content');
        // $table->foreignId('user_id');
        // $table->timestamps();

        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'user_id' => create(User::class),
        ];
    }
}
