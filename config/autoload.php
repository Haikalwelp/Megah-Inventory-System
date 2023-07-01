<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($className)
{
    $paths = [
        "../Controllers/",
        "../Model/",
    ];
    $extension = ".php";

    foreach ($paths as $path) {
        $fullPath = $path . $className . $extension;
        if (file_exists($fullPath)) {
            include_once $fullPath;
            break;
        }
    }
}

?>