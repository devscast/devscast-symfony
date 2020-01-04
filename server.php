<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
    return false;
} else {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/index.php';
}
