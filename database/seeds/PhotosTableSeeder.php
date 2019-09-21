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


        $numberOfUsers = 1000; // FIRST TIME
        for ($i = 1; $i <= $numberOfUsers; $i++) { // FIRST TIME

//        $numberOfUsers = 2000; // SECOND TIME
//        for ($i = 1001; $i <= $numberOfUsers; $i++) { // SECOND TIME


            $profileNumber = random_int(1, $numberOfProfiles);
            for ($j = 1; $j <= $numberOfPhotos; $j++) {
                factory(\App\Photo::class)->create(['user_id' => $i,
                    //                                  FIRST TIME
                    'path' => '/storage/photos/femaleProfile' . $profileNumber . '.' . $j . '.jpg']);
//                                                      SECOND TIME
//                    'path' => '/storage/photos/maleProfile' . $profileNumber . '.' . $j . '.jpg']);
            }
        }
    }
}
