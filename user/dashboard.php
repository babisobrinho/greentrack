<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

$pageTitle = 'Dashboard - GreenTrack';
$relativePath = '../';
require_once '../layouts/header.php';

$stmt = $pdo->prepare("SELECT * FROM acoes_sustentaveis WHERE utilizador_id = ? ORDER BY data_registro DESC LIMIT 5");
$stmt->execute([$_SESSION['utilizador_id']]);
$acoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT SUM(impacto) as total FROM acoes_sustentaveis WHERE utilizador_id = ?");
$stmt->execute([$_SESSION['utilizador_id']]);
$pegada = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

$conteudos = $pdo->query("
    SELECT c.*, u.nome as autor 
    FROM conteudos c
    JOIN utilizadores u ON c.utilizador_id = u.id
    ORDER BY data_publicacao DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT 
    COUNT(*) as total_interacoes,
    SUM(CASE WHEN tipo = 'like' THEN 1 ELSE 0 END) as likes,
    SUM(CASE WHEN tipo = 'dislike' THEN 1 ELSE 0 END) as dislikes
    FROM votos 
    WHERE utilizador_id = ? 
    AND data_voto >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
$stmt->execute([$_SESSION['utilizador_id']]);
$interacoes = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT c.nome, c.icone, COUNT(a.id) as total 
                    FROM categorias c
                    LEFT JOIN acoes_sustentaveis a ON c.nome = a.categoria AND a.utilizador_id = ?
                    GROUP BY c.nome");
$stmt->execute([$_SESSION['utilizador_id']]);
$categoriasProgresso = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT DATE_FORMAT(data_registro, '%Y-%m') as mes, SUM(impacto) as total 
                    FROM acoes_sustentaveis 
                    WHERE utilizador_id = ? 
                    AND data_registro >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                    GROUP BY mes 
                    ORDER BY mes");
$stmt->execute([$_SESSION['utilizador_id']]);
$impactoMensal = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT categoria, COUNT(*) as total 
                    FROM acoes_sustentaveis 
                    WHERE utilizador_id = ?
                    GROUP BY categoria 
                    ORDER BY total DESC 
                    LIMIT 5");
$stmt->execute([$_SESSION['utilizador_id']]);
$topCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-sm-flex justify-content-between align-items-center">
                <h1 class="mb-3 mb-sm-0">Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
                <a href="acoes_criar.php" class="btn btn-primary">
                    Nova Ação
                </a>
            </div>
            <p class="text-muted mb-0">Resumo das minhas atividades sustentáveis</p>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Pegada Ecológica</h6>
                            <h2 class="mb-0"><?php echo number_format($pegada, 2); ?> <small class="text-muted">kg CO₂</small></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:leaf-bold" width="24" height="24" class="text-primary"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <?php $progresso = min(100, ($pegada / 100) * 100); ?>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $progresso; ?>%" aria-valuenow="<?php echo $progresso; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted"><?php echo $progresso; ?>% da meta mensal</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Total de Ações</h6>
                            <h2 class="mb-0"><?php echo count($acoes); ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:checklist-minimalistic-bold" width="24" height="24" class="text-success"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:arrow-up-linear" width="16" height="16" class="text-success me-1"></iconify-icon>
                            <small class="text-muted">12% em relação ao mês passado</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Categorias Ativas</h6>
                            <h2 class="mb-0"><?php echo count($categoriasProgresso); ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:tag-horizontal-bold" width="24" height="24" class="text-info"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><?php echo $topCategorias[0]['categoria'] ?? 'Nenhuma'; ?> é a mais frequente</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Interações</h6>
                            <h2 class="mb-0"><?php echo $interacoes['total_interacoes'] ?? 0; ?></h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:like-bold" width="24" height="24" class="text-warning"></iconify-icon>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span class="text-success">
                                <iconify-icon icon="solar:like-square-bold" class="me-1"></iconify-icon>
                                <?php echo $interacoes['likes'] ?? 0; ?>
                            </span>
                            <span class="text-danger">
                                <iconify-icon icon="solar:dislike-square-bold" class="me-1"></iconify-icon>
                                <?php echo $interacoes['dislikes'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <?php 
                            $total = $interacoes['total_interacoes'] ?? 1;
                            $percent_likes = $total > 0 ? ($interacoes['likes'] / $total) * 100 : 0;
                            ?>
                            <div class="progress-bar bg-success" style="width: <?php echo $percent_likes; ?>%"></div>
                            <div class="progress-bar bg-danger" style="width: <?php echo 100 - $percent_likes; ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">O Meu Impacto Mensal</h5>
                    <div class="badge bg-secondary">
                        Últimos 6 meses
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="impactoChart" height="150"></canvas>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">As Minhas Categorias Mais Ativas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (empty($acoes)): ?>
                            <div class="text-center p-4">
                                <iconify-icon icon="solar:leaf-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                                <p class="text-muted mb-3">Nenhuma ação registada</p>
                                <a href="acoes_criar.php" class="btn btn-sm btn-primary">Registar Ação</a>
                            </div>
                        <?php else: ?>
                            <div class="col-md-6">
                                <canvas id="categoriasChart" height="200"></canvas>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($topCategorias as $index => $categoria): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary me-2"><?php echo $index + 1; ?></span>
                                                <?php echo htmlspecialchars($categoria['categoria']); ?>
                                            </div>
                                            <span class="badge bg-primary rounded-pill"><?php echo $categoria['total']; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ações Recentes</h5>
                    <a href="historico.php" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($acoes)): ?>
                        <div class="text-center p-4">
                            <iconify-icon icon="solar:leaf-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                            <p class="text-muted mb-3">Nenhuma ação registada</p>
                            <a href="acoes_criar.php" class="btn btn-sm btn-primary">Registar Ação</a>
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($acoes as $acao): ?>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                            <iconify-icon icon="solar:leaf-bold" width="20" height="20" class="text-success"></iconify-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($acao['nome']); ?></h6>
                                            <small class="text-muted"><?php echo date('d/m', strtotime($acao['data_registro'])); ?></small>
                                        </div>
                                        <span class="badge bg-success rounded-pill"><?php echo $acao['impacto']; ?> kg</span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Conteúdos Recentes</h5>
                    <a href="conteudos.php" class="btn btn-sm btn-outline-primary">Ver todos</a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($conteudos)): ?>
                        <div class="text-center p-4">
                            <iconify-icon icon="solar:document-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                            <p class="text-muted mb-0">Nenhum conteúdo disponível</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($conteudos as $conteudo): ?>
                                <a href="conteudos_ver.php?id=<?php echo $conteudo['id']; ?>" class="list-group-item list-group-item-action">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($conteudo['titulo']); ?></h6>
                                    <small class="text-muted d-block mb-1">
                                        <iconify-icon icon="solar:user-linear" class="me-1"></iconify-icon>
                                        <?php echo htmlspecialchars($conteudo['autor']); ?>
                                    </small>
                                    <small class="text-muted">
                                        <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                        <?php echo date('d/m/Y', strtotime($conteudo['data_publicacao'])); ?>
                                    </small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const impactoCtx = document.getElementById('impactoChart').getContext('2d');
    const meses = <?php echo json_encode(array_column($impactoMensal, 'mes')); ?>;
    const impactos = <?php echo json_encode(array_column($impactoMensal, 'total')); ?>;
    
    new Chart(impactoCtx, {
        type: 'bar',
        data: {
            labels: meses.map(mes => mes.split('-')[1] + '/' + mes.split('-')[0].slice(2)),
            datasets: [{
                label: 'Impacto (kg CO₂)',
                data: impactos,
                backgroundColor: '#2c8a5a',
                borderColor: '#1e5a3a',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'kg CO₂ reduzidos'
                    }
                }
            }
        }
    });

    const categoriasCtx = document.getElementById('categoriasChart').getContext('2d');
    const categorias = <?php echo json_encode(array_column($topCategorias, 'categoria')); ?>;
    const totais = <?php echo json_encode(array_column($topCategorias, 'total')); ?>;
    
    new Chart(categoriasCtx, {
        type: 'doughnut',
        data: {
            labels: categorias,
            datasets: [{
                data: totais,
                backgroundColor: [
                    '#2c8a5a', '#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});
</script>

<?php require_once '../layouts/footer.php'; ?>