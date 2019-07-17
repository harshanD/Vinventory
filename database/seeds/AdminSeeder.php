<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'avatar' => '/img/avatar.png',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'status' => 0,
        ]);
        $roles = array('Admin', 'Employee', 'Default');

        foreach ($roles as $role):
            Role::create(
                ['name' => $role]
            );
        endforeach;

        DB::table('role_user')->insert(
            [
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
