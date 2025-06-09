<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = 'ID inválido.';
    header('Location: historico.php');
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM acoes_sustentaveis WHERE id = ?");
$stmt->execute([$id]);
$acao = $stmt->fetch();

if (!$acao) {
    $_SESSION['error_message'] = 'Ação não encontrada.';
    header('Location: historico.php');
    exit;
}

if ($acao['utilizador_id'] != $_SESSION['utilizador_id']) {
    $_SESSION['error_message'] = 'Não tem permissão para excluir esta ação.';
    header('Location: historico.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM acoes_sustentaveis WHERE id = ? AND utilizador_id = ?");
        $stmt->execute([$id, $_SESSION['utilizador_id']]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['success_message'] = 'Ação eliminada com sucesso!';
        } else {
            $_SESSION['error_message'] = 'A ação não foi encontrada ou já foi eliminada.';
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Erro ao eliminar ação. Por favor, tente novamente.';
    }
    
    header('Location: historico.php');
    exit;
}
?>