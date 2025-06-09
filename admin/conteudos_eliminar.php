<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

if (!isset($_GET['id'])) {
    header('Location: conteudos.php');
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM conteudos WHERE id = ?");
$stmt->execute([$id]);
$conteudo = $stmt->fetch();

if (!$conteudo) {
    $_SESSION['error_message'] = 'Conteúdo não encontrado.';
    header('Location: conteudos.php');
    exit();
}

if ($conteudo['utilizador_id'] != $_SESSION['utilizador_id'] && $_SESSION['tipo'] !== 'admin') {
    $_SESSION['error_message'] = 'Você não tem permissão para excluir este conteúdo.';
    header('Location: conteudos.php');
    exit();
}

try {
    $pdo->beginTransaction();
    
    $pdo->exec("DELETE FROM votos WHERE conteudo_id = $id");
    
    $stmt = $pdo->prepare("DELETE FROM conteudos WHERE id = ?");
    $stmt->execute([$id]);
    
    $pdo->commit();
    
    $_SESSION['success_message'] = 'Conteúdo excluído com sucesso!';
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error_message'] = 'Erro ao excluir o conteúdo: ' . $e->getMessage();
}

header('Location: conteudos.php');
exit();
?>