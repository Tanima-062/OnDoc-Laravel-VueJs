<?php

namespace Database\Seeders;

use App\Models\MobileAppUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MobileAppUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = MobileAppUser::factory()->create([
            'email' =>  'naveedhcse@gmail.com',
            // 'status'    =>  MobileAppUser::STATUS_ACTIVE
        ]);
        $user1->companies()->sync([1 => ['status' => 'active']], false);
        MobileAppUser::factory()->create([
            'email' =>  'cse.exe@gmail.com',
            // 'status'    =>  MobileAppUser::STATUS_ACTIVE,
            'password'  =>  bcrypt('Password12@')
        ]);

        $user2 = MobileAppUser::factory()->create([
            'email' =>  'badhonoffice@gmail.com',
            // 'status'    =>  MobileAppUser::STATUS_ACTIVE
        ]);
        $user2->companies()->sync([1 => ['status' => 'active']], false);


        MobileAppUser::factory()->create([
            'email' =>  sprintf('employee@mail.com')
        ]);

        for($i = 0 ; $i<100; $i++){
            if($i< 50){
                MobileAppUser::factory()->create([
                    'email' =>  sprintf('employee%s@mail.com', $i),
                    // 'status'    =>  MobileAppUser::STATUS_ACTIVE
                ]);
            }
            else {
                MobileAppUser::factory()->create([
                    'email' =>  sprintf('employee%s@mail.com', $i)
                ]);
            }
        }

        MobileAppUser::factory()->count(100)->create();
    }
}
