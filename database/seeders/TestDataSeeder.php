<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);

        $user = User::factory()->create([
            'type'  =>  'system_admin',
            'email'  =>  'system@mail.com',
            "language_id"   =>  2,
            'status'        =>  User::STATUS_ACTIVE,
            'company_id'    =>  null
        ]);

        // $this->call(CompanySeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(SupplierSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(MobileAppUserSeeder::class);

        // $this->call(BookmarkSeeder::class);
    }
}
