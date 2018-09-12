<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";
const MODE = 'dev';
const AVATAR_DIR = 'img/';
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$gump = new GUMP();
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'mvc_local',
    'username'  => 'mysql',
    'password'  => 'mysql',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);


// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

class User extends Illuminate\Database\Eloquent\Model
{

}



