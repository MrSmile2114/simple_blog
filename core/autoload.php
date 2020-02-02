<?php

function __autoload($className)
{
    $fileName = 'core/'.str_replace('\\', '/', $className).'.php';
    if (!file_exists($fileName)) {
        throw new Exception('Class not found: '.$className.'. Path: '.$fileName);
    }
    require_once $fileName;
}
