<?php

use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/movies.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          DB::table('movies')->insert([
            'id' => $obj->id,
            'title' => $obj->title,
            'release_date' => $obj->release_date,
            'duration' => $obj->duration,
            'genre' => $obj->genre
          ]);
        }
    }
}
