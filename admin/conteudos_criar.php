<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

$pageTitle = 'Criar Conteúdo - GreenTrack';
require_once '../layouts/header.php';

$errors = [];
$titulo = $conteudo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);

    if (empty($titulo)) {
        $errors[] = 'O título é obrigatório.';
    }

    if (empty($conteudo)) {
        $errors[] = 'O conteúdo é obrigatório.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO conteudos (titulo, conteudo, utilizador_id) VALUES (?, ?, ?)");
        if ($stmt->execute([$titulo, $conteudo, $_SESSION['utilizador_id']])) {
            $_SESSION['success_message'] = 'Conteúdo criado com sucesso!';
            header('Location: conteudos.php');
            exit();
        } else {
            $errors[] = 'Ocorreu um erro ao criar o conteúdo.';
        }

    }
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">Criar Novo Conteúdo</h1>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mt-4">
                    <h5>Erros encontrados:</h5>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card mt-4">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($titulo) ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="conteudo" class="form-label">Conteúdo</label>
                                <textarea class="form-control" id="conteudo" name="conteudo" rows="8" required><?= htmlspecialchars($conteudo) ?></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="conteudos.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Publicar Conteúdo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layouts/footer.php'; ?>