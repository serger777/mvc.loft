<?php
require_once $_SERVER['DOCUMENT_ROOT']. "/vendor/autoload.php";

require $_SERVER['DOCUMENT_ROOT']. "/app/core/config.php";
use App\Models\User;
use App\Models\File;
use Faker\Factory;

$faker = Faker\Factory::create();

for ($i = 0; $i < 10; $i++) {
    $user = new User();
    $user->login = $faker->name();
    $user->password = $faker->password(33);
    $user->name = $faker->name();
    $user->age = $faker->numberBetween(1 - 99);
    $user->description = $faker->text;
    $user->save();

//    $file = new File();
//    $file->fileName = $file->id;
//    $file->login = $user->id;
//    $file->save();
}