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
        $numberOfPhotos = 3;
        $numberOfProfiles = 20;
        $numberOfUsers = 2000;

        for ($i = 1; $i <= $numberOfUsers; $i++) {
            $profileNumber = random_int(1, $numberOfProfiles);
            for ($j = 1; $j <= $numberOfPhotos; $j++) {
                if ($i <= $numberOfUsers / 2) {
                    factory(\App\Photo::class)->create(['user_id' => $i,
                        'path' => '/storage/photos/maleProfile' . $profileNumber . '.' . $j . '.jpg']);
                } else {
                    factory(\App\Photo::class)->create(['user_id' => $i,
                        'path' => '/storage/photos/femaleProfile' . $profileNumber . '.' . $j . '.jpg']);
                }
            }
        }
    }
}
