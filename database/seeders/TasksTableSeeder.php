<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use  Faker\Factory;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()    {
        
        $faker = Factory::create("tr_TR");
        for ($i = 0; $i < 50; $i++) {

            Task::insert([
                "title"=>$faker->text(50),
                "details"=>$faker->text(300),
                "order"=>$i,
            ]);
        }
    }
}
