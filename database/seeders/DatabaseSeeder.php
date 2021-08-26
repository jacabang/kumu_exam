<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $users = DB::table('users')->insertGetId([
            'name' => 'Jeffrey Cabang',
            'email' => 'jeffreycabang@gmail.com ',
            'password' => bcrypt('123qwe')
        ]);
    }
}