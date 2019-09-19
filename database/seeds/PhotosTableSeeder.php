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
        $numberOfUsers = 1000;
        $numberOfPhotos = 3;
        $numberOfProfiles = 10;
        for ($i = 1; $i <= $numberOfUsers; $i++) {
            $profileNumber = random_int(1, $numberOfProfiles);
            for ($j = 1; $j <= $numberOfPhotos; $j++) {
                factory(\App\Photo::class)->create(['user_id' => $i,
                    'path' => 'public/storage/photos/femaleProfile' . $profileNumber . '.' . $j . '.jpg']);
            }
        }
    }
}
