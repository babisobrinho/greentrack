<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$pageTitle = 'Sobre - GreenTrack';
$relativePath = '';
require_once 'layouts/header.php';
?>

<section class="text-white py-5" style="background-image: url('assets/img/hero.jpg'); position: relative; background-size: cover; background-position: center;">
    <!-- Dark overlay div -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.8);"></div>
    <div class="container py-5 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-2 fw-bold mb-4">Sobre o <span class="text-success">GreenTrack</span></h1>
                <p class="lead fs-4">Conheça nossa missão e os valores que nos guiam</p>
            </div>
        </div>
    </div>
</section>
<section class="about-section py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 mb-4 mb-lg-0 fade-in-element">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-4 py-2 rounded-pill">NOSSA MISSÃO</span>
                <h2 class="display-5 fw-bold mb-4">Promover hábitos sustentáveis através da tecnologia</h2>
                <p class="lead mb-4">O GreenTrack é uma aplicação web inovadora que permite aos utilizadores registar e monitorizar os seus hábitos de consumo, incentivando práticas mais sustentáveis.</p>
                <p class="mb-4">Este projeto está alinhado com os Objetivos de Desenvolvimento Sustentável (ODS) da ONU, especialmente com o objetivo de "Consumo e Produção Sustentáveis".</p>
                
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <iconify-icon icon="solar:planet-bold" width="24" height="24"></iconify-icon>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Sustentabilidade</h5>
                            <p class="text-muted mb-0">Promovemos práticas sustentáveis em todas as áreas</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <iconify-icon icon="solar:graph-bold" width="24" height="24"></iconify-icon>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Monitorização</h5>
                            <p class="text-muted mb-0">Acompanhamento detalhado do seu impacto ambiental</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <iconify-icon icon="solar:users-group-rounded-bold" width="24" height="24"></iconify-icon>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Comunidade</h5>
                            <p class="text-muted mb-0">Construímos uma comunidade engajada e consciente</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-in-element">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <img src="assets/img/sustainability.jpg" alt="Sustentabilidade" class="img-fluid" style="height: 400px; object-fit: cover;">
                    <div class="card-body bg-light p-4">
                        <h4 class="fw-bold mb-3">Impacto Ambiental</h4>
                        <p class="mb-0">Cada pequena ação conta. Com o GreenTrack, você pode ver o impacto real das suas escolhas diárias no meio ambiente e como pequenas mudanças podem fazer uma grande diferença.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="developer-section py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-4 py-2 rounded-pill">EQUIPA</span>
                <h2 class="display-5 fw-bold mb-4">Sobre a Desenvolvedora</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden fade-in-element">
                    <div class="row g-0">
                        <div class="col-md-4 bg-success d-flex align-items-center justify-content-center p-4">
                            <img src="assets/img/developer.jpg" alt="Ana Oliveira" class="img-fluid rounded-circle shadow" style="width: 200px; height: 200px; object-fit: cover; border: 5px solid rgba(255,255,255,0.2);">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4 p-md-5">
                                <h3 class="card-title fw-bold mb-3">Ana Oliveira</h3>
                                <p class="card-text mb-3">Formanda no curso de Técnico Especialista em Tecnologias e Programação de Sistemas de Informação.</p>
                                <p class="card-text mb-4">Este projeto foi desenvolvido no âmbito da UFCD 5417 - Programação para a WEB - servidor (server-side), no IEFP de Leiria.</p>
                            </div>
                        </div>
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
                <h2 class="display-5 fw-bold mb-4 animate__animated animate__fadeInDown">Pronto para começar a sua jornada sustentável?</h2>
                <p class="lead mb-5 animate__animated animate__fadeIn animate__delay-1s">Junte-se a nós e faça parte da mudança que o planeta precisa.</p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="registo.php" class="btn btn-light btn-lg px-4 py-3 rounded-pill shadow-sm">
                        Registar-se
                    </a>
                    <a href="login.php" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                        Iniciar Sessão
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'layouts/footer.php'; ?>