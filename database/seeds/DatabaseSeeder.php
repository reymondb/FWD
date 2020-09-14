<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'id' => '1',
            'name' => 'Administrator',
            'email' => 'itadmin@forwardbpo.com',
            'password' => Hash::make('T3@rs0fth3Suns@)@)')
        ]);

        DB::table('user_roles')->insert(
            [
                [
                    'id' => 1,
                    'description' => 'Administrator',
                ],
                [
                    'id' => 2,
                    'description' => 'Supplier',
                ],
                [
                    'id' => 3,
                    'description' => 'User',
                ]
            ]
        );
    }
}
