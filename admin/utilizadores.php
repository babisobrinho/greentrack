<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireAdmin();

$pageTitle = 'Gestão de Utilizadores - GreenTrack';
require_once '../layouts/header.php';

$filtro_tipo = $_GET['tipo'] ?? '';
$filtro_data_inicio = $_GET['data_inicio'] ?? '';
$filtro_data_fim = $_GET['data_fim'] ?? '';
$filtro_nome = $_GET['nome'] ?? '';
$filtro_ordem = $_GET['ordem'] ?? 'u.nome';

$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$itens_por_pagina = 10;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

$queryBase = "FROM utilizadores u WHERE 1=1";
$params = [];
$param_types = [];

if (!empty($filtro_tipo)) {
    $queryBase .= " AND u.tipo = ?";
    $params[] = $filtro_tipo;
    $param_types[] = 's';
}

if (!empty($filtro_data_inicio)) {
    $queryBase .= " AND u.data_registro >= ?";
    $params[] = $filtro_data_inicio;
    $param_types[] = 's';
}

if (!empty($filtro_data_fim)) {
    $queryBase .= " AND u.data_registro <= ?";
    $params[] = $filtro_data_fim;
    $param_types[] = 's';
}

if (!empty($filtro_nome)) {
    $queryBase .= " AND u.nome LIKE ?";
    $params[] = '%' . $filtro_nome . '%';
    $param_types[] = 's';
}

$ordenacoes_validas = ['u.nome', 'u.data_registro', 'u.tipo', 'total_acoes'];
$filtro_ordem = in_array($filtro_ordem, $ordenacoes_validas) ? $filtro_ordem : 'u.nome';
$direcao = isset($_GET['dir']) && strtolower($_GET['dir']) === 'desc' ? 'DESC' : 'ASC';

$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN u.tipo = 'admin' THEN 1 ELSE 0 END) as admins,
    SUM(CASE WHEN u.tipo = 'regular' THEN 1 ELSE 0 END) as regular,
    SUM(CASE WHEN u.data_registro >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_week
    FROM utilizadores u WHERE 1=1";

if (!empty($filtro_tipo)) {
    $stats_query .= " AND u.tipo = ?";
}
if (!empty($filtro_data_inicio)) {
    $stats_query .= " AND u.data_registro >= ?";
}
if (!empty($filtro_data_fim)) {
    $stats_query .= " AND u.data_registro <= ?";
}
if (!empty($filtro_nome)) {
    $stats_query .= " AND u.nome LIKE ?";
}

$stmt = $pdo->prepare($stats_query);

$param_index = 1;
if (!empty($filtro_tipo)) {
    $stmt->bindValue($param_index++, $filtro_tipo, PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_nome)) {
    $stmt->bindValue($param_index++, '%' . $filtro_nome . '%', PDO::PARAM_STR);
}

$stmt->execute();
$user_stats = $stmt->fetch(PDO::FETCH_ASSOC);

$stats = [
    'users' => [
        'total' => $user_stats['total'] ?? 0,
        'admins' => $user_stats['admins'] ?? 0,
        'regular' => $user_stats['regular'] ?? 0,
        'new_week' => $user_stats['new_week'] ?? 0
    ],
    'actions' => [
        'total' => 0,
        'impact' => 0,
        'avg_per_user' => 0
    ],
    'engagement' => [
        'likes' => 0,
        'dislikes' => 0,
        'avg_per_user' => 0
    ]
];

$actions_query = "SELECT 
                    COUNT(a.id) as total_acoes,
                    SUM(a.impacto) as total_impacto,
                    (SELECT AVG(action_count) FROM (
                        SELECT COUNT(a2.id) as action_count 
                        FROM utilizadores u2 
                        LEFT JOIN acoes_sustentaveis a2 ON u2.id = a2.utilizador_id
                        GROUP BY u2.id
                    ) as user_actions) as avg_per_user
                FROM utilizadores u
                LEFT JOIN acoes_sustentaveis a ON u.id = a.utilizador_id
                WHERE 1=1";

if (!empty($filtro_tipo)) {
    $actions_query .= " AND u.tipo = ?";
}
if (!empty($filtro_data_inicio)) {
    $actions_query .= " AND u.data_registro >= ?";
}
if (!empty($filtro_data_fim)) {
    $actions_query .= " AND u.data_registro <= ?";
}
if (!empty($filtro_nome)) {
    $actions_query .= " AND u.nome LIKE ?";
}

$stmt = $pdo->prepare($actions_query);

$param_index = 1;
if (!empty($filtro_tipo)) {
    $stmt->bindValue($param_index++, $filtro_tipo, PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_nome)) {
    $stmt->bindValue($param_index++, '%' . $filtro_nome . '%', PDO::PARAM_STR);
}

$stmt->execute(); 
$actions_stats = $stmt->fetch(PDO::FETCH_ASSOC);

if ($actions_stats) {
    $stats['actions']['total'] = $actions_stats['total_acoes'] ?? 0;
    $stats['actions']['impact'] = $actions_stats['total_impacto'] ?? 0;
    $stats['actions']['avg_per_user'] = $actions_stats['avg_per_user'] ?? 0;
}

$engagement_query = "SELECT 
    SUM(CASE WHEN v.tipo = 'like' THEN 1 ELSE 0 END) as likes,
    SUM(CASE WHEN v.tipo = 'dislike' THEN 1 ELSE 0 END) as dislikes,
    COUNT(v.id) / COUNT(DISTINCT u.id) as avg_per_user
    FROM utilizadores u
    LEFT JOIN votos v ON u.id = v.utilizador_id
    WHERE 1=1";

if (!empty($filtro_tipo)) {
    $engagement_query .= " AND u.tipo = ?";
}
if (!empty($filtro_data_inicio)) {
    $engagement_query .= " AND u.data_registro >= ?";
}
if (!empty($filtro_data_fim)) {
    $engagement_query .= " AND u.data_registro <= ?";
}
if (!empty($filtro_nome)) {
    $engagement_query .= " AND u.nome LIKE ?";
}

$stmt = $pdo->prepare($engagement_query);

$param_index = 1;
if (!empty($filtro_tipo)) {
    $stmt->bindValue($param_index++, $filtro_tipo, PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_nome)) {
    $stmt->bindValue($param_index++, '%' . $filtro_nome . '%', PDO::PARAM_STR);
}

$stmt->execute();
$engagement_stats = $stmt->fetch(PDO::FETCH_ASSOC);

if ($engagement_stats) {
    $stats['engagement']['likes'] = $engagement_stats['likes'] ?? 0;
    $stats['engagement']['dislikes'] = $engagement_stats['dislikes'] ?? 0;
    $stats['engagement']['avg_per_user'] = $engagement_stats['avg_per_user'] ?? 0;
}

$query = "SELECT u.*, 
            COUNT(a.id) as total_acoes,
            SUM(a.impacto) as total_impacto,
            (SELECT COUNT(*) FROM votos v WHERE v.utilizador_id = u.id) as total_votos
        FROM utilizadores u
        LEFT JOIN acoes_sustentaveis a ON u.id = a.utilizador_id
        WHERE 1=1";

$query .= substr($queryBase, strpos($queryBase, "WHERE 1=1") + 9);

$query .= " GROUP BY u.id 
            ORDER BY " . $filtro_ordem . " " . $direcao . "
            LIMIT ? OFFSET ?";

$stmt = $pdo->prepare($query);

$param_count = count($params);
for ($i = 0; $i < $param_count; $i++) {
    $stmt->bindValue($i + 1, $params[$i], $param_types[$i] === 'i' ? PDO::PARAM_INT : PDO::PARAM_STR);
}

$stmt->bindValue($param_count + 1, $itens_por_pagina, PDO::PARAM_INT);
$stmt->bindValue($param_count + 2, $offset, PDO::PARAM_INT);

$stmt->execute();
$utilizadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_query = "SELECT COUNT(*) as total " . $queryBase;
$stmt = $pdo->prepare($total_query);
$stmt->execute($params);
$total_utilizadores = $stmt->fetchColumn();
$total_paginas = ceil($total_utilizadores / $itens_por_pagina);
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">Gestão de Utilizadores</h1>
                    <p class="text-muted mb-0">Faça a gestão de todos os utilizadores da plataforma</p>
                </div>
                <a href="utilizadores_criar.php" class="btn btn-primary">
                    Novo Utilizador
                </a>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Total de Utilizadores</h6>
                            <h2 class="mb-0"><?= number_format($stats['users']['total']) ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:users-group-two-rounded-linear" width="24" height="24" class="text-primary"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span>
                                <iconify-icon icon="solar:shield-user-linear" class="me-1 text-primary"></iconify-icon>
                                <?= $stats['users']['admins'] ?> admins
                            </span>
                            <span>
                                <iconify-icon icon="solar:user-linear" class="me-1 text-muted"></iconify-icon>
                                <?= $stats['users']['regular'] ?> membros
                            </span>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: <?= $stats['users']['total'] > 0 ? ($stats['users']['admins']/$stats['users']['total'])*100 : 0 ?>%"></div>
                        </div>
                        <small class="text-muted">
                            <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                            <?= $stats['users']['new_week'] ?> novos esta semana
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Ações Registadas</h6>
                            <h2 class="mb-0"><?= number_format($stats['actions']['total']) ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:leaf-bold" width="24" height="24" class="text-info"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:chart-linear" width="16" height="16" class="text-info me-1"></iconify-icon>
                            <small class="text-muted"><?= number_format($stats['actions']['impact'], 2) ?> kg CO₂ reduzidos</small>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: <?= min(100, $stats['actions']['avg_per_user'] * 5) ?>%"></div>
                        </div>
                        <small class="text-muted">Média de <?= number_format($stats['actions']['avg_per_user'], 1) ?> por utilizador</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Interações</h6>
                            <h2 class="mb-0"><?= number_format($stats['engagement']['likes'] + $stats['engagement']['dislikes']) ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:chat-round-like-linear" width="24" height="24" class="text-success"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span>
                                <iconify-icon icon="solar:like-bold" class="text-success me-1"></iconify-icon>
                                <?= number_format($stats['engagement']['likes']) ?> likes
                            </span>
                            <span>
                                <iconify-icon icon="solar:dislike-bold" class="text-danger me-1"></iconify-icon>
                                <?= number_format($stats['engagement']['dislikes']) ?> dislikes
                            </span>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <?php 
                            $total_interactions = $stats['engagement']['likes'] + $stats['engagement']['dislikes'];
                            $likes_percent = $total_interactions > 0 ? ($stats['engagement']['likes'] / $total_interactions) * 100 : 0;
                            $dislikes_percent = $total_interactions > 0 ? ($stats['engagement']['dislikes'] / $total_interactions) * 100 : 0;
                            ?>
                            <div class="progress-bar bg-success" style="width: <?= $likes_percent ?>%"></div>
                            <div class="progress-bar bg-danger" style="width: <?= $dislikes_percent ?>%"></div>
                        </div>
                        <small class="text-muted">
                            Média de <?= number_format($stats['engagement']['avg_per_user'], 1) ?> por utilizador
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-3">Categorias Mais Ativas</h6>
                    <?php
                    $topCategories = $pdo->query("
                        SELECT categoria, COUNT(*) as total 
                        FROM acoes_sustentaveis 
                        GROUP BY categoria 
                        ORDER BY total DESC 
                        LIMIT 3
                    ")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($topCategories as $index => $category): ?>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning me-3"><?= $index + 1 ?></span>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?= htmlspecialchars($category['categoria']) ?></h6>
                                    <small class="text-muted"><?= $category['total'] ?> ações</small>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-2 rounded">
                                    <iconify-icon icon="solar:leaf-linear" width="20" height="20" class="text-warning"></iconify-icon>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Filtrar Utilizadores</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Pesquisar por nome" value="<?= htmlspecialchars($filtro_nome) ?>">
                </div>
                <div class="col-md-4">
                    <label for="data_inicio" class="form-label">Data de Registro (Início)</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= htmlspecialchars($filtro_data_inicio) ?>">
                </div>
                <div class="col-md-4">
                    <label for="data_fim" class="form-label">Data de Registro (Fim)</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= htmlspecialchars($filtro_data_fim) ?>">
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo de Utilizador</label>
                    <select id="tipo" name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="admin" <?= $filtro_tipo === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        <option value="regular" <?= $filtro_tipo === 'regular' ? 'selected' : '' ?>>Regular</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="ordem" class="form-label">Ordenar por</label>
                    <select id="ordem" name="ordem" class="form-select">
                        <option value="nome" <?= $filtro_ordem === 'nome' ? 'selected' : '' ?>>Nome</option>
                        <option value="data_registro" <?= $filtro_ordem === 'data_registro' ? 'selected' : '' ?>>Data</option>
                        <option value="tipo" <?= $filtro_ordem === 'tipo' ? 'selected' : '' ?>>Tipo</option>
                        <option value="total_acoes" <?= $filtro_ordem === 'total_acoes' ? 'selected' : '' ?>>Ações</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <iconify-icon icon="solar:magnifer-linear" class="me-1"></iconify-icon>
                        Aplicar Filtros
                    </button>
                    <a href="utilizadores.php" class="btn btn-outline-secondary">
                        <iconify-icon icon="solar:restart-linear" class="me-1"></iconify-icon>
                        Limpar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Todos os Utilizadores</h5>
            <div class="text-muted small">
                <?= number_format($total_utilizadores) ?> utilizador(es) encontrado(s)
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($utilizadores)): ?>
                <div class="text-center p-5">
                    <iconify-icon icon="solar:user-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                    <p class="text-muted mb-3">Nenhum utilizador encontrado com os filtros aplicados</p>
                    <a href="utilizadores_criar.php" class="btn btn-primary">
                        Adicionar Novo Utilizador
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Atividade</th>
                                <th>Data de Registro</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($utilizadores as $utilizador): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-<?= $utilizador['tipo'] === 'admin' ? 'danger' : 'primary' ?> bg-opacity-10 p-2 rounded me-3">
                                                <iconify-icon icon="solar:<?= $utilizador['tipo'] === 'admin' ? 'shield-user' : 'user' ?>-linear" width="20" height="20" class="text-<?= $utilizador['tipo'] === 'admin' ? 'danger' : 'primary' ?>"></iconify-icon>
                                            </div>
                                            <div><?= htmlspecialchars($utilizador['nome']) ?></div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($utilizador['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $utilizador['tipo'] === 'admin' ? 'danger' : 'primary' ?> bg-opacity-10 text-<?= $utilizador['tipo'] === 'admin' ? 'danger' : 'primary' ?>">
                                            <?= $utilizador['tipo'] === 'admin' ? 'Administrador' : 'Membro' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-info bg-opacity-10 text-info" data-bs-toggle="tooltip" title="Ações realizadas">
                                                <iconify-icon icon="solar:leaf-linear" class="me-1"></iconify-icon>
                                                <?= $utilizador['total_acoes'] ?>
                                            </span>
                                            <?php if ($utilizador['total_impacto'] > 0): ?>
                                                <span class="badge bg-warning bg-opacity-10 text-warning" data-bs-toggle="tooltip" title="Impacto total (kg CO₂)">
                                                    <iconify-icon icon="solar:chart-linear" class="me-1"></iconify-icon>
                                                    <?= number_format($utilizador['total_impacto'], 2) ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($utilizador['total_votos'] > 0): ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary" data-bs-toggle="tooltip" title="Votos dados">
                                                    <iconify-icon icon="solar:chat-round-like-linear" class="me-1"></iconify-icon>
                                                    <?= $utilizador['total_votos'] ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($utilizador['data_registro'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <a href="utilizadores_editar.php?id=<?= $utilizador['id'] ?>" class="text-decoration-none">
                                                <iconify-icon icon="solar:document-add-bold-duotone" width="24"></iconify-icon>
                                            </a>
                                            <?php if ($utilizador['id'] != $_SESSION['utilizador_id']): ?>
                                                <a class="text-decoration-none text-danger delete-btn" style="cursor: pointer;"
                                                        data-id="<?= $utilizador['id'] ?>" data-name="<?= htmlspecialchars($utilizador['nome']) ?>">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="24"></iconify-icon>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_paginas > 1): ?>
                <div class="card-footer bg-white">
                    <nav aria-label="Paginação">
                        <ul class="pagination justify-content-center mb-0">
                            <?php if ($pagina_atual > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina_atual - 1])) ?>" aria-label="Anterior">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&laquo;</span>
                                </li>
                            <?php endif; ?>
                            
                            <?php 
                            $start_page = max(1, $pagina_atual - 2);
                            $end_page = min($total_paginas, $pagina_atual + 2);
                            
                            if ($start_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => 1])) ?>">1</a>
                                </li>
                                <?php if ($start_page > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?= $i == $pagina_atual ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($end_page < $total_paginas): ?>
                                <?php if ($end_page < $total_paginas - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $total_paginas])) ?>"><?= $total_paginas ?></a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($pagina_atual < $total_paginas): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina_atual + 1])) ?>" aria-label="Próximo">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o utilizador <strong id="userNameToDelete"></strong>?</p>
                <p class="text-danger">Esta ação não pode ser desfeita!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Excluir</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    const userNameToDelete = document.getElementById('userNameToDelete');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            userNameToDelete.textContent = name;
            confirmDeleteBtn.href = `utilizadores_eliminar.php?id=${userId}`;
            
            confirmDeleteModal.show();
        });
    });

    confirmDeleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        fetch(this.href, {
            method: 'GET'
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                console.error('Erro ao excluir');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php require_once '../layouts/footer.php'; ?>