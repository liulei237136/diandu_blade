<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repositories>
 */
class RepositoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sentence = $this->faker->sentence();

        $data =  [
            'name' => $sentence,
            'description' =>'&nbsp;&nbsp;' . implode('<br>&nbsp;&nbsp;', $this->faker->paragraphs(100)),
            'excerpt' => $sentence,
            'user_id' => create(User::class),
        ];

        return $data;
    }
}
