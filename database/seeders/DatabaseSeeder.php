<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(CompanySeeder::class);
        $user = User::factory()->create([
            'type'  =>  'system_admin',
            'email'  =>  'system@mail.com',
            "language_id"   =>  2,
            'status'    =>  User::STATUS_ACTIVE,
            'company_id'    =>  null
        ]);

        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(MobileAppUserSeeder::class);

        $this->call(BookmarkSeeder::class);
    }
}
