<?php

namespace Database\Factories\Access\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
 * Roles
 */

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        static $password;

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'password' => $password ?: $password = Hash::make('secret'),
            'remember_token' => Str::random(10),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
        ];
    }

    public function active()
    {
        return $this->state(function () {
            return [
                'status' => 1,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function () {
            return [
                'status' => 0,
            ];
        });
    }

    public function confirmed()
    {
        return $this->state(function () {
            return [
                'confirmed' => 1,
            ];
        });
    }

    public function unconfirmed()
    {
        return $this->state(function () {
            return [
                'confirmed' => 0,
            ];
        });
    }
}
