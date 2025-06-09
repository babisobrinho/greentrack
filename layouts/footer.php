    </main>

    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="footer-brand d-flex align-items-center mb-3">
                        <img src="<?php echo $relativePath; ?>assets/img/logo.png" alt="GreenTrack Logo" width="40" class="me-2">
                        <h5 class="m-0">GreenTrack</h5>
                    </div>
                    <p class="text-white">Plataforma de monitorização de hábitos sustentáveis para um futuro mais verde.</p>
                    <div class="mt-3">
                        <p class="mb-1 d-flex align-items-center">
                            <iconify-icon icon="solar:letter-linear" class="me-2" width="20" height="20"></iconify-icon>
                            <span>info@greentrack.pt</span>
                        </p>
                        <p class="mb-1 d-flex align-items-center">
                            <iconify-icon icon="solar:phone-linear" class="me-2" width="20" height="20"></iconify-icon>
                            <span>+351 123 456 789</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?php echo $relativePath; ?>index.php" class="d-flex align-items-center">
                                <iconify-icon icon="solar:arrow-right-linear" class="me-2" width="16" height="16"></iconify-icon>
                                <span>Início</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo $relativePath; ?>sobre.php" class="d-flex align-items-center">
                                <iconify-icon icon="solar:arrow-right-linear" class="me-2" width="16" height="16"></iconify-icon>
                                <span>Sobre</span>
                            </a>
                        </li>
                        <?php if(isset($_SESSION['utilizador_id'])): ?>
                            <li class="mb-2">
                                <a href="<?php echo $_SESSION['tipo'] == 'admin' ? $relativePath.'admin/dashboard.php' : $relativePath.'user/dashboard.php'; ?>" class="d-flex align-items-center">
                                    <iconify-icon icon="solar:arrow-right-linear" class="me-2" width="16" height="16"></iconify-icon>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="mb-2">
                                <a href="<?php echo $relativePath; ?>registo.php" class="d-flex align-items-center">
                                    <iconify-icon icon="solar:arrow-right-linear" class="me-2" width="16" height="16"></iconify-icon>
                                    <span>Registo</span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?php echo $relativePath; ?>login.php" class="d-flex align-items-center">
                                    <iconify-icon icon="solar:arrow-right-linear" class="me-2" width="16" height="16"></iconify-icon>
                                    <span>Login</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Siga-nos</h5>
                    <p class="text-white mb-3">Acompanhe nossas novidades e dicas sustentáveis nas redes sociais.</p>
                    <div class="social-icons d-flex">
                        <a href="#" class="me-3" aria-label="Facebook">Facebook</a>
                        <a href="#" class="me-3" aria-label="Twitter">Twitter</a>
                        <a href="#" class="me-3" aria-label="Instagram">Instagram</a>
                        <a href="#" aria-label="LinkedIn">LinkedIn</a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> GreenTrack. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Feito com <iconify-icon icon="solar:heart-linear" class="mx-1" width="16" height="16"></iconify-icon> por Ana Oliveira</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $relativePath; ?>assets/js/script.js"></script>
</body>
</html>

