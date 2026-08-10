<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'membership_no' => 'MEM-' . $this->faker->unique()->numerify('#####'),
            'joining_date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'status' => 'active',
        ];
    }
}