<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    $pars = rand(2,7);
    $body = "";
    for ($i=0; $i<$pars; $i++) {
        $paragraph = $faker->paragraph(rand(3,10));
        $body .= "<p>$paragraph</p>";
    }
    return [
        'title' => $faker->sentence,
        'body' => $body,
        'progress' => $faker->numberBetween(0, 100),
    ];
});
