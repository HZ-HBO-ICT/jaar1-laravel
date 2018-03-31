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
        'state' => $faker->numberBetween(0, 3),
        'rating' => $faker->numberBetween(0, 5),
        'hours_planned' => $faker->numberBetween(2, 4),
        'progress' => $faker->numberBetween(0, 100),
    ];
});
