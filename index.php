<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';
redirectIfLoggedIn();

$pageTitle = 'GreenTrack - Monitorização de Hábitos Sustentáveis';
$relativePath = '';
require_once 'layouts/header.php';
?>

<section class="text-white py-5" style="background-image: url('assets/img/hero.jpg'); position: relative; background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.8);"></div>
    <div class="py-5 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-2 fw-bold mb-4">Reduza a sua <span class="text-success">pegada ecológica</span></h1>
                <p class="mb-5 fs-4">Contribua para um planeta mais verde com ferramentas intuitivas.</p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="registo.php" class="btn btn-light btn px-4 py-3 rounded-pill shadow-sm">
                        Comece Agora
                    </a>
                    <a href="#beneficios" class="btn btn-outline-light btn px-4 py-3 rounded-pill">
                        Saiba Mais
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="beneficios" class="benefits-section py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-4 py-2 rounded-pill">PORQUÊ ESCOLHER-NOS</span>
                <h2 class="display-5 fw-bold mb-4">Benefícios do GreenTrack</h2>
                <p class="lead text-muted">Descubra como podemos ajudá-lo a alcançar os seus objetivos sustentáveis</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm fade-in-element hover-scale">
                    <div class="card-body text-center p-5">
                        <div class="icon-wrapper bg-success bg-opacity-10 text-primary rounded-circle p-4 mb-4 mx-auto">
                            <iconify-icon icon="solar:chart-bold" width="40" height="40"></iconify-icon>
                        </div>
                        <h3 class="h4 mb-3">Monitorização</h3>
                        <p class="mb-0 text-muted">Acompanhe o seu progresso em tempo real com gráficos intuitivos e estatísticas detalhadas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm fade-in-element hover-scale">
                    <div class="card-body text-center p-5">
                        <div class="icon-wrapper bg-success bg-opacity-10 text-primary rounded-circle p-4 mb-4 mx-auto">
                            <iconify-icon icon="solar:leaf-bold" width="40" height="40"></iconify-icon>
                        </div>
                        <h3 class="h4 mb-3">Sustentabilidade</h3>
                        <p class="mb-0 text-muted">Reduza o seu impacto ambiental com dicas personalizadas e acompanhamento de progresso.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm fade-in-element hover-scale">
                    <div class="card-body text-center p-5">
                        <div class="icon-wrapper bg-success bg-opacity-10 text-primary rounded-circle p-4 mb-4 mx-auto">
                            <iconify-icon icon="solar:cup-star-bold" width="40" height="40"></iconify-icon>
                        </div>
                        <h3 class="h4 mb-3">Desafios</h3>
                        <p class="mb-0 text-muted">Participe em desafios comunitários e ganhe reconhecimento pelas suas ações sustentáveis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden fade-in-element">
                    <img src="assets/img/sustainability.jpg" class="card-img-top" alt="Sustentabilidade" style="height: 500px; object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-4 py-2 rounded-pill">COMO FUNCIONA</span>
                <h2 class="display-5 fw-bold mb-4">Simples, Intuitivo e Eficaz</h2>
                <p class="lead text-muted mb-5">Comece sua jornada sustentável em apenas alguns passos</p>
                
                <div class="d-flex mb-4 fade-in-element">
                    <div class="flex-shrink-0">
                        <div class="bg-success text-white rounded-3 p-3 me-4">
                            <iconify-icon icon="solar:user-check-rounded-bold" width="24" height="24"></iconify-icon>
                        </div>
                    </div>
                    <div>
                        <h3 class="h5 mb-2">Registe-se e crie o seu perfil</h3>
                        <p class="text-muted mb-0">Crie uma conta gratuita e personalize o seu perfil com os seus objetivos sustentáveis.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4 fade-in-element">
                    <div class="flex-shrink-0">
                        <div class="bg-success text-white rounded-3 p-3 me-4">
                            <iconify-icon icon="solar:clipboard-list-bold" width="24" height="24"></iconify-icon>
                        </div>
                    </div>
                    <div>
                        <h3 class="h5 mb-2">Registe as suas ações sustentáveis</h3>
                        <p class="text-muted mb-0">Adicione as suas ações diárias e veja o impacto positivo que está a causar no ambiente.</p>
                    </div>
                </div>
                
                <div class="d-flex fade-in-element">
                    <div class="flex-shrink-0">
                        <div class="bg-success text-white rounded-3 p-3 me-4">
                            <iconify-icon icon="solar:graph-bold" width="24" height="24"></iconify-icon>
                        </div>
                    </div>
                    <div>
                        <h3 class="h5 mb-2">Acompanhe o seu progresso</h3>
                        <p class="text-muted mb-0">Visualize estatísticas detalhadas e veja como as suas ações estão contribuindo para um planeta mais verde.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section py-5 text-white" style="background: linear-gradient(135deg, #2c8a5a 0%, #1e5a3a 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-4">Pronto para começar a sua jornada sustentável?</h2>
                <p class="lead mb-5">Junte-se a milhares de pessoas que estão a fazer a diferença todos os dias.</p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="registo.php" class="btn btn-light btn-lg px-4 py-3 rounded-pill shadow-sm">
                        Registar-se
                    </a>
                    <a href="sobre.php" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                        Saber Mais
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?>

<style>
.hover-scale {
    transition: transform 0.3s ease;
}
.hover-scale:hover {
    transform: translateY(-5px);
}

.icon-wrapper {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fade-in-element {
    opacity: 0;
    animation: fadeIn 1s ease-in forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
    }
}
</style>

