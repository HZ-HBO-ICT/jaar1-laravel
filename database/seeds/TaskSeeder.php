<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Task::class)->create([
            'title' => 'Go to the store'
        ]);
        factory(App\Task::class)->create([
            'title' => 'Finish my screencast'
        ]);
        factory(App\Task::class)->create([
            'title' => 'Clean the house'
        ]);
        factory(App\Task::class, 50)->create();
    }
}
