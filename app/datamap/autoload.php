<?php

function datamapAutoload($class) {
    $tmp = explode('\\', $class);
    $file = __DIR__.'/table/'.end($tmp).'.php';
    if (is_file($file)) {
        include $file;
    }
}

spl_autoload_register('datamapAutoload');
