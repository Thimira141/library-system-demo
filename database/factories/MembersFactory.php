<?php

namespace Database\Factories;

use App\Models\Members;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Members>
 */
class MembersFactory extends Factory
{
    protected $model = Members::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => 'MEMBER-' . now()->format('YmdHis') . '-' . fake()->unique()->randomLetter(),
            'member_name' => fake()->name(),
            'member_nic_type' => 'NIC',
            'member_nic_number' => fake()->unique()->numerify('#########V'),
            'member_dob' => fake()->date(),
            'member_added' => now(),
            'member_email' => fake()->unique()->safeEmail(),
            'member_tel' => fake()->phoneNumber(),
            'member_address' => fake()->address(),
            'member_remarks' => fake()->paragraph(),
            'member_cover_img' => 'default-member.jpg',
        ];
    }
}
