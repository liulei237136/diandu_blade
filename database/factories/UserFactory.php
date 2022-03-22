<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 用户的默认头像
        $avatars = [
            'http://localhost:8000/uploads/images/avatars/202203/08/1_1646723942_Py28mirbiQ.jpg',
            'http://localhost:8000/uploads/images/avatars/202203/08/1_1646724592_ApPHvB9CAK.jpg',
            'http://localhost:8000/uploads/images/avatars/202203/08/1_1646724948_fwzAxYmaAf.jpg',
            'http://localhost:8000/uploads/images/avatars/202203/08/1_1646725513_dNl4W06ylf.jpg',
        ];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'introduction' => $this->faker->sentence(),
            'avatar' => $this->faker->randomElement($avatars),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
