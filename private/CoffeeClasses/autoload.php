<?php
namespace CoffeeClasses;

function coffeeLoad($class)
{
    $file = dirname(__DIR__) . '/' . str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".class.php";
    if (is_file($file) && file_exists($file)) {
        include_once $file;
    }
}

// autoload coffee classes - assume namespace structure is same as directory structure
spl_autoload_register("CoffeeClasses\coffeeLoad");
