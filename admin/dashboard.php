<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireAdmin();

$pageTitle = 'Dashboard Administrativo - GreenTrack';
require_once '../layouts/header.php';

$stats = [
    'users' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM utilizadores")->fetchColumn(),
        'admins' => $pdo->query("SELECT COUNT(*) FROM utilizadores WHERE tipo = 'admin'")->fetchColumn(),
        'regular' => $pdo->query("SELECT COUNT(*) FROM utilizadores WHERE tipo = 'regular'")->fetchColumn(),
        'new_week' => $pdo->query("SELECT COUNT(*) FROM utilizadores WHERE data_registro >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn()
    ],
    'contents' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM conteudos")->fetchColumn(),
        'published_week' => $pdo->query("SELECT COUNT(*) FROM conteudos WHERE data_publicacao >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn()
    ],
    'actions' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM acoes_sustentaveis")->fetchColumn(),
        'week' => $pdo->query("SELECT COUNT(*) FROM acoes_sustentaveis WHERE data_registro >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn(),
        'impact' => $pdo->query("SELECT SUM(impacto) FROM acoes_sustentaveis")->fetchColumn() ?: 0
    ],
    'engagement' => [
        'likes' => $pdo->query("SELECT COUNT(*) FROM votos WHERE tipo = 'like'")->fetchColumn(),
        'dislikes' => $pdo->query("SELECT COUNT(*) FROM votos WHERE tipo = 'dislike'")->fetchColumn()
    ]
];

$userGrowth = $pdo->query("
    SELECT DATE_FORMAT(data_registro, '%Y-%m') as month, COUNT(*) as count 
    FROM utilizadores 
    WHERE data_registro >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month 
    ORDER BY month
")->fetchAll(PDO::FETCH_ASSOC);

$actionTrends = $pdo->query("
    SELECT DATE_FORMAT(data_registro, '%Y-%m') as month, COUNT(*) as actions, SUM(impacto) as impact
    FROM acoes_sustentaveis 
    WHERE data_registro >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month 
    ORDER BY month
")->fetchAll(PDO::FETCH_ASSOC);

$topCategories = $pdo->query("
    SELECT categoria, COUNT(*) as actions, SUM(impacto) as impact 
    FROM acoes_sustentaveis 
    GROUP BY categoria
    ORDER BY actions DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$activeUsers = $pdo->query("
    SELECT u.nome, COUNT(a.id) as actions, SUM(a.impacto) as impact
    FROM utilizadores u
    LEFT JOIN acoes_sustentaveis a ON u.id = a.utilizador_id
    WHERE u.tipo = 'regular'
    GROUP BY u.id
    ORDER BY actions DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$popularContent = $pdo->query("
    SELECT c.id, c.titulo, u.nome as autor,
        COUNT(CASE WHEN v.tipo = 'like' THEN 1 END) as likes,
        COUNT(CASE WHEN v.tipo = 'dislike' THEN 1 END) as dislikes
    FROM conteudos c
    JOIN utilizadores u ON c.utilizador_id = u.id
    LEFT JOIN votos v ON c.id = v.conteudo_id
    GROUP BY c.id
    ORDER BY (likes - dislikes) DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-sm-flex justify-content-between align-items-center">
                <h1 class="mb-3 mb-sm-0">Dashboard</h1>
            </div>
            <p class="text-muted mb-0">Visão geral da plataforma GreenTrack</p>
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
                            <div class="progress-bar bg-primary" style="width: <?= ($stats['users']['admins']/$stats['users']['total'])*100 ?>%"></div>
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
            <div class="card border-start-lg border-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Conteúdos Publicados</h6>
                            <h2 class="mb-0"><?= number_format($stats['contents']['total']) ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:documents-minimalistic-linear" width="24" height="24" class="text-info"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:arrow-up-linear" width="16" height="16" class="text-info me-1"></iconify-icon>
                            <small class="text-muted"><?= $stats['contents']['published_week'] ?> novos esta semana</small>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <?php 
                            $avg_content = $stats['contents']['total'] / max(1, $stats['users']['total']);
                            $content_progress = min(100, $avg_content * 20);
                            ?>
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $content_progress ?>%" 
                                aria-valuenow="<?= $content_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Média de <?= number_format($avg_content, 1) ?> por utilizador</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Ações Registadas</h6>
                            <h2 class="mb-0"><?= number_format($stats['actions']['total']) ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:leaf-bold" width="24" height="24" class="text-success"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:clock-circle-linear" width="16" height="16" class="text-success me-1"></iconify-icon>
                            <small class="text-muted"><?= $stats['actions']['week'] ?> esta semana</small>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <?php 
                            $avg_actions = $stats['actions']['total'] / max(1, $stats['users']['regular']);
                            $actions_progress = min(100, $avg_actions * 5);
                            ?>
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $actions_progress ?>%" 
                                aria-valuenow="<?= $actions_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Média de <?= number_format($avg_actions, 1) ?> por utilizador</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Impacto Total</h6>
                            <h2 class="mb-0"><?= number_format($stats['actions']['impact'], 2) ?> <small class="text-muted">kg CO₂</small></h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:planet-linear" width="24" height="24" class="text-warning"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:chart-linear" width="16" height="16" class="text-warning me-1"></iconify-icon>
                            <small class="text-muted">Equivale a <?= number_format($stats['actions']['impact']/1000, 1) ?> toneladas</small>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <?php 
                            $impact_per_user = $stats['actions']['impact'] / max(1, $stats['users']['regular']);
                            $impact_progress = min(100, $impact_per_user);
                            ?>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $impact_progress ?>%" 
                                aria-valuenow="<?= $impact_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted"><?= number_format($impact_per_user, 2) ?> kg por utilizador</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Crescimento de Utilizadores</h5>
                    <div class="dropdown">
                        <div class="badge bg-secondary">
                            Últimos 6 meses
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="usersChart" height="150"></canvas>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tendência de Ações Sustentáveis</h5>
                    <div class="dropdown">
                        <div class="badge bg-secondary">
                            Últimos 6 meses
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="actionsChart" height="150"></canvas>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Categorias Mais Populares</h5>
                    <div class="dropdown">
                        <div class="badge bg-secondary">
                            Últimos 6 meses
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="categoriesChart" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($topCategories as $index => $category): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary me-2"><?= $index + 1 ?></span>
                                            <?= htmlspecialchars($category['categoria']) ?>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary rounded-pill"><?= $category['actions'] ?></span>
                                            <small class="d-block text-muted"><?= number_format($category['impact'], 2) ?> kg</small>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Utilizadores Mais Ativos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($activeUsers as $user): ?>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                        <iconify-icon icon="solar:user-linear" width="20" height="20" class="text-info"></iconify-icon>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?= htmlspecialchars($user['nome']) ?></h6>
                                        <small class="text-muted"><?= $user['actions'] ?> ações</small>
                                    </div>
                                    <span class="badge bg-info rounded-pill"><?= isset($user['impact']) ? number_format($user['impact'], 2) : '0.00' ?> kg</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="utilizadores.php" class="text-muted text-decoration-none">
                        Ver todos os utilizadores →
                    </a>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Artigos Mais Populares</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($popularContent as $content): ?>
                            <a href="conteudos_ver.php?id=<?= $content['id'] ?>" class="list-group-item list-group-item-action">
                                <h6 class="mb-1"><?= htmlspecialchars($content['titulo']) ?></h6>
                                <small class="text-muted d-block mb-1">
                                    <iconify-icon icon="solar:user-linear" class="me-1"></iconify-icon>
                                    <?= htmlspecialchars($content['autor']) ?>
                                </small>
                                <div class="d-flex justify-content-start small">
                                    <span class="text-success me-3">
                                        <iconify-icon icon="solar:like-bold" class="me-1"></iconify-icon>
                                        <?= $content['likes'] ?>
                                    </span>
                                    <span class="text-danger">
                                        <iconify-icon icon="solar:dislike-bold" class="me-1"></iconify-icon>
                                        <?= $content['dislikes'] ?>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="conteudos.php" class="text-muted text-decoration-none">
                        Ver todos os artigos →
                    </a>
                </div>
            </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const userMonths = <?= json_encode(array_column($userGrowth, 'month')) ?>;
    const userCounts = <?= json_encode(array_column($userGrowth, 'count')) ?>;
    
    new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: userMonths.map(month => month.split('-')[1] + '/' + month.split('-')[0].slice(2)),
            datasets: [{
                label: 'Novos Usuários',
                data: userCounts,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: '#4e73df',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Usuários'
                    }
                }
            }
        }
    });

    const actionsCtx = document.getElementById('actionsChart').getContext('2d');
    const actionMonths = <?= json_encode(array_column($actionTrends, 'month')) ?>;
    const actionCounts = <?= json_encode(array_column($actionTrends, 'actions')) ?>;
    const impactValues = <?= json_encode(array_column($actionTrends, 'impact')) ?>;
    
    new Chart(actionsCtx, {
        type: 'bar',
        data: {
            labels: actionMonths.map(month => month.split('-')[1] + '/' + month.split('-')[0].slice(2)),
            datasets: [
                {
                    label: 'Ações Registradas',
                    data: actionCounts,
                    backgroundColor: '#1cc88a',
                    borderColor: '#17a673',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Impacto (kg CO₂)',
                    data: impactValues,
                    backgroundColor: 'rgba(54, 185, 204, 0.5)',
                    borderColor: '#36b9cc',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw.toLocaleString();
                            if (context.dataset.label === 'Impacto (kg CO₂)') {
                                label += ' kg';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Número de Ações'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Impacto (kg CO₂)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const categoryLabels = <?= json_encode(array_column($topCategories, 'categoria')) ?>;
    const categoryActions = <?= json_encode(array_column($topCategories, 'actions')) ?>;
    
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryActions,
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>

<?php require_once '../layouts/footer.php'; ?>