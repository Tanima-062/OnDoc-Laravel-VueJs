<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name"                      =>  $this->faker->name,
            'logo'                      =>  $this->faker->imageUrl(64, 64),
            'street'                    =>  $this->faker->streetName(),
            'house_number'              =>  $this->faker->buildingNumber(),
            'postal_code'               =>  $this->faker->postcode(),
            'city'                      =>  $this->faker->city(),
            'country_code'              =>  $this->faker->countryCode(),
            'contact_persion_first_name'=>  $this->faker->firstName(),
            'contact_persion_last_name' =>  $this->faker->lastName(),
            'contact_persion_email'     =>  $this->faker->safeEmail(),
            'country_iso_code'          =>  $this->faker->countryCode(),
            'phone_number'              =>  $this->faker->phoneNumber(),
            'full_phone_number'         =>  null

        ];
    }
}
