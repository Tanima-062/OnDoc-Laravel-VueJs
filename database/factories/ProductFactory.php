<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CompanyAdmin;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $admin = User::where('id', '!=', 1)->inRandomOrder()->first();
        $category = Category::inRandomOrder()->where('company_id', $admin->company_id)->first();
        $supplier = Supplier::inRandomOrder()->where('company_id', $admin->company_id)->first();

        $start_time = $this->faker->dateTimeBetween('now', '+2 month');
        $end_time =  $this->faker->dateTimeBetween('now', '+4 month');
        $start = $start_time->format('Y-m-d');
        $end = $end_time->format('Y-m-d');

        return [
            'serial_number' =>  mt_rand(),
            'warranty_start_date' => $start,
            'warranty_end_date' => $end,
            'name'          =>  $this->faker->name,
            'company_id'    =>  $admin->company_id,
            'category_id'   =>  $category ? $category->id : null,
            'supplier_id'   =>  $supplier ? $supplier->id : null,
            'user_id'       =>  $admin->id,
            'public_access' =>  $this->faker->boolean(70),
            'status'        =>  $this->faker->randomElement(['active', 'inactive'])
        ];
    }
}
