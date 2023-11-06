<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Language;
use App\Models\User;
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
        $type = $this->faker->randomElement(['company_admin', 'company_sub_admin']);

        return [
            'language_id' => Language::inRandomOrder()->first()->id,
            'company_id'  =>   function(){
                return Company::inRandomOrder()->first()->id;
            },
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'avatar' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->email(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'type' => $type,
            'permission'    =>  $type == User::COMPANY_ADMIN ? 'full' : $this->faker->randomElement(['view', 'full']),
            'status'    =>  $this->faker->randomElement([User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_PENDING])
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => User::STATUS_ACTIVE,
            ];
        });
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

    /**
     * Indicate that the model's type is company_admin.
     *
     * @return static
     */
    public function companyAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::COMPANY_ADMIN,
            ];
        });
    }

    /**
     * Indicate that the model's company_sub_admin
     *
     * @return static
     */
    public function companySubAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::COMPANY_SUB_ADMIN,
            ];
        });
    }
}
