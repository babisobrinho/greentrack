<?php
require_once 'db.php';
require_once 'auth.php';
require_once 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../registo.php?error=Método de requisição inválido.');
    exit();
}

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$palavra_passe = $_POST['palavra_passe'] ?? '';
$confirmar_palavra_passe = $_POST['confirmar_palavra_passe'] ?? '';
$termos = isset($_POST['termos']) ? true : false;

if (empty($nome) || empty($data_nascimento) || empty($email) || empty($palavra_passe) || empty($confirmar_palavra_passe)) {
    header('Location: ../registo.php?error=Por favor, preencha todos os campos.');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../registo.php?error=Por favor, introduza um email válido.');
    exit();
}

if (strlen($palavra_passe) < 8) {
    header('Location: ../registo.php?error=A palavra-passe deve ter pelo menos 8 caracteres.');
    exit();
}

if ($palavra_passe !== $confirmar_palavra_passe) {
    header('Location: ../registo.php?error=As palavras-passe não coincidem.');
    exit();
}

if (!$termos) {
    header('Location: ../registo.php?error=Deve aceitar os termos de serviço para continuar.');
    exit();
}

try {
    $data_nascimento_obj = new DateTime($data_nascimento);
    $hoje = new DateTime();
    
    if ($data_nascimento_obj > $hoje) {
        header('Location: ../registo.php?error=A data de nascimento não pode ser no futuro.');
        exit();
    }
    
    $idade = $hoje->diff($data_nascimento_obj)->y;
    if ($idade < 18) {
        header('Location: ../registo.php?error=É necessário ter pelo menos 18 anos para se registar.');
        exit();
    }
} catch (Exception $e) {
    header('Location: ../registo.php?error=Data de nascimento inválida.');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT id FROM utilizadores WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        header('Location: ../registo.php?error=Este email já está registrado. Por favor, utilize outro email ou faça login.');
        exit();
    }
    
    $palavra_passe_hash = password_hash($palavra_passe, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("
        INSERT INTO utilizadores (nome, email, data_nascimento, palavra_passe, tipo, data_registro) 
        VALUES (?, ?, ?, ?, 'regular', NOW())
    ");
    
    $resultado = $stmt->execute([$nome, $email, $data_nascimento, $palavra_passe_hash]);
    
    if (!$resultado) {
        throw new Exception('Erro ao inserir o utilizador no banco de dados.');
    }
    
    $utilizador_id = $pdo->lastInsertId();
    
    $_SESSION['success_message'] = 'Registro realizado com sucesso! Faça login para continuar.';
    header('Location: ../login.php');
    exit();
    
} catch (PDOException $e) {
    error_log('Erro no registro: ' . $e->getMessage());
    
    header('Location: ../registo.php?error=Ocorreu um erro ao processar o registro. Por favor, tente novamente mais tarde.');
    exit();
} catch (Exception $e) {
    header('Location: ../registo.php?error=' . $e->getMessage());
    exit();
}
?>

