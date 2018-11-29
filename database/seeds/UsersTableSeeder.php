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
        $user->email = 'owner1@gmail.com';
        $user->password = bcrypt('dpKh%4AtFV');
        $user->role = 'owner';
        $user->status = 'active';
        $user->save();
    }
}
