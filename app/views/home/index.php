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
        .glow-2 { bottom:-200px; right:-200px; width:550px; height:550px;
            background: radial-gradient(circle, rgba(226,176,74,0.07) 0%, transparent 70%);
            animation: gf 18s ease-in-out infinite alternate-reverse; }
        @keyframes gf { 0%{transform:translate(0,0)} 100%{transform:translate(35px,35px)} }

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

        /* ── HERO SIMPLE ── */
        .hero {
            padding: 90px 52px 60px;
            text-align: center;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25);
            color: #34D399; padding: 6px 16px; border-radius: 50px;
            font-size: 0.82rem; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 24px;
        }
        .hero-eyebrow .dot { width:7px; height:7px; background:#34D399; border-radius:50%; animation:pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }
        .hero h1 {
            font-size: clamp(2.4rem, 5vw, 4rem); font-weight: 800; line-height: 1.1;
            color: var(--white); margin-bottom: 18px; letter-spacing: -1px;
        }
        .hero h1 span {
            background: linear-gradient(90deg, var(--gold), var(--gold2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-desc { font-size: 1.05rem; color: #B0B0C4; line-height: 1.85; max-width: 580px; margin: 0 auto 36px; }
        .hero-search {
            display: flex; max-width: 520px; margin: 0 auto;
            background: var(--card); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
        }
        .hero-search input {
            flex: 1; background: transparent; border: none; outline: none;
            padding: 16px 20px; color: var(--white); font-size: 0.95rem; font-family: 'Inter',sans-serif;
        }
        .hero-search input::placeholder { color: var(--muted); }
        .hero-search button {
            background: linear-gradient(135deg, var(--gold), #b8892d);
            border: none; padding: 0 24px; cursor: pointer; color: #000;
            font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;
            transition: opacity 0.2s;
        }
        .hero-search button:hover { opacity: 0.9; }

        /* ── STATS ── */
        .stats-row {
            display: flex; justify-content: center; flex-wrap: wrap;
            gap: 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
            background: var(--card);
        }
        .stat { flex: 1; min-width: 160px; padding: 26px 20px; text-align: center; border-right: 1px solid var(--border); }
        .stat:last-child { border-right: none; }
        .stat-num { font-family:'Outfit',sans-serif; font-size:2rem; font-weight:800; color:var(--gold); display:block; line-height:1; margin-bottom:5px; }
        .stat-lbl { font-size:0.82rem; color:var(--muted); font-weight:500; }

        /* ── BARBERSHOPS GRID (TOP 5) ── */
        .shops-wrap { padding: 80px 52px; max-width: 1300px; margin: 0 auto; width: 100%; }
        .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; }
        .section-eyebrow { font-size:0.75rem; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--gold); margin-bottom:10px; display:block; }
        .section-h2 { font-size:clamp(1.8rem,3vw,2.6rem); font-weight:800; color:var(--white); margin-bottom:12px; }
        .section-sub { font-size:0.98rem; color:var(--muted); line-height:1.75; max-width:500px; }
        
        .view-all-btn { 
            color: var(--gold); border: 1px solid rgba(226,176,74,0.3); padding: 10px 24px;
            border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem;
            transition: all 0.3s; background: rgba(226,176,74,0.05); display:inline-flex; align-items:center; gap:8px;
        }
        .view-all-btn:hover { background: rgba(226,176,74,0.15); transform: translateX(5px); }

        .shops-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr)); gap: 22px; }

        .shop-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 20px; overflow: hidden; transition: all 0.35s ease; position: relative;
        }
        .shop-card:hover { transform: translateY(-8px); border-color: rgba(226,176,74,0.3); box-shadow: 0 20px 50px rgba(0,0,0,0.6); }

        .shop-img { position: relative; overflow: hidden; }
        .shop-img img { width:100%; height:220px; object-fit:cover; display:block; transition: transform 0.5s ease; }
        .shop-card:hover .shop-img img { transform: scale(1.05); }
        .shop-badge {
            position: absolute; top: 14px; right: 14px;
            background: rgba(13,13,15,0.85); backdrop-filter: blur(8px);
            border: 1px solid rgba(226,176,74,0.3); color: var(--gold);
            font-size: 0.75rem; font-weight: 700; padding: 5px 12px; border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
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

        /* ── TOP 10 BARBEROS ── */
        .barberos-section {
            background: linear-gradient(to bottom, transparent, rgba(20,20,24,0.6), transparent);
            padding: 80px 0; border-top: 1px solid rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.03);
        }
        .barberos-wrap { max-width: 1300px; margin: 0 auto; padding: 0 52px; }
        
        .barberos-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;
        }
        
        .barbero-card {
            background: var(--card2); border: 1px solid var(--border);
            border-radius: 16px; padding: 20px; text-align: center;
            transition: all 0.3s ease; position: relative;
        }
        .barbero-card:hover { transform: translateY(-5px); border-color: rgba(226,176,74,0.3); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        
        .barbero-rank {
            position: absolute; top: 10px; left: 10px; width: 30px; height: 30px;
            background: linear-gradient(135deg, var(--gold), #b8892d); color: #000;
            display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;
            border-radius: 50%; box-shadow: 0 4px 10px rgba(226,176,74,0.4); z-index: 2;
        }
        .barbero-card:nth-child(1) .barbero-rank { transform: scale(1.2); }
        
        .barbero-img {
            width: 90px; height: 90px; border-radius: 50%; margin: 0 auto 15px;
            background: var(--dark); border: 2px solid var(--gold); padding: 3px;
        }
        .barbero-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        
        .barbero-name { font-size: 1.1rem; font-weight: 700; color: var(--white); margin-bottom: 4px; }
        .barbero-shop { font-size: 0.8rem; color: var(--gold); font-weight: 500; margin-bottom: 12px; }
        
        .barbero-stats { display: flex; justify-content: space-around; background: rgba(0,0,0,0.2); padding: 10px; border-radius: 10px; }
        .b-stat { display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .b-stat span:first-child { font-size: 0.85rem; font-weight: 700; color: var(--white); }
        .b-stat span:last-child { font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; }
        .b-stat i.fa-star { color: #FBBF24; font-size: 0.8rem; }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border); background: rgba(8,8,10,0.98);
            padding: 60px 52px 30px;
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

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .footer-top { grid-template-columns: 1fr 1fr; }
            .section-header { flex-direction: column; align-items: flex-start; gap: 20px; }
        }
        @media (max-width: 768px) {
            .navbar { padding:14px 20px; }
            .nav-links .nav-link { display:none; }
            .hero { padding:80px 20px 50px; }
            .shops-wrap, .barberos-wrap { padding:60px 20px; }
            footer { padding:50px 20px 24px; }
            .footer-top { grid-template-columns: 1fr; gap:30px; }
            .footer-bottom { flex-direction:column; text-align:center; }
            .stats-row .stat { min-width:50%; border-right:none; border-bottom:1px solid var(--border); }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="glow glow-1"></div>
<div class="glow glow-2"></div>

<div class="wrapper">

<!-- ── NAVBAR ── -->
<nav class="navbar" id="navbar">
    <a href="<?= BASE_URL ?>/" class="nav-logo"><i class="fas fa-crown"></i> BARBER HUB</a>
    <div class="nav-links">
        <a href="<?= BASE_URL ?>/sucursales" class="nav-link"><i class="fas fa-store"></i> Explorar Sucursales</a>
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

<!-- ── HERO ── -->
<section class="hero" data-aos="fade-up" data-aos-duration="800">
    <div class="hero-eyebrow"><div class="dot"></div> La red premium de barberías más grande</div>
    <h1>Bienvenido a<br><span>Barber Hub</span></h1>
    <p class="hero-desc">Tu destino premium para el corte perfecto. Encuentra tu sucursal más cercana, conoce a nuestros barberos de élite y reserva tu cita en minutos.</p>
    <form class="hero-search" action="<?= BASE_URL ?>/sucursales" method="GET">
        <input type="text" name="q" placeholder="Buscar por sucursal, ciudad o estilo..." required>
        <button type="submit"><i class="fas fa-search"></i> Buscar</button>
    </form>
</section>

<!-- ── STATS ── -->
<div class="stats-row">
    <div class="stat" data-aos="fade-up" data-aos-delay="0">
        <span class="stat-num">30+</span>
        <span class="stat-lbl">Sucursales Activas</span>
    </div>
    <div class="stat" data-aos="fade-up" data-aos-delay="60">
        <span class="stat-num">240+</span>
        <span class="stat-lbl">Barberos Pro</span>
    </div>
    <div class="stat" data-aos="fade-up" data-aos-delay="120">
        <span class="stat-num">4.9★</span>
        <span class="stat-lbl">Calificación Promedio</span>
    </div>
    <div class="stat" data-aos="fade-up" data-aos-delay="180">
        <span class="stat-num">1.5K+</span>
        <span class="stat-lbl">Citas Agendadas</span>
    </div>
</div>

<!-- ── TOP 5 SUCURSALES ── -->
<section class="shops-wrap" id="top-barberias">
    <div class="section-header">
        <div>
            <span class="section-eyebrow" data-aos="fade-up">Elite Selection</span>
            <h2 class="section-h2" data-aos="fade-up" data-aos-delay="50">Top 5 Barberías</h2>
            <p class="section-sub" data-aos="fade-up" data-aos-delay="100">Nuestras sedes mejor calificadas por clientes como tú, ofreciendo siempre la máxima calidad.</p>
        </div>
        <div data-aos="fade-left" data-aos-delay="150">
            <a href="<?= BASE_URL ?>/sucursales" class="view-all-btn">Ver Catálogo Completo <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="shops-grid">
        <?php if (!empty($top_barberias)): ?>
            <?php foreach ($top_barberias as $i => $b): ?>
            <div class="shop-card" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <div class="shop-img">
                    <img src="<?= $b['portada'] ?? ASSETS_URL . '/img/shop_modern_1780262229137.png' ?>" alt="<?= htmlspecialchars($b['nombre_comercial']) ?>">
                    <span class="shop-badge">#<?= $i + 1 ?> Top</span>
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
        <?php else: ?>
            <p style="color:var(--muted); grid-column: 1/-1; text-align:center;">No hay datos de barberías todavía.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ── TOP 10 BARBEROS ── -->
<section class="barberos-section">
    <div class="barberos-wrap">
        <div style="text-align:center; margin-bottom: 50px;">
            <span class="section-eyebrow" data-aos="fade-up">Master Class</span>
            <h2 class="section-h2" data-aos="fade-up" data-aos-delay="50">Top 10 Barberos</h2>
            <p class="section-sub" style="margin: 0 auto;" data-aos="fade-up" data-aos-delay="100">Los artistas con más experiencia y mejor calificación de toda nuestra red.</p>
        </div>

        <div class="barberos-grid">
            <?php if (!empty($top_barberos)): ?>
                <?php foreach ($top_barberos as $i => $barb): ?>
                <div class="barbero-card" data-aos="zoom-in" data-aos-delay="<?= $i * 60 ?>">
                    <div class="barbero-rank">#<?= $i + 1 ?></div>
                    <div class="barbero-img">
                        <img src="<?= $barb['fotografia'] ? BASE_URL . '/uploads/perfiles/' . $barb['fotografia'] : 'https://ui-avatars.com/api/?name='.urlencode($barb['nombre']).'&background=141418&color=E2B04A&size=128' ?>" alt="<?= htmlspecialchars($barb['nombre']) ?>">
                    </div>
                    <h3 class="barbero-name"><?= htmlspecialchars(explode(' ', $barb['nombre'])[0]) ?></h3>
                    <p class="barbero-shop"><i class="fas fa-store-alt"></i> <?= htmlspecialchars($barb['sucursal']) ?></p>
                    
                    <div class="barbero-stats">
                        <div class="b-stat">
                            <span><?= number_format($barb['rating'], 1) ?> <i class="fas fa-star"></i></span>
                            <span>Rating</span>
                        </div>
                        <div class="b-stat">
                            <span><?= $barb['anios_experiencia'] ?> <i class="fas fa-award" style="color:var(--gold)"></i></span>
                            <span>Años Exp.</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
    <div class="footer-top">
        <!-- Marca -->
        <div class="footer-brand">
            <h3><i class="fas fa-crown me-2"></i><?= htmlspecialchars($empresa) ?></h3>
            <p><?= htmlspecialchars($slogan) ?><br><?= htmlspecialchars($desc) ?></p>
            <div class="footer-social">
                <?php if ($igUrl && $igUrl !== '#'): ?>
                <a href="<?= $igUrl ?>" target="_blank" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
                <?php if ($fbUrl && $fbUrl !== '#'): ?>
                <a href="<?= $fbUrl ?>" target="_blank" class="social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if ($twUrl && $twUrl !== '#'): ?>
                <a href="<?= $twUrl ?>" target="_blank" class="social-btn" title="Twitter / X"><i class="fab fa-x-twitter"></i></a>
                <?php endif; ?>
                <?php if ($ttUrl): ?>
                <a href="<?= $ttUrl ?>" target="_blank" class="social-btn" title="TikTok"><i class="fab fa-tiktok"></i></a>
                <?php endif; ?>
                <?php if ($ytUrl): ?>
                <a href="<?= $ytUrl ?>" target="_blank" class="social-btn" title="YouTube"><i class="fab fa-youtube"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Navegación -->
        <div class="footer-col">
            <h5>Explorar</h5>
            <ul>
                <li><a href="<?= BASE_URL ?>/sucursales"><i class="fas fa-store-alt"></i> Nuestras Sucursales</a></li>
                <li><a href="<?= BASE_URL ?>/directorio"><i class="fas fa-map-marked-alt"></i> Directorio</a></li>
                <li><a href="<?= BASE_URL ?>/auth/login"><i class="fas fa-sign-in-alt"></i> Panel Administrativo</a></li>
                <?php if ($mostrarDevs): ?>
                <li><a href="<?= BASE_URL ?>/devs"><i class="fas fa-code"></i> Equipo de Desarrollo</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Legal -->
        <div class="footer-col">
            <h5>Información</h5>
            <ul>
                <li><a href="#"><i class="fas fa-file-alt"></i> Términos y Condiciones</a></li>
                <li><a href="#"><i class="fas fa-shield-alt"></i> Aviso de Privacidad</a></li>
                <li><a href="#"><i class="fas fa-cookie-bite"></i> Política de Cookies</a></li>
            </ul>
        </div>

        <!-- Contacto -->
        <div class="footer-col">
            <h5>Contacto</h5>
            <?php if ($tel): ?>
            <div class="contact-item"><i class="fas fa-phone-alt"></i> <?= htmlspecialchars($tel) ?></div>
            <?php endif; ?>
            <?php if ($mail): ?>
            <div class="contact-item"><i class="fas fa-envelope"></i> <?= htmlspecialchars($mail) ?></div>
            <?php endif; ?>
            <?php if ($dir): ?>
            <div class="contact-item"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($dir) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($empresa) ?>. <?= htmlspecialchars($cfg['derechos'] ?? 'Todos los derechos reservados.') ?></p>
        <a href="<?= BASE_URL ?>/devs">⚡ Hecho con pasión por el equipo Barber Hub</a>
    </div>
</footer>

</div><!-- /wrapper -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 40, duration: 700, easing: 'ease-out-cubic' });
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').style.boxShadow =
            window.scrollY > 50 ? '0 8px 30px rgba(0,0,0,0.7)' : 'none';
    });
</script>
</body>
</html>
