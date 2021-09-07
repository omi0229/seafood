<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

//        DB::table('users')->insert([
//            'account' => 'admin',
//            'password' => Hash::make('admin'),
//            'name' => '系統管理者',
//            'email' => 'josh.chiang@aibitechcology.com',
//            'role_id' => 1,
//            'active' => 1,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);

        $user = \App\Models\User::where('name', '系統管理者')->get()->first();
        $user->assignRole('系統管理者');

//        for ($i = 10; $i <= 100; $i++) {
//            DB::table('users')->insert([
//                'account' => 'test' . $i,
//                'password' => Hash::make('1234qwer'),
//                'name' => 'test' . $i,
//                'email' => 'test' . $i . '@test.com',
//                'role_id' => 1,
//                'active' => 1,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }

    }
}
