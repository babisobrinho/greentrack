<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

$pageTitle = 'Gestão de Conteúdos - GreenTrack';
require_once '../layouts/header.php';

$filtro_titulo = $_GET['titulo'] ?? '';
$filtro_data_inicio = $_GET['data_inicio'] ?? '';
$filtro_data_fim = $_GET['data_fim'] ?? '';
$filtro_autor = $_GET['autor'] ?? '';
$filtro_ordem = $_GET['ordem'] ?? 'c.data_publicacao';

$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$itens_por_pagina = 10;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

$queryBase = "FROM conteudos c JOIN utilizadores u ON c.utilizador_id = u.id WHERE 1=1";
$params = [];
$param_types = [];

if (!empty($filtro_titulo)) {
    $queryBase .= " AND c.titulo LIKE ?";
    $params[] = '%' . $filtro_titulo . '%';
    $param_types[] = 's';
}

if (!empty($filtro_data_inicio)) {
    $queryBase .= " AND c.data_publicacao >= ?";
    $params[] = $filtro_data_inicio;
    $param_types[] = 's';
}

if (!empty($filtro_data_fim)) {
    $queryBase .= " AND c.data_publicacao <= ?";
    $params[] = $filtro_data_fim;
    $param_types[] = 's';
}

if (!empty($filtro_autor)) {
    $queryBase .= " AND u.nome LIKE ?";
    $params[] = '%' . $filtro_autor . '%';
    $param_types[] = 's';
}

$ordenacoes_validas = ['c.titulo', 'c.data_publicacao', 'u.nome', 'total_votos', 'likes'];
$filtro_ordem = in_array($filtro_ordem, $ordenacoes_validas) ? $filtro_ordem : 'c.data_publicacao';
$direcao = isset($_GET['dir']) && strtolower($_GET['dir']) === 'asc' ? 'ASC' : 'DESC';

$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN c.data_publicacao >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_week,
    SUM(CASE WHEN c.utilizador_id = ? THEN 1 ELSE 0 END) as meus_conteudos
    FROM conteudos c WHERE 1=1";

if (!empty($filtro_titulo)) {
    $stats_query .= " AND c.titulo LIKE ?";
}
if (!empty($filtro_data_inicio)) {
    $stats_query .= " AND c.data_publicacao >= ?";
}
if (!empty($filtro_data_fim)) {
    $stats_query .= " AND c.data_publicacao <= ?";
}
if (!empty($filtro_autor)) {
    $stats_query .= " AND c.utilizador_id IN (SELECT id FROM utilizadores WHERE nome LIKE ?)";
}

$stmt = $pdo->prepare($stats_query);
$param_index = 1;
$stmt->bindValue($param_index++, $_SESSION['utilizador_id'], PDO::PARAM_INT);

if (!empty($filtro_titulo)) {
    $stmt->bindValue($param_index++, '%' . $filtro_titulo . '%', PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_autor)) {
    $stmt->bindValue($param_index++, '%' . $filtro_autor . '%', PDO::PARAM_STR);
}

$stmt->execute();
$content_stats = $stmt->fetch(PDO::FETCH_ASSOC);

$stats = [
    'contents' => [
        'total' => $content_stats['total'] ?? 0,
        'new_week' => $content_stats['new_week'] ?? 0,
        'my_contents' => $content_stats['meus_conteudos'] ?? 0
    ],
    'engagement' => [
        'likes' => 0,
        'dislikes' => 0,
        'avg_per_content' => 0
    ],
    'topics' => [
        'most_active' => [],
        'most_liked' => []
    ]
];

$engagement_query = "SELECT 
    SUM(CASE WHEN v.tipo = 'like' THEN 1 ELSE 0 END) as likes,
    SUM(CASE WHEN v.tipo = 'dislike' THEN 1 ELSE 0 END) as dislikes,
    COUNT(v.id) / COUNT(DISTINCT c.id) as avg_per_content
    FROM conteudos c
    LEFT JOIN votos v ON c.id = v.conteudo_id
    WHERE 1=1";

if (!empty($filtro_titulo)) {
    $engagement_query .= " AND c.titulo LIKE ?";
}
if (!empty($filtro_data_inicio)) {
    $engagement_query .= " AND c.data_publicacao >= ?";
}
if (!empty($filtro_data_fim)) {
    $engagement_query .= " AND c.data_publicacao <= ?";
}
if (!empty($filtro_autor)) {
    $engagement_query .= " AND c.utilizador_id IN (SELECT id FROM utilizadores WHERE nome LIKE ?)";
}

$stmt = $pdo->prepare($engagement_query);
$param_index = 1;

if (!empty($filtro_titulo)) {
    $stmt->bindValue($param_index++, '%' . $filtro_titulo . '%', PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_autor)) {
    $stmt->bindValue($param_index++, '%' . $filtro_autor . '%', PDO::PARAM_STR);
}

$stmt->execute();
$engagement_stats = $stmt->fetch(PDO::FETCH_ASSOC);

if ($engagement_stats) {
    $stats['engagement']['likes'] = $engagement_stats['likes'] ?? 0;
    $stats['engagement']['dislikes'] = $engagement_stats['dislikes'] ?? 0;
    $stats['engagement']['avg_per_content'] = $engagement_stats['avg_per_content'] ?? 0;
}

$topics_query = "SELECT 
    c.titulo, 
    COUNT(v.id) as total_votos,
    SUM(CASE WHEN v.tipo = 'like' THEN 1 ELSE 0 END) as likes
    FROM conteudos c
    LEFT JOIN votos v ON c.id = v.conteudo_id
    JOIN utilizadores u ON c.utilizador_id = u.id
    WHERE 1=1";

if (!empty($filtro_titulo)) {
    $topics_query .= " AND c.titulo LIKE ?";
}
if (!empty($filtro_data_inicio)) {
    $topics_query .= " AND c.data_publicacao >= ?";
}
if (!empty($filtro_data_fim)) {
    $topics_query .= " AND c.data_publicacao <= ?";
}
if (!empty($filtro_autor)) {
    $topics_query .= " AND u.nome LIKE ?";
}

$topics_query .= " GROUP BY c.id ORDER BY total_votos DESC LIMIT 2";

$stmt = $pdo->prepare($topics_query);
$param_index = 1;

if (!empty($filtro_titulo)) {
    $stmt->bindValue($param_index++, '%' . $filtro_titulo . '%', PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_autor)) {
    $stmt->bindValue($param_index++, '%' . $filtro_autor . '%', PDO::PARAM_STR);
}

$stmt->execute();
$stats['topics']['most_active'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

$liked_query = "SELECT 
    c.titulo, 
    SUM(CASE WHEN v.tipo = 'like' THEN 1 ELSE 0 END) as likes
    FROM conteudos c
    LEFT JOIN votos v ON c.id = v.conteudo_id
    JOIN utilizadores u ON c.utilizador_id = u.id
    WHERE 1=1";

if (!empty($filtro_titulo)) {
    $liked_query .= " AND c.titulo LIKE ?";
}
if (!empty($filtro_data_inicio)) {
    $liked_query .= " AND c.data_publicacao >= ?";
}
if (!empty($filtro_data_fim)) {
    $liked_query .= " AND c.data_publicacao <= ?";
}
if (!empty($filtro_autor)) {
    $liked_query .= " AND u.nome LIKE ?";
}

$liked_query .= " GROUP BY c.id ORDER BY likes DESC LIMIT 2";

$stmt = $pdo->prepare($liked_query);
$param_index = 1;

if (!empty($filtro_titulo)) {
    $stmt->bindValue($param_index++, '%' . $filtro_titulo . '%', PDO::PARAM_STR);
}
if (!empty($filtro_data_inicio)) {
    $stmt->bindValue($param_index++, $filtro_data_inicio, PDO::PARAM_STR);
}
if (!empty($filtro_data_fim)) {
    $stmt->bindValue($param_index++, $filtro_data_fim, PDO::PARAM_STR);
}
if (!empty($filtro_autor)) {
    $stmt->bindValue($param_index++, '%' . $filtro_autor . '%', PDO::PARAM_STR);
}

$stmt->execute();
$stats['topics']['most_liked'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT 
    c.*, 
    u.nome as autor_nome,
    COUNT(v.id) as total_votos,
    SUM(CASE WHEN v.tipo = 'like' THEN 1 ELSE 0 END) as likes,
    SUM(CASE WHEN v.tipo = 'dislike' THEN 1 ELSE 0 END) as dislikes
    FROM conteudos c
    JOIN utilizadores u ON c.utilizador_id = u.id
    LEFT JOIN votos v ON c.id = v.conteudo_id
    WHERE 1=1";

$query .= substr($queryBase, strpos($queryBase, "WHERE 1=1") + 9);

$query .= " GROUP BY c.id 
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
$conteudos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_query = "SELECT COUNT(*) as total " . $queryBase;
$stmt = $pdo->prepare($total_query);
$stmt->execute($params);
$total_conteudos = $stmt->fetchColumn();
$total_paginas = ceil($total_conteudos / $itens_por_pagina);
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">Gestão de Conteúdos</h1>
                    <p class="text-muted mb-0">Faça a gestão dos conteúdos da plataforma</p>
                </div>
                <a href="conteudos_criar.php" class="btn btn-primary">
                    Novo Conteúdo
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
                            <h6 class="text-uppercase text-muted mb-2">Total de Artigos Publicados</h6>
                            <h2 class="mb-0"><?= number_format($stats['contents']['total']) ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:documents-bold" width="24" height="24" class="text-primary"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span>
                                <iconify-icon icon="solar:user-linear" class="me-1 text-primary"></iconify-icon>
                                <?= $stats['contents']['my_contents'] ?> meus
                            </span>
                            <span>
                                <iconify-icon icon="solar:calendar-linear" class="me-1 text-muted"></iconify-icon>
                                <?= $stats['contents']['new_week'] ?> novos
                            </span>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: <?= $stats['contents']['total'] > 0 ? ($stats['contents']['my_contents']/$stats['contents']['total'])*100 : 0 ?>%"></div>
                        </div>
                        <small class="text-muted">
                            <?= $stats['contents']['new_week'] ?> publicados esta semana
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
                            <h6 class="text-uppercase text-muted mb-2">Total de Interações dos Utilizadores</h6>
                            <h2 class="mb-0"><?= number_format($stats['engagement']['likes'] + $stats['engagement']['dislikes']) ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:chat-round-like-linear" width="24" height="24" class="text-success"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span>
                                <iconify-icon icon="solar:like-bold" class="me-1 text-success"></iconify-icon>
                                <?= number_format($stats['engagement']['likes']) ?> likes
                            </span>
                            <span>
                                <iconify-icon icon="solar:dislike-bold" class="me-1 text-danger"></iconify-icon>
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
                            Média de <?= number_format($stats['engagement']['avg_per_content'], 1) ?> por conteúdo
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-3">Artigos Mais Ativos</h6>
                    <div class="d-flex flex-column gap-3">
                        <?php if($stats['topics']['most_active']): ?>
                            <?php foreach ($stats['topics']['most_active'] as $index => $topic): ?>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning bg-opacity-10 text-warning me-3"><?= $index + 1 ?></span>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?= htmlspecialchars($topic['titulo']) ?></h6>
                                        <small class="text-muted"><?= $topic['total_votos'] ?> interações</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <iconify-icon icon="solar:chat-round-like-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                                <p class="text-muted mb-3">Nenhum conteúdo encontrado com os filtros aplicados</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-3">Artigos Com Mais Likes</h6>
                    <div class="d-flex flex-column gap-3">
                        <?php if($stats['topics']['most_liked']): ?>
                            <?php foreach ($stats['topics']['most_liked'] as $index => $topic): ?>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success bg-opacity-10 text-success me-3"><?= $index + 1 ?></span>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?= htmlspecialchars($topic['titulo']) ?></h6>
                                        <small class="text-muted"><?= $topic['likes'] ?> likes</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <iconify-icon icon="solar:like-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                                <p class="text-muted mb-3">Nenhum conteúdo encontrado com os filtros aplicados</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Filtrar Conteúdos</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Pesquisar por título" value="<?= htmlspecialchars($filtro_titulo) ?>">
                </div>
                <div class="col-md-4">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" id="autor" name="autor" class="form-control" placeholder="Pesquisar por autor" value="<?= htmlspecialchars($filtro_autor) ?>">
                </div>
                <div class="col-md-4">
                    <label for="data_inicio" class="form-label">Data de Publicação (Início)</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= htmlspecialchars($filtro_data_inicio) ?>">
                </div>
                <div class="col-md-4">
                    <label for="data_fim" class="form-label">Data de Publicação (Fim)</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= htmlspecialchars($filtro_data_fim) ?>">
                </div>
                <div class="col-md-4">
                    <label for="ordem" class="form-label">Ordenar por</label>
                    <select id="ordem" name="ordem" class="form-select">
                        <option value="c.data_publicacao" <?= $filtro_ordem === 'c.data_publicacao' ? 'selected' : '' ?>>Data de Publicação</option>
                        <option value="c.titulo" <?= $filtro_ordem === 'c.titulo' ? 'selected' : '' ?>>Título</option>
                        <option value="u.nome" <?= $filtro_ordem === 'u.nome' ? 'selected' : '' ?>>Autor</option>
                        <option value="total_votos" <?= $filtro_ordem === 'total_votos' ? 'selected' : '' ?>>Interações</option>
                        <option value="likes" <?= $filtro_ordem === 'likes' ? 'selected' : '' ?>>Likes</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dir" class="form-label">Direção</label>
                    <select id="dir" name="dir" class="form-select">
                        <option value="desc" <?= $direcao === 'DESC' ? 'selected' : '' ?>>Decrescente</option>
                        <option value="asc" <?= $direcao === 'ASC' ? 'selected' : '' ?>>Crescente</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <iconify-icon icon="solar:magnifer-linear" class="me-1"></iconify-icon>
                        Aplicar Filtros
                    </button>
                    <a href="conteudos.php" class="btn btn-outline-secondary">
                        <iconify-icon icon="solar:restart-linear" class="me-1"></iconify-icon>
                        Limpar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Todos os Conteúdos</h5>
            <div class="text-muted small">
                <?= number_format($total_conteudos) ?> artigo(s) encontrado(s)
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($conteudos)): ?>
                <div class="text-center p-5">
                    <iconify-icon icon="solar:document-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                    <p class="text-muted mb-3">Nenhum conteúdo encontrado com os filtros aplicados</p>
                    <a href="conteudos_criar.php" class="btn btn-primary">
                        Criar Novo Artigo
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Interações</th>
                                <th>Data de Publicação</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($conteudos as $conteudo): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                                <iconify-icon icon="solar:document-linear" width="20" height="20" class="text-primary"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($conteudo['titulo']) ?></h6>
                                                <small class="text-muted"><?= substr(strip_tags($conteudo['conteudo']), 0, 50) ?>...</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div><?= htmlspecialchars($conteudo['autor_nome']) ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-success bg-opacity-10 text-success" data-bs-toggle="tooltip" title="Likes">
                                                <iconify-icon icon="solar:like-bold" class="me-1"></iconify-icon>
                                                <?= $conteudo['likes'] ?>
                                            </span>
                                            <span class="badge bg-danger bg-opacity-10 text-danger" data-bs-toggle="tooltip" title="Dislikes">
                                                <iconify-icon icon="solar:dislike-bold" class="me-1"></iconify-icon>
                                                <?= $conteudo['dislikes'] ?>
                                            </span>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary" data-bs-toggle="tooltip" title="Total de interações">
                                                <iconify-icon icon="solar:chat-round-like-linear" class="me-1"></iconify-icon>
                                                <?= $conteudo['total_votos'] ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($conteudo['data_publicacao'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <a href="conteudos_ver.php?id=<?= $conteudo['id'] ?>" class="text-decoration-none" data-bs-toggle="tooltip" title="Visualizar">
                                                <iconify-icon icon="solar:eye-bold-duotone" width="24"></iconify-icon>
                                            </a>
                                            <?php if ($conteudo['utilizador_id'] == $_SESSION['utilizador_id'] || $_SESSION['tipo'] === 'admin'): ?>
                                                <a href="conteudos_editar.php?id=<?= $conteudo['id'] ?>" class="text-decoration-none" data-bs-toggle="tooltip" title="Editar">
                                                    <iconify-icon icon="solar:document-add-bold-duotone" width="24"></iconify-icon>
                                                </a>
                                                <?php if ($conteudo['utilizador_id'] == $_SESSION['utilizador_id']): ?>
                                                    <a class="text-decoration-none text-danger delete-btn" style="cursor: pointer;"
                                                            data-id="<?= $conteudo['id'] ?>" data-name="<?= htmlspecialchars($conteudo['titulo']) ?>">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="24"></iconify-icon>
                                                    </a>
                                                <?php endif; ?>
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
                <p>Tem certeza que deseja excluir o conteúdo <strong id="contentNameToDelete"></strong>?</p>
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
    const contentNameToDelete = document.getElementById('contentNameToDelete');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const contentId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            contentNameToDelete.textContent = name;
            confirmDeleteBtn.href = `conteudos_eliminar.php?id=${contentId}`;
            
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