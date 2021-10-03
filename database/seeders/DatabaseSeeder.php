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
//            'active' => 1,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
//
//        $user = \App\Models\User::where('name', '系統管理者')->get()->first();
//        $user->assignRole('系統管理者');

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

        for ($i = 1; $i <= 20; $i++) {
            DB::table('news')->insert([
                'news_types_id' => 2,
                'title' => '這是測試news這是測試news這是測試news這是測試news這是測試news-' . $i,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now(),
                'web_img_name' => 'S__111558660.jpg',
                'web_img' => 'news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg',
                'mobile_img_name' => 'S__111558660.jpg',
                'mobile_img' => 'news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }
}
