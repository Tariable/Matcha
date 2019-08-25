<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = array(
            array('name' => 'anime'),
            array('name' => 'films'),
            array('name' => 'walking'),
            array('name' => 'sex'),
            array('name' => 'food'),
            array('name' => 'pauche'),
        );
        DB::table('tags')->insert($tags);
    }
}
