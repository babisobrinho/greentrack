<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireAdmin();

if (!isset($_GET['id'])) {
    header('Location: utilizadores.php');
    exit();
}

$id = $_GET['id'];

if ($id == $_SESSION['utilizador_id']) {
    $_SESSION['error_message'] = 'Você não pode excluir a si mesmo.';
    header('Location: utilizadores.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE id = ?");
$stmt->execute([$id]);
$utilizador = $stmt->fetch();

if (!$utilizador) {
    $_SESSION['error_message'] = 'Utilizador não encontrado.';
    header('Location: utilizadores.php');
    exit();
}

try {
    $pdo->beginTransaction();
    
    $pdo->exec("DELETE FROM votos WHERE utilizador_id = $id");
    $pdo->exec("DELETE FROM acoes_sustentaveis WHERE utilizador_id = $id");
    $pdo->exec("DELETE FROM conteudos WHERE utilizador_id = $id");
    
    $stmt = $pdo->prepare("DELETE FROM utilizadores WHERE id = ?");
    $stmt->execute([$id]);
    
    $pdo->commit();
    
    $_SESSION['success_message'] = 'Utilizador excluído com sucesso!';
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error_message'] = 'Erro ao excluir o utilizador: ' . $e->getMessage();
}

header('Location: utilizadores.php');
exit();
?>