<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

$pageTitle = 'Editar Ação - GreenTrack';
require_once '../layouts/header.php';

$stmt = $pdo->query("SELECT nome FROM categorias ORDER BY nome");
$categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);

$erro = '';
$sucesso = '';

$acao_id = $_GET['id'] ?? 0;
if (!is_numeric($acao_id)) {
    header('Location: historico.php');
    exit;
}

$acao = null;
try {
    $stmt = $pdo->prepare("SELECT * FROM acoes_sustentaveis WHERE id = ? AND utilizador_id = ?");
    $stmt->execute([$acao_id, $_SESSION['utilizador_id']]);
    $acao = $stmt->fetch();
} catch (PDOException $e) {
    $erro = 'Erro ao carregar ação.';
}

if (!$acao) {
    header('Location: acoes_listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $impacto = $_POST['impacto'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    
    if (empty($nome) || empty($impacto) || empty($categoria)) {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif (!is_numeric($impacto) || $impacto <= 0) {
        $erro = 'O impacto deve ser um número positivo.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE acoes_sustentaveis SET nome = ?, impacto = ?, categoria = ? WHERE id = ? AND utilizador_id = ?");
            $stmt->execute([$nome, $impacto, $categoria, $acao_id, $_SESSION['utilizador_id']]);
            $sucesso = 'Ação atualizada com sucesso!';
            
            $acao['nome'] = $nome;
            $acao['impacto'] = $impacto;
            $acao['categoria'] = $categoria;
        } catch (PDOException $e) {
            $erro = 'Erro ao atualizar ação. Por favor, tente novamente.';
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">Editar Ação Sustentável</h2>
                    
                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($sucesso): ?>
                        <div class="alert alert-success"><?php echo $sucesso; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Ação</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($acao['nome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="impacto" class="form-label">Impacto (kg CO₂)</label>
                            <input type="number" step="0.01" class="form-control" id="impacto" name="impacto" value="<?php echo htmlspecialchars($acao['impacto']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="">Selecione uma categoria</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat; ?>" <?php echo ($cat == $acao['categoria']) ? 'selected' : ''; ?>>
                                        <?php echo $cat; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="historico.php" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-success">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layouts/footer.php'; ?>