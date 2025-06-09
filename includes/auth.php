<?php
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    
    session_start();
}

function estaLogado() {
    return isset($_SESSION['utilizador_id']) && !sessaoExpirada();
}

function sessaoExpirada($tempo_limite = 1800) {
    if (!isset($_SESSION['ultimo_acesso'])) {
        return true;
    }
    
    if (time() - $_SESSION['ultimo_acesso'] > $tempo_limite) {
        session_unset();
        session_destroy();
        return true;
    }
    
    $_SESSION['ultimo_acesso'] = time();
    return false;
}

function requireLogin($redirect_url = '../login.php') {
    if (!estaLogado()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: $redirect_url");
        exit();
    }
}

function requireAdmin($redirect_url = '../user/dashboard.php') {
    requireLogin();
    
    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'admin') {
        header("Location: $redirect_url");
        exit();
    }
}

function redirectIfLoggedIn($admin_url = 'admin/dashboard.php', $user_url = 'user/dashboard.php') {
    if (estaLogado()) {
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
            exit();
        }
        
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin') {
            header("Location: $admin_url");
        } else {
            header("Location: $user_url");
        }
        exit();
    }
}

function eAdmin() {
    return estaLogado() && isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin';
}

function logout() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

function gerarTokenCSRF() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

function verificarTokenCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

