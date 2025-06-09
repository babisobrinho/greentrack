<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireAdmin();

$pageTitle = 'Editar Utilizador - GreenTrack';
require_once '../layouts/header.php';

if (!isset($_GET['id'])) {
    header('Location: utilizadores.php');
    exit();
}

$id = $_GET['id'];
$errors = [];

$stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE id = ?");
$stmt->execute([$id]);
$utilizador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilizador) {
    header('Location: utilizadores.php');
    exit();
}

$nome = $utilizador['nome'];
$email = $utilizador['email'];
$data_nascimento = $utilizador['data_nascimento'];
$tipo = $utilizador['tipo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $data_nascimento = $_POST['data_nascimento'];
    $tipo = $_POST['tipo'];
    $palavra_passe = $_POST['palavra_passe'];
    $confirmar_passe = $_POST['confirmar_passe'];

    if (empty($nome)) {
        $errors[] = 'O nome é obrigatório.';
    }

    if (empty($email)) {
        $errors[] = 'O email é obrigatório.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'O email não é válido.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM utilizadores WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) {
            $errors[] = 'Este email já está registrado.';
        }
    }

    if (empty($data_nascimento)) {
        $errors[] = 'A data de nascimento é obrigatória.';
    }

    if (!empty($palavra_passe)) {
        if (strlen($palavra_passe) < 8) {
            $errors[] = 'A palavra-passe deve ter pelo menos 8 caracteres.';
        } elseif ($palavra_passe !== $confirmar_passe) {
            $errors[] = 'As palavras-passe não coincidem.';
        }
    }

    if (empty($errors)) {
        if (!empty($palavra_passe)) {
            $hashed_passe = password_hash($palavra_passe, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE utilizadores SET nome = ?, email = ?, data_nascimento = ?, palavra_passe = ?, tipo = ? WHERE id = ?");
            $success = $stmt->execute([$nome, $email, $data_nascimento, $hashed_passe, $tipo, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE utilizadores SET nome = ?, email = ?, data_nascimento = ?, tipo = ? WHERE id = ?");
            $success = $stmt->execute([$nome, $email, $data_nascimento, $tipo, $id]);
        }

        if ($success) {
            $_SESSION['success_message'] = 'Utilizador atualizado com sucesso!';
            header('Location: utilizadores.php');
            exit();
        } else {
            $errors[] = 'Ocorreu um erro ao atualizar o utilizador.';
        }
    }
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">Editar Utilizador</h1>
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
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($data_nascimento) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">Tipo de Utilizador</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="regular" <?= $tipo === 'regular' ? 'selected' : '' ?>>Regular</option>
                                    <option value="admin" <?= $tipo === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="palavra_passe" class="form-label">Nova Palavra-passe (opcional)</label>
                                <input type="password" class="form-control" id="palavra_passe" name="palavra_passe">
                                <small class="text-muted">Deixe em branco para manter a atual</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmar_passe" class="form-label">Confirmar Nova Palavra-passe</label>
                                <input type="password" class="form-control" id="confirmar_passe" name="confirmar_passe">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="utilizadores.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Atualizar Utilizador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layouts/footer.php'; ?>