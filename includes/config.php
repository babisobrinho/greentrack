<?php
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('ASSETS_PATH', BASE_URL . 'assets/');

function getRelativePath() {
    $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
    $depth = substr_count($scriptPath, '/');
    
    if ($depth > 1) {
        return str_repeat('../', $depth - 1);
    }
    return './';
}

$relativePath = getRelativePath();