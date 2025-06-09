<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit();
}

if (!isset($_SESSION['utilizador_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['conteudo_id']) || !isset($data['tipo']) || !in_array($data['tipo'], ['like', 'dislike'])) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit();
}

$conteudoId = $data['conteudo_id'];
$tipo = $data['tipo'];
$userId = $_SESSION['utilizador_id'];

try {
    $stmt = $pdo->prepare("SELECT id FROM conteudos WHERE id = ?");
    $stmt->execute([$conteudoId]);
    
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Conteúdo não encontrado']);
        exit();
    }
    
    $stmt = $pdo->prepare("SELECT id, tipo FROM votos WHERE utilizador_id = ? AND conteudo_id = ?");
    $stmt->execute([$userId, $conteudoId]);
    $votoExistente = $stmt->fetch();
    
    if ($votoExistente) {
        if ($votoExistente['tipo'] === $tipo) {
            $stmt = $pdo->prepare("DELETE FROM votos WHERE id = ?");
            $stmt->execute([$votoExistente['id']]);
            $userVote = null;
        } else {
            $stmt = $pdo->prepare("UPDATE votos SET tipo = ?, data_voto = NOW() WHERE id = ?");
            $stmt->execute([$tipo, $votoExistente['id']]);
            $userVote = $tipo;
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO votos (tipo, conteudo_id, utilizador_id, data_voto) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$tipo, $conteudoId, $userId]);
        $userVote = $tipo;
    }
    
    $likes = obterContagemVotos($pdo, $conteudoId, 'like');
    $dislikes = obterContagemVotos($pdo, $conteudoId, 'dislike');
    
    echo json_encode([
        'success' => true,
        'likes' => $likes,
        'dislikes' => $dislikes,
        'user_vote' => $userVote
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}

function obterContagemVotos($pdo, $conteudoId, $tipo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE conteudo_id = ? AND tipo = ?");
    $stmt->execute([$conteudoId, $tipo]);
    return $stmt->fetchColumn();
}
?>