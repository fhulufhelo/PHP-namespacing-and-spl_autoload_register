<?php

// setup class autoloading

require __DIR__ . '/autoloader/Loader.php';

use Autoload\Loader;

Loader::init(__DIR__ );


use App\Test\TestClass;

$test = new TestClass();



