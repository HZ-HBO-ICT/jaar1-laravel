<?php
/**
 * Created by PhpStorm.
 * User: waar0003
 * Date: 6-3-2018
 * Time: 16:34
 */
// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('messages.home', url('/'),['icon' => 'dashboard']);
});

// Home > Tasks
Breadcrumbs::register('tasks', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('messages.my_tasks', route('tasks.index'));
});

// Home > Tasks > Create
Breadcrumbs::register('tasks.create', function ($breadcrumbs) {
    $breadcrumbs->parent('tasks');
    $breadcrumbs->push('messages.tasks_create', route('tasks.create'));
});

// Home > Tasks > [Task]
Breadcrumbs::register('task', function ($breadcrumbs, $task) {
    $breadcrumbs->parent('tasks');
    $breadcrumbs->push(str_limit($task->title, $limit = 50, $end = '...'), route('tasks.show', $task));
});

// Home > Tasks > [Task] > Edit
Breadcrumbs::register('tasks.edit', function ($breadcrumbs, $task) {
    $breadcrumbs->parent('task', $task);
    $breadcrumbs->push('messages.tasks_edit', route('tasks.edit', $task));
});

