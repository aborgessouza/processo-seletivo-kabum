<?php

spl_autoload_register(function ($className) {
    $baseDir = preg_replace('/(.*)\/.*/i' , '$1' ,__DIR__);
    $extension =  spl_autoload_extensions('.php');
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $file =  sprintf("%s%s%s%s" , $baseDir,DIRECTORY_SEPARATOR , $className , $extension);
    if (!is_file($file)) {
        throw new Exception(sprintf("Arquivo %s não localizado", $file));
    }
    require_once $file;
});