<?php

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 10;
        for ($i = 1; $i <= $numberOfUsers; $i++) {
            $numberOfPhotos = random_int(1,5);
            for ($j = 0; $j < $numberOfPhotos; $j++) {
                factory(\App\Photo::class)->create(['user_id' => $i]);
            }
        }
    }
}
