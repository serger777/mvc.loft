<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/config.php";

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;



Capsule::schema()->dropIfExists('users');

Capsule::schema()->create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('login'); //varchar 255
    $table->string('password'); //varchar 255
    $table->string('name'); //varchar 255
    $table->integer('age');
    $table->string('description'); //varchar 255
    $table->string('avatar_path'); //varchar 255
    $table->timestamps(); //created_at&updated_at тип datetime
});



Capsule::schema()->dropIfExists('files');

Capsule::schema()->create('files', function (Blueprint $table) {
    $table->increments('id');
    $table->string('login');
    $table->string('file_path'); //varchar 255
    $table->timestamps(); //created_at&updated_at тип datetime
});



