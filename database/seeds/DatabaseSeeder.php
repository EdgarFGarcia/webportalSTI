<?php

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
        // $this->call(UsersTableSeeder::class);

        $roles = DB::table('roles')->insert([
            'name' => "admin"
        ]);

        $roles2 = DB::table('roles')->insert([
            'name' => "faculty"
        ]);

        $roles3 = DB::table('roles')->insert([
            'name' => "student"
        ]);

        $roles = DB::table('roles')->insert([
            'name' => "accounting"
        ]);

        $subjects = DB::table('subjects')->insert([
            "name" => "CS Major 1"
        ]);

        $users = DB::table('users')->insert([
            "fullname" => "Admin Admin",
            "number" => "639455090428",
            "email" => "admin@webportal.com",
            "username" => "admin",
            "password" => bcrypt('admin123'),
            "roles_id" => 1,
            "is_validated" => 1
        ]);
    }
}
