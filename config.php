<?php
// Configurações globais
define('SITE_NAME', 'GreenTrack');
define('SITE_EMAIL', 'info@greentrack.pt');
define('ADMIN_EMAIL', 'admin@greentrack.pt');

// Configurações de sessão
session_set_cookie_params([
    'lifetime' => 86400, // 1 dia
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações de exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>