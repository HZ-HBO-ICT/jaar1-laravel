<?php

use Illuminate\Database\Seeder;
use App\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Task::class)->create([
            'title' => 'Go to the store'
        ]);
        factory(Task::class)->create([
            'title' => 'Finish my screencast'
        ]);
        factory(Task::class)->create([
            'title' => 'Clean the house'
        ]);
        factory(Task::class, 97)->create();

        // Make some of the tasks subtask of some other task.
        // do this only if we have a sensible amount of tasks
        foreach (Task::where('id', '>', '3')->get() as $task) {
                $this->command->info("Finding parent for " . $task->id);
                $parent = $this->getParentFromRoots();
                $parent->children()->save($task);
        }
    }

    private function getParentFromRoots()
    {
        $id = rand(1,3);
        $maxdepth = rand(0, 4);
        return $this->getParent(Task::find($id), $maxdepth);
    }

    private function getParent($parent, $max_dept)
    {
        if ($max_dept == 0 || !$parent->has_children)
        {
            return $parent;
        }
        $child = $parent->children()->inRandomOrder()->first();
        return $this->getParent($child, $max_dept-1);
    }

}
