<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
	    DB::table('roles')->insert([
		    ['name' => 'admin'],
		    ['name' => 'member']
        ]);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'address' => 'CIANJUR REGENCY CITY',
            'password' => bcrypt('admin123')
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        $member = User::create([
            'name' => 'Member',
            'email' => 'member@mail.com',
            'password' => bcrypt('member123')
        ]);
        $member->roles()->attach(Role::where('name', 'member')->first());
    }
}
