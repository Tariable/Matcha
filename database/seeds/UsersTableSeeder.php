<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 10)->create();
        DB::table('users')->insert([
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$MR8W2lHt23aER2oOqeQl6.X82vNm0SDGx1oAOsRBkHYQRQLn3MNHe',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),]);
    }
}
