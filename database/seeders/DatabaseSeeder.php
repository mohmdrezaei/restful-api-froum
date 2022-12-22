<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Thread;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleInDatabase = Role::where('name', config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (config('permission.default_roles') as $role)
                Role::create([
                    'name' => $role
                ]);

        }

        $permissionInDatabase = Permission::where('name', config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (config('permission.default_permissions') as $permission)
                Permission::create([
                    'name' => $permission
                ]);

        }

        Thread::factory(100)->create();
    }
}
