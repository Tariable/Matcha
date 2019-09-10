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
        $quantity = 1000;
        factory(\App\Preference::class, $quantity)->create();
    }
}
