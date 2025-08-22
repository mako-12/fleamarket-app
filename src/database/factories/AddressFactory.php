<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_code'=>$this->faker->postcode(),
            'address'=>$this->faker->city().$this->faker->streetAddress(),
            'building'=>$this->faker->secondaryAddress(),
        ];
    }
}
