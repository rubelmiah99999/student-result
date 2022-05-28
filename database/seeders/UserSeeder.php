<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users =  [
            [
              'name' => 'Admin',
              'email' => 'admin@gmail.com',
              'password' => bcrypt('123123123'),
              'is_admin'    => 1,
            ],
            [
              'name' => 'User',
              'email' => 'user@gmail.com',
              'password' => bcrypt('123123123'),
              'is_admin'            => 0
            ]           
          ];

          User::insert($users);
      
    }
}
