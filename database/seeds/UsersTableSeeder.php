<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

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
        $user->name = 'laravel';
        $user->email = 'laravel@laravel.com';
        $user->password = bcrypt('123456');

        $user->save();

        // DB::table('users')->insert([
        //     'name' => 'laravel_passport',
        //     'email' => 'laravel_passport@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'created_at' => Carbon::now()
        // ]);
    }
}
