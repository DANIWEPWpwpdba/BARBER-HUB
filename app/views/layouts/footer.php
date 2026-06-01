<!-- Footer -->
<footer class="py-5" style="background-color: #050505; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <a href="/" class="d-inline-block mb-3 text-decoration-none">
                    <h3 style="color: #e2c044; font-weight: 800; font-family: 'Outfit', sans-serif;">BARBER HUB <i class="fas fa-crown ms-1 fs-5"></i></h3>
                </a>
                <p class="text-muted pe-lg-4" style="line-height: 1.8;">La plataforma definitiva para gestionar tu barbería, automatizar citas y hacer crecer tu negocio al máximo nivel en toda Latinoamérica.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="btn btn-outline-secondary rounded-circle" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h5 class="text-light mb-4 font-weight-bold" style="font-family: 'Outfit', sans-serif;">Plataforma</h5>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="#beneficios" class="text-muted text-decoration-none hover-white transition-all">Características</a></li>
                    <li><a href="#planes" class="text-muted text-decoration-none hover-white transition-all">Precios y Planes</a></li>
                    <li><a href="#directorio" class="text-muted text-decoration-none hover-white transition-all">Directorio</a></li>
                    <li><a href="#" class="text-muted text-decoration-none hover-white transition-all">Novedades</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <h5 class="text-light mb-4 font-weight-bold" style="font-family: 'Outfit', sans-serif;">Legal</h5>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="#" class="text-muted text-decoration-none hover-white transition-all">Términos y Condiciones</a></li>
                    <li><a href="#" class="text-muted text-decoration-none hover-white transition-all">Aviso de Privacidad</a></li>
                    <li><a href="#" class="text-muted text-decoration-none hover-white transition-all">Política de Cookies</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5 class="text-light mb-4 font-weight-bold" style="font-family: 'Outfit', sans-serif;">Acceso</h5>
                <p class="text-muted mb-4">¿Ya eres parte de la comunidad?</p>
                <a href="/auth/login" class="btn btn-outline-gold w-100 rounded-pill"><i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión</a>
            </div>
        </div>
        <div class="text-center mt-5 pt-4 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
            <p class="text-muted mb-0">&copy; <?= date('Y') ?> Barber Hub. Todos los derechos reservados.</p>
            <p class="text-muted mt-2" style="font-size: 0.85em;">Desarrollado orgullosamente por Daniel Morales y David Santos.</p>
        </div>
    </div>
</footer>

<style>
.hover-white:hover { color: #fff !important; }
.transition-all { transition: all 0.3s ease; }
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS JS for Animations -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Iniciar Animaciones AOS
    AOS.init({
        once: true,
        offset: 50,
        duration: 800,
        easing: 'ease-in-out-cubic',
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            document.querySelector('.navbar').style.backgroundColor = 'rgba(10, 10, 12, 0.95)';
            document.querySelector('.navbar').style.boxShadow = '0 10px 30px rgba(0,0,0,0.5)';
        } else {
            document.querySelector('.navbar').style.backgroundColor = 'rgba(10, 10, 12, 0.85)';
            document.querySelector('.navbar').style.boxShadow = 'none';
        }
    });
</script>
</body>
</html>
