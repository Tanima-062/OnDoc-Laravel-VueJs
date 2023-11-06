<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'type'  =>  User::COMPANY_ADMIN,
            'email'  =>  'companyadmin@mail.com',
            "language_id"   =>  2,
            'status'        =>  User::STATUS_ACTIVE,
            'permission'    =>  'full'
        ]);

        $user = User::factory()->create([
            'type'  =>  User::COMPANY_SUB_ADMIN,
            'email'  =>  'companysubadmin@mail.com',
            "language_id"   =>  2,
            'status'    =>  User::STATUS_ACTIVE,
            'permission'    =>  'full'
        ]);

        User::factory()->count(100)->create();
    }
}
