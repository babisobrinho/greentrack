<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

$pageTitle = 'Editar Perfil - GreenTrack';
require_once '../layouts/header.php';

$stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE id = ?");
$stmt->execute([$_SESSION['utilizador_id']]);
$utilizador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilizador) {
    header('Location: logout.php');
    exit();
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $palavra_passe_atual = $_POST['palavra_passe_atual'] ?? '';
    $nova_palavra_passe = $_POST['nova_palavra_passe'] ?? '';
    $confirmar_palavra_passe = $_POST['confirmar_palavra_passe'] ?? '';
    
    if (empty($nome) || empty($data_nascimento)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif (!empty($nova_palavra_passe) && $nova_palavra_passe != $confirmar_palavra_passe) {
        $erro = 'As novas palavras-passe não coincidem.';
    } elseif (!empty($nova_palavra_passe) && strlen($nova_palavra_passe) < 8) {
        $erro = 'A nova palavra-passe deve ter pelo menos 8 caracteres.';
    } else {
        try {
            $pdo->beginTransaction();
            
            if (!empty($nova_palavra_passe)) {
                if (!password_verify($palavra_passe_atual, $utilizador['palavra_passe'])) {
                    throw new Exception('Senha atual incorreta.');
                }
                $palavra_passe_hash = password_hash($nova_palavra_passe, PASSWORD_DEFAULT);
            } else {
                $palavra_passe_hash = $utilizador['palavra_passe'];
            }
            
            $stmt = $pdo->prepare("UPDATE utilizadores SET nome = ?, data_nascimento = ?, palavra_passe = ?, data_atualizacao = NOW() WHERE id = ?");
            $stmt->execute([$nome, $data_nascimento, $palavra_passe_hash, $_SESSION['utilizador_id']]);
            
            $pdo->commit();
            $sucesso = 'Perfil atualizado com sucesso!';
            
            $_SESSION['nome'] = $nome;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $erro = $e->getMessage();
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">Editar Perfil</h2>
                    
                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($sucesso): ?>
                        <div class="alert alert-success"><?php echo $sucesso; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                value="<?php echo htmlspecialchars($utilizador['nome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" 
                                value="<?php echo htmlspecialchars($utilizador['data_nascimento']); ?>" required>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">Alterar Palavra-passe</h5>
                        <div class="mb-3">
                            <label for="palavra_passe_atual" class="form-label">Palavra-passe Atual</label>
                            <input type="password" class="form-control" id="palavra_passe_atual" name="palavra_passe_atual">
                        </div>
                        <div class="mb-3">
                            <label for="nova_palavra_passe" class="form-label">Nova Palavra-passe</label>
                            <input type="password" class="form-control" id="nova_palavra_passe" name="nova_palavra_passe">
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_palavra_passe" class="form-label">Confirmar Nova Palavra-passe</label>
                            <input type="password" class="form-control" id="confirmar_palavra_passe" name="confirmar_palavra_passe">
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            <a href="perfil.php" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layouts/footer.php'; ?>