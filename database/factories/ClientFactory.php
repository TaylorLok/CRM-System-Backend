<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
    */

    protected $model = Client::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'id_number' => $this->faker->unique()->numerify('80###########'),
            'dob' => $this->faker->date(),
            'telephone' => $this->faker->numerify('0#########'),
            'email_address' => $this->faker->unique()->safeEmail(),
            'status' => $this->faker->boolean(80) ? 1 : 0,
        ];
    }
}
