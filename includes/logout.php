<?php
session_start();
$nome_usuario = $_SESSION['nome'] ?? 'Utilizador';
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
session_start();

$_SESSION['success_message'] = "Sessão encerrada com sucesso. Até breve, $nome_usuario!";

header('Location: ../index.php');
exit();
?>

