<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'PK owner';
        $user->email = 'owner@gmail.com';
        $user->password = bcrypt('123456');
        $user->role = 'owner';
        $user->status = 'active';
        $user->save();
    }
}
