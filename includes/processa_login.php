<?php
require_once 'db.php';
require_once 'auth.php';
require_once 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php?error=Método de requisição inválido.');
    exit();
}

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$palavra_passe = $_POST['palavra_passe'] ?? '';
$lembrar = isset($_POST['lembrar']) ? true : false;

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../login.php?error=Por favor, introduza um email válido.');
    exit();
}

if (empty($palavra_passe)) {
    header('Location: ../login.php?error=Por favor, introduza a sua palavra-passe.');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $utilizador = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$utilizador || !password_verify($palavra_passe, $utilizador['palavra_passe'])) {
        header('Location: ../login.php?error=Email ou palavra-passe incorretos. Por favor, tente novamente.');
        exit();
    }

    session_regenerate_id(true);

    $_SESSION['utilizador_id'] = $utilizador['id'];
    $_SESSION['email'] = $utilizador['email'];
    $_SESSION['nome'] = $utilizador['nome'];
    $_SESSION['tipo'] = $utilizador['tipo'];
    $_SESSION['ultimo_acesso'] = time();

    if ($lembrar) {
        $token = bin2hex(random_bytes(32));
        $expira = time() + (30 * 24 * 60 * 60);
        
        setcookie('lembrar_token', $token, $expira, '/', '', true, true);
    }

    $stmt = $pdo->prepare("UPDATE utilizadores SET ultimo_login = NOW() WHERE id = ?");
    $stmt->execute([$utilizador['id']]);

    if ($utilizador['tipo'] == 'admin') {
        $_SESSION['success_message'] = 'Bem-vindo de volta, ' . $utilizador['nome'] . '!';
        header('Location: ../admin/dashboard.php');
    } else {
        $_SESSION['success_message'] = 'Bem-vindo de volta, ' . $utilizador['nome'] . '!';
        header('Location: ../user/dashboard.php');
    }
    exit();
    
} catch (PDOException $e) {
    error_log('Erro no login: ' . $e->getMessage());
    
    header('Location: ../login.php?error=Ocorreu um erro ao processar o login. Por favor, tente novamente mais tarde.');
    exit();
}
?>

