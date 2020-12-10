<?php 

declare(strict_types=1);

// ERRORS

ini_set('display_errors', 'true');
ini_set('display_startup_errors', 'true');
error_reporting(E_ALL);

// PACKAGES

require 'vendor/autoload.php';
use Dotenv\Dotenv;
use Tracy\Debugger;
use Faker\Factory;
use Josantonius\Session\Session;
use Codebase\Test;

// INIT

Dotenv::createImmutable(__DIR__)->load();       // Load .env variables

Debugger::enable(Debugger::DEVELOPMENT);        // Tracy debugger

$FAKER = Factory::create();                     // Faker generator

Session::setPrefix('app_');                     // Session
Session::init();


// EXEC

dump($_ENV);

$test = new Test();

Session::set("id_user", 'xyz');
// dump(Session::get("id_user"));
// dump(Session::pull("id_user"));
dump(Session::id());

dump($_SESSION);
?>

