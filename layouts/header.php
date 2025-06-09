<?php
if (!isset($relativePath)) {
    $relativePath = '';
    $currentDir = dirname($_SERVER['SCRIPT_NAME']);
    if (strpos($currentDir, 'user') !== false || strpos($currentDir, 'admin') !== false) {
        $relativePath = '../';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'GreenTrack'; ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo $relativePath; ?>assets/img/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="<?php echo $relativePath; ?>assets/css/variables.css">
    <link rel="stylesheet" href="<?php echo $relativePath; ?>assets/css/style.css">
</head>
<body>
    <header class="p-0 m-0">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?php echo $relativePath; ?>index.php">
                    <img src="<?php echo $relativePath; ?>assets/img/logo.png" alt="GreenTrack Logo" width="40" class="me-2">
                    <span>GreenTrack</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if(isset($_SESSION['utilizador_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $relativePath . ($_SESSION['tipo'] == 'admin' ? 'admin/' : 'user/') . 'dashboard.php'; ?>">
                                    Dashboard
                                </a>
                            </li>
                            <?php if($_SESSION['tipo'] == 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $relativePath; ?>admin/utilizadores.php">
                                        Utilizadores
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $relativePath; ?>admin/conteudos.php">
                                        Conteúdos
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $relativePath; ?>user/perfil.php">
                                        Perfil
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $relativePath; ?>user/conteudos.php">
                                        Conteúdos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $relativePath; ?>user/historico.php">
                                        Histórico de Ações
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $relativePath; ?>includes/logout.php">
                                    Sair
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo $relativePath; ?>index.php">
                                    Início
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'sobre.php' ? 'active' : ''; ?>" href="<?php echo $relativePath; ?>sobre.php">
                                    Sobre
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'registo.php' ? 'active' : ''; ?>" href="<?php echo $relativePath; ?>registo.php">
                                    Registo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>" href="<?php echo $relativePath; ?>login.php">
                                    Login
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <div class="d-flex align-items-center">
                <iconify-icon icon="solar:check-circle-bold" class="me-2" width="24" height="24"></iconify-icon>
                <div><?= $_SESSION['success_message'] ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <div class="d-flex align-items-center">
                <iconify-icon icon="solar:danger-triangle-bold" class="me-2" width="24" height="24"></iconify-icon>
                <div><?= $_SESSION['error_message'] ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <main>

