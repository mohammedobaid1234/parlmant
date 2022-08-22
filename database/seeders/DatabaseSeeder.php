<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->name = 'Mohammed Obaid';
        $user->slug = 'mohammed_obaid';
        $user->phone_number = '0594034429';
        $user->type = '3';
        $user->password = Hash::make('12345678');
        $user->save();
        // \App\Models\User::factory(10)->create();
    }
}
