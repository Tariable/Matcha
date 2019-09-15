<?php

use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 1000;
        factory(\App\Preference::class, $numberOfUsers)->create();
    }
}
