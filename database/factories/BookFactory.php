<?php

use App\Author;
use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'author_id' => factory(Author::class)
    ];
});
