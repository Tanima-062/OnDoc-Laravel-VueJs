<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Language;
use App\Models\MobileAppUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MobileAppUser>
 */
class MobileAppUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $lang = 46.818188;
        // $long = 8.227512;

        // $latitude = $this->faker->latitude($min = ($lang - (rand(0, 50) / 1000)), $max = ($lang + (rand(0, 50) / 1000)));
        // $longitude = $this->faker->longitude($min = ($long - (rand(0, 50) / 1000)), $max = ($long + (rand(0, 50) / 1000)));


        $country_iso_code = 'CH';
        return [
            'first_name'        =>  $this->faker->firstName(),
            'last_name'         =>  $this->faker->lastName(),
            // 'company_id'        =>  Company::inRandomOrder()->first()->id,
            'email'             =>  $this->faker->email(),
            'street'            =>  $this->faker->streetName(),
            'house_number'      =>  $this->faker->streetAddress(),
            'photo'             =>  $this->faker->imageUrl(),
            'zip_code'          =>  $this->faker->postcode(),
            'city'              =>  $this->faker->city,
            'country'           =>  $this->faker->countryCode(),
            'country_iso_code'  =>  $country_iso_code,
            'phone_number'      =>  str_replace('+', "", $this->faker->e164PhoneNumber($country_iso_code)),
            'password'          =>  bcrypt('password'),//password
            'email_verified_at' =>  now(),
            'language_id'       =>  Language::inRandomOrder()->first()->id,
            // 'status'            =>  $this->faker->randomElement(['active', 'inactive', 'pending',])
        ];
    }


     /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (MobileAppUser $user) {
            $company = str_starts_with($user->email, 'employee') ? Company::find(1) : Company::inRandomOrder()->first();
            $user->companies()->attach($company->id, [
                'status'    =>  $this->faker->randomElement([CompanyUser::STATUS_ACTIVE, CompanyUser::STATUS_INACTIVE, CompanyUser::STATUS_PENDING])
            ]);
        });
    }
}
