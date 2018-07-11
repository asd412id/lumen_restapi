<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\UserModel::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'username' => $faker->username,
    'password' => app('hash')->make('password'),
    'address' => $faker->address
  ];
});
$factory->define(App\Models\PostModel::class, function (Faker\Generator $faker) {
  $title = $faker->sentence(7);
  return [
    'user_id' => rand(1,3),
    'title' => $title,
    'content' => $faker->sentence(300),
    'slug' => str_slug($title,'-'),
    'status' => 1
  ];
});
