<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 2000;
        for ($i = 1; $i <= $numberOfUsers; $i++) {
            factory(\App\Like::class, 1)->create(['profile_id' => $i]);
        }
    }
}
