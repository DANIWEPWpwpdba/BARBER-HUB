<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? APP_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --gold: #E2B04A; --gold2: #F5D78E; --dark: #0D0D0F;
            --card: #141418; --card2: #1C1C22;
            --border: rgba(255,255,255,0.07);
            --white: #FFFFFF; --off: #E8E8F0; --muted: #7A7A8C;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--white); overflow-x: hidden; }
        h1,h2,h3,h4,h5 { font-family: 'Outfit', sans-serif; }

        /* ── BG ── */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(226,176,74,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(226,176,74,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .glow { position: fixed; border-radius: 50%; z-index: 0; pointer-events: none; }
        .glow-1 { top:-200px; left:-200px; width:650px; height:650px;
            background: radial-gradient(circle, rgba(226,176,74,0.11) 0%, transparent 70%);
            animation: gf 14s ease-in-out infinite alternate; }

        .wrapper { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky; top: 0; z-index: 200;
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 52px;
            background: rgba(13,13,15,0.85); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow 0.3s;
        }
        .nav-logo { font-family:'Outfit',sans-serif; font-weight:800; font-size:1.5rem;
            color:var(--gold); text-decoration:none; display:flex; align-items:center; gap:10px; }
        .nav-links { display:flex; align-items:center; gap:6px; }
        .nav-link { color:var(--off); text-decoration:none; font-size:0.9rem; font-weight:500;
            padding:8px 14px; border-radius:8px; transition:all 0.2s; }
        .nav-link:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .btn-nav {
            background: linear-gradient(135deg, var(--gold), #b8892d);
            color:#000; font-weight:700; font-size:0.9rem; padding:10px 24px;
            border-radius:50px; text-decoration:none; display:flex; align-items:center; gap:8px;
            box-shadow:0 4px 18px rgba(226,176,74,0.35); transition:all 0.3s; margin-left:8px;
        }
        .btn-nav:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(226,176,74,0.5); color:#000; }

        /* ── CATALOG HEADER ── */
        .catalog-header {
            padding: 60px 52px 30px; text-align: center;
        }
        .catalog-header h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 15px; }
        .catalog-header p { font-size: 1.05rem; color: var(--muted); max-width: 600px; margin: 0 auto; }

        /* ── FILTER BAR ── */
        .filter-bar {
            max-width: 1300px; margin: 0 auto 40px; padding: 0 52px;
            display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;
        }
        .filter-group {
            display: flex; align-items: center; background: var(--card2);
            border: 1px solid var(--border); border-radius: 50px; overflow: hidden;
            padding: 5px 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            flex: 1; min-width: 250px; max-width: 400px;
        }
        .filter-group i { color: var(--gold); margin-right: 10px; }
        .filter-group input, .filter-group select {
            background: transparent; border: none; outline: none; color: var(--white);
            padding: 10px 0; font-family: 'Inter', sans-serif; font-size: 0.9rem; width: 100%;
        }
        .filter-group select option { background: var(--card2); color: var(--white); }

        /* ── BARBERSHOPS GRID ── */
        .shops-wrap { padding: 0 52px 80px; max-width: 1300px; margin: 0 auto; width: 100%; flex: 1; }
        .shops-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr)); gap: 22px; }

        .shop-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 20px; overflow: hidden; transition: all 0.35s ease; position: relative;
        }
        .shop-card:hover { transform: translateY(-8px); border-color: rgba(226,176,74,0.3); box-shadow: 0 20px 50px rgba(0,0,0,0.6); }

        .shop-img { position: relative; overflow: hidden; }
        .shop-img img { width:100%; height:220px; object-fit:cover; display:block; transition: transform 0.5s ease; }
        .shop-card:hover .shop-img img { transform: scale(1.05); }
        .shop-rating-overlay {
            position: absolute; bottom: 14px; left: 14px;
            background: rgba(13,13,15,0.85); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 5px;
            font-size: 0.82rem; font-weight: 600; color: #FBBF24;
            padding: 5px 12px; border-radius: 50px;
        }
        .shop-body { padding: 22px; }
        .shop-body h3 { font-size:1.15rem; font-weight:700; color:var(--white); margin-bottom:6px; }
        .shop-loc { font-size:0.82rem; color:var(--muted); display:flex; align-items:center; gap:5px; margin-bottom:12px; }
        .shop-desc { font-size:0.88rem; color:#9090A4; line-height:1.75; margin-bottom:16px; 
                     display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .shop-footer-card { display:flex; align-items:center; justify-content:space-between; border-top:1px solid var(--border); padding-top:14px; }
        .shop-status { display:flex; align-items:center; gap:5px; font-size:0.78rem; font-weight:600; color:#34D399; }
        .shop-status .dot-green { width:7px; height:7px; background:#34D399; border-radius:50%; animation:pulse 2s infinite; }
        .btn-shop {
            background: linear-gradient(135deg, var(--gold), #b8892d);
            color:#000; font-weight:700; font-size:0.8rem; padding:8px 18px;
            border-radius:50px; text-decoration:none; display:flex; align-items:center; gap:6px;
            transition: all 0.3s; box-shadow:0 4px 12px rgba(226,176,74,0.25);
        }
        .btn-shop:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(226,176,74,0.4); color:#000; }

        .no-results {
            grid-column: 1/-1; text-align: center; padding: 50px;
            background: rgba(255,255,255,0.02); border-radius: 20px;
            border: 1px dashed rgba(255,255,255,0.1); display: none;
        }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border); background: rgba(8,8,10,0.98);
            padding: 60px 52px 30px; margin-top: auto;
        }
        .footer-top { display:grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap:40px; margin-bottom:50px; }
        .footer-brand h3 { font-family:'Outfit',sans-serif; font-weight:800; font-size:1.5rem; color:var(--gold); margin-bottom:8px; }
        .footer-brand p { font-size:0.88rem; color:var(--muted); line-height:1.8; margin-bottom:20px; }
        .footer-social { display:flex; gap:10px; flex-wrap:wrap; }
        .social-btn {
            width:38px; height:38px; border-radius:10px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            display:flex; align-items:center; justify-content:center;
            color: var(--muted); font-size:0.95rem; text-decoration:none;
            transition: all 0.25s;
        }
        .social-btn:hover { border-color:var(--gold); color:var(--gold); background:rgba(226,176,74,0.08); transform:translateY(-3px); }
        .footer-col h5 { font-family:'Outfit',sans-serif; font-weight:700; font-size:0.95rem; color:var(--white); margin-bottom:18px; }
        .footer-col ul { list-style:none; display:flex; flex-direction:column; gap:10px; }
        .footer-col ul li a { color:var(--muted); text-decoration:none; font-size:0.87rem; transition:color 0.2s; display:flex; align-items:center; gap:6px; }
        .footer-col ul li a:hover { color:var(--white); }
        .footer-col .contact-item { display:flex; align-items:center; gap:8px; color:var(--muted); font-size:0.87rem; margin-bottom:10px; }
        .footer-col .contact-item i { color:var(--gold); width:14px; }
        .footer-bottom {
            border-top: 1px solid var(--border); padding-top:24px;
            display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;
        }
        .footer-bottom p { color:var(--muted); font-size:0.82rem; }
        .footer-bottom a { color:var(--gold); text-decoration:none; font-size:0.82rem; }
        .footer-bottom a:hover { text-decoration:underline; }

        @media (max-width: 768px) {
            .navbar { padding:14px 20px; }
            .nav-links .nav-link { display:none; }
            .catalog-header, .filter-bar, .shops-wrap { padding-left: 20px; padding-right: 20px; }
            .filter-group { min-width: 100%; max-width: 100%; }
            footer { padding:50px 20px 24px; }
            .footer-top { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction:column; text-align:center; }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="glow glow-1"></div>

<div class="wrapper">

<!-- ── NAVBAR ── -->
<nav class="navbar" id="navbar">
    <a href="<?= BASE_URL ?>/" class="nav-logo"><i class="fas fa-crown"></i> BARBER HUB</a>
    <div class="nav-links">
        <a href="<?= BASE_URL ?>/" class="nav-link"><i class="fas fa-home"></i> Inicio</a>
        <a href="<?= BASE_URL ?>/devs" class="nav-link"><i class="fas fa-code me-1"></i> Equipo Dev</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if($_SESSION['rol_id'] == 6): ?>
                <a href="<?= BASE_URL ?>/perfil" class="btn-nav"><i class="fas fa-user"></i> Mi Perfil</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/dashboard" class="btn-nav"><i class="fas fa-th-large"></i> Ir al Panel</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/auth/login" class="btn-nav"><i class="fas fa-lock"></i> Acceder</a>
        <?php endif; ?>
    </div>
</nav>

<!-- ── CATALOG HEADER ── -->
<div class="catalog-header" data-aos="fade-up">
    <h1>Catálogo de Sucursales</h1>
    <p>Explora nuestras <?= count($barberias) ?> barberías en todo el país. Filtra por nombre, ubicación, servicio que buscas o calificación para encontrar el lugar perfecto para ti.</p>
</div>

<!-- ── FILTER BAR ── -->
<div class="filter-bar" data-aos="fade-up" data-aos-delay="100">
    <div class="filter-group">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Buscar barbería o ciudad..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
    </div>
    
    <div class="filter-group">
        <i class="fas fa-star"></i>
        <select id="ratingFilter">
            <option value="0">Cualquier Calificación</option>
            <option value="4.5">4.5+ Estrellas</option>
            <option value="4.0">4.0+ Estrellas</option>
            <option value="3.0">3.0+ Estrellas</option>
        </select>
    </div>

    <div class="filter-group">
        <i class="fas fa-cut"></i>
        <select id="serviceFilter">
            <option value="">Cualquier Servicio</option>
            <?php foreach($servicios as $srv): ?>
                <option value="<?= strtolower(htmlspecialchars($srv['nombre'])) ?>"><?= htmlspecialchars($srv['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- ── BARBERSHOPS GRID ── -->
<section class="shops-wrap">
    <div class="shops-grid" id="shops-grid">
        <?php if (!empty($barberias)): ?>
            <?php foreach ($barberias as $i => $b): ?>
            <div class="shop-card" 
                 data-nombre="<?= strtolower($b['nombre_comercial'] . ' ' . $b['ciudad'] . ' ' . $b['estado_ubicacion']) ?>" 
                 data-rating="<?= $b['rating'] ?? 5 ?>" 
                 data-servicios="<?= $b['servicios_nombres'] ?>"
                 data-aos="fade-up" data-aos-delay="0">
                <div class="shop-img">
                    <img src="<?= $b['portada'] ?? ASSETS_URL . '/img/shop_modern_1780262229137.png' ?>" alt="<?= htmlspecialchars($b['nombre_comercial']) ?>">
                    <div class="shop-rating-overlay"><i class="fas fa-star"></i> <?= number_format($b['rating'] ?? 5, 1) ?></div>
                </div>
                <div class="shop-body">
                    <h3><?= htmlspecialchars($b['nombre_comercial']) ?></h3>
                    <p class="shop-loc"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($b['ciudad'] . ', ' . $b['estado_ubicacion']) ?></p>
                    <p class="shop-desc"><?= htmlspecialchars($b['descripcion']) ?></p>
                    <div class="shop-footer-card">
                        <div class="shop-status"><div class="dot-green"></div> <?= htmlspecialchars($b['estado']) ?></div>
                        <a href="<?= BASE_URL ?>/barberia/<?= strtolower(str_replace(' ', '-', $b['nombre_comercial'])) ?>" class="btn-shop"><i class="fas fa-arrow-right"></i> Reservar</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="no-results" id="noResults">
            <i class="fas fa-frown-open" style="font-size: 3rem; color: var(--gold); margin-bottom: 15px;"></i>
            <h3>No se encontraron sucursales</h3>
            <p style="color: var(--muted); margin-top: 10px;">Intenta ajustar tus filtros de búsqueda.</p>
        </div>
    </div>
</section>

<!-- ── FOOTER DINÁMICO ── -->
<?php
$cfg = $footer_cfg ?? [];
$empresa = $cfg['empresa_nombre'] ?? 'Barber Hub';
$slogan  = $cfg['empresa_slogan'] ?? 'El estilo es nuestra identidad.';
$desc    = $cfg['empresa_descripcion'] ?? 'Barbería premium con estilo, precisión y pasión.';
$tel     = $cfg['telefono'] ?? '';
$mail    = $cfg['correo'] ?? '';
$dir     = $cfg['direccion'] ?? '';
$igUrl   = $cfg['instagram'] ?? '#';
$fbUrl   = $cfg['facebook'] ?? '#';
$twUrl   = $cfg['twitter'] ?? '#';
$ttUrl   = $cfg['tiktok'] ?? '';
$ytUrl   = $cfg['youtube'] ?? '';
$mostrarDevs = ($cfg['mostrar_devs'] ?? '1') === '1';
?>
<footer>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($empresa) ?>. <?= htmlspecialchars($cfg['derechos'] ?? 'Todos los derechos reservados.') ?></p>
        <a href="<?= BASE_URL ?>/devs">⚡ Hecho con pasión por el equipo Barber Hub</a>
    </div>
</footer>

</div><!-- /wrapper -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 40, duration: 400, easing: 'ease-out-cubic' });
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').style.boxShadow =
            window.scrollY > 50 ? '0 8px 30px rgba(0,0,0,0.7)' : 'none';
    });

    // Filtros JS
    const searchInput = document.getElementById('searchInput');
    const ratingFilter = document.getElementById('ratingFilter');
    const serviceFilter = document.getElementById('serviceFilter');
    const cards = document.querySelectorAll('.shop-card');
    const noResults = document.getElementById('noResults');

    function applyFilters() {
        const query = searchInput.value.toLowerCase().trim();
        const minRating = parseFloat(ratingFilter.value);
        const reqService = serviceFilter.value;
        let visibleCount = 0;

        cards.forEach(card => {
            const nombreStr = card.dataset.nombre || '';
            const cardRating = parseFloat(card.dataset.rating) || 0;
            const cardServicios = card.dataset.servicios || '';

            // Match Text
            const matchText = query === '' || nombreStr.includes(query);
            
            // Match Rating
            const matchRating = cardRating >= minRating;

            // Match Service
            const matchService = reqService === '' || cardServicios.includes(reqService);

            if (matchText && matchRating && matchService) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', applyFilters);
    ratingFilter.addEventListener('change', applyFilters);
    serviceFilter.addEventListener('change', applyFilters);

    // Initial check (in case there's a ?q= parameter in URL)
    if(searchInput.value) {
        applyFilters();
    }
</script>
</body>
</html>
