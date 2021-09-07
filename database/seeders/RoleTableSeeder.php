<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => '系統管理者']);
        Permission::create(['name' => 'set_basic', 'display_name' => '基本設定']);
        Permission::create(['name' => 'set_manager', 'display_name' => '人員管理']);
        Permission::create(['name' => 'set_message', 'display_name' => '簡訊設定']);
        $role->syncPermissions(Permission::all());
    }
}
