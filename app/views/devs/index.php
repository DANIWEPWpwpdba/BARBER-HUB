<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Equipo de Desarrollo | Barber Hub' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --gold:#E2B04A; --gold2:#F5D78E; --dark:#0D0D0F; --card:#141418; --card2:#1C1C22; --border:rgba(255,255,255,0.07); --white:#FFFFFF; --off:#E8E8F0; --muted:#7A7A8C; }
        html { scroll-behavior: smooth; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); overflow-x:hidden; min-height:100vh; }
        h1,h2,h3,h4,h5 { font-family:'Outfit',sans-serif; }

        .bg-grid { position:fixed; inset:0; z-index:0;
            background-image: linear-gradient(rgba(226,176,74,0.03) 1px,transparent 1px), linear-gradient(90deg,rgba(226,176,74,0.03) 1px,transparent 1px);
            background-size:60px 60px; }
        .glow { position:fixed; border-radius:50%; z-index:0; pointer-events:none; }
        .glow-1 { top:-200px; left:-200px; width:600px; height:600px; background:radial-gradient(circle,rgba(226,176,74,0.1) 0%,transparent 70%); animation:gf 14s ease-in-out infinite alternate; }
        .glow-2 { bottom:-200px; right:-200px; width:500px; height:500px; background:radial-gradient(circle,rgba(226,176,74,0.06) 0%,transparent 70%); animation:gf 18s ease-in-out infinite alternate-reverse; }
        @keyframes gf { 0%{transform:translate(0,0)} 100%{transform:translate(35px,35px)} }

        .wrapper { position:relative; z-index:1; min-height:100vh; display:flex; flex-direction:column; }

        /* Navbar */
        .navbar { position:sticky; top:0; z-index:200; display:flex; align-items:center; justify-content:space-between; padding:16px 52px; background:rgba(13,13,15,0.88); backdrop-filter:blur(20px); border-bottom:1px solid var(--border); }
        .nav-logo { font-family:'Outfit',sans-serif; font-weight:800; font-size:1.5rem; color:var(--gold); text-decoration:none; display:flex; align-items:center; gap:10px; }
        .btn-nav { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; font-weight:700; font-size:0.9rem; padding:10px 22px; border-radius:50px; text-decoration:none; display:flex; align-items:center; gap:8px; box-shadow:0 4px 16px rgba(226,176,74,0.3); transition:all 0.3s; }
        .btn-nav:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(226,176,74,0.5); color:#000; }

        /* Header de la sección */
        .page-header { text-align:center; padding:90px 52px 60px; }
        .eyebrow { display:inline-block; font-size:0.75rem; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--gold); margin-bottom:16px; }
        .page-header h1 { font-size:clamp(2.2rem,4.5vw,3.6rem); font-weight:800; color:var(--white); margin-bottom:18px; letter-spacing:-1px; line-height:1.1; }
        .page-header h1 span { background:linear-gradient(90deg,var(--gold),var(--gold2)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .page-header p { font-size:1.05rem; color:#B0B0C4; line-height:1.85; max-width:540px; margin:0 auto; }

        /* Cards de desarrolladores */
        .devs-wrap { padding:0 52px 80px; max-width:1200px; margin:0 auto; width:100%; }
        .devs-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:24px; }

        .dev-card {
            background:var(--card); border:1px solid var(--border); border-radius:22px; overflow:hidden;
            transition:all 0.35s ease; position:relative;
        }
        .dev-card::after { content:''; position:absolute; bottom:0; left:0; right:0; height:2px; background:linear-gradient(90deg,transparent,var(--gold),transparent); opacity:0; transition:opacity 0.3s; }
        .dev-card:hover { transform:translateY(-8px); border-color:rgba(226,176,74,0.3); box-shadow:0 20px 50px rgba(0,0,0,0.6); }
        .dev-card:hover::after { opacity:1; }

        .dev-header { background:linear-gradient(135deg,#1a1a20,#22222a); padding:32px 28px 24px; text-align:center; border-bottom:1px solid var(--border); position:relative; }
        .dev-avatar {
            width:90px; height:90px; border-radius:50%; margin:0 auto 16px;
            border:3px solid rgba(226,176,74,0.4); overflow:hidden;
            display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg,var(--gold),#b8892d); font-size:2rem; color:#000; font-weight:800; font-family:'Outfit',sans-serif;
        }
        .dev-avatar img { width:100%; height:100%; object-fit:cover; }
        .dev-name { font-size:1.2rem; font-weight:800; color:var(--white); margin-bottom:4px; }
        .dev-cargo { font-size:0.82rem; font-weight:600; color:var(--gold); background:rgba(226,176,74,0.1); border:1px solid rgba(226,176,74,0.2); padding:4px 12px; border-radius:50px; display:inline-block; }

        .dev-body { padding:22px 24px; }
        .dev-desc { font-size:0.88rem; color:#9090A4; line-height:1.75; margin-bottom:18px; }
        .dev-contrib { font-size:0.82rem; color:var(--muted); margin-bottom:18px; border-left:2px solid rgba(226,176,74,0.3); padding-left:10px; font-style:italic; }
        .dev-social { display:flex; gap:8px; flex-wrap:wrap; }
        .dev-social-btn { width:34px; height:34px; border-radius:9px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.04); display:flex; align-items:center; justify-content:center; color:var(--muted); font-size:0.88rem; text-decoration:none; transition:all 0.22s; }
        .dev-social-btn:hover { border-color:var(--gold); color:var(--gold); background:rgba(226,176,74,0.08); transform:translateY(-2px); }

        /* Footer simple */
        .page-footer { border-top:1px solid var(--border); padding:24px 52px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; background:rgba(8,8,10,0.95); }
        .page-footer p { color:var(--muted); font-size:0.85rem; }
        .page-footer a { color:var(--gold); text-decoration:none; font-size:0.85rem; }

        @media (max-width:768px) {
            .navbar { padding:14px 20px; }
            .page-header { padding:80px 20px 50px; }
            .devs-wrap { padding:0 20px 60px; }
            .page-footer { padding:20px; flex-direction:column; text-align:center; }
        }
    </style>
</head>
<body>
<div class="bg-grid"></div>
<div class="glow glow-1"></div>
<div class="glow glow-2"></div>

<div class="wrapper">

<nav class="navbar">
    <a href="<?= BASE_URL ?>/" class="nav-logo"><i class="fas fa-crown"></i> BARBER HUB</a>
    <div style="display:flex; align-items:center; gap:10px;">
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

<div class="page-header" data-aos="fade-up">
    <p class="eyebrow"><i class="fas fa-code me-2"></i>Créditos del Sistema</p>
    <h1>El equipo detrás de<br><span>Barber Hub</span></h1>
    <p>Conoce a las personas que hicieron posible esta plataforma. Cada módulo, cada línea de código y cada detalle visual fue construido con dedicación y pasión.</p>
</div>

<div class="devs-wrap">
    <div class="devs-grid">
        <?php foreach ($devs as $i => $dev): ?>
        <div class="dev-card" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
            <div class="dev-header">
                <div class="dev-avatar">
                    <?php if ($dev['foto_url']): ?>
                        <img src="<?= htmlspecialchars($dev['foto_url']) ?>" alt="<?= htmlspecialchars($dev['nombre']) ?>">
                    <?php else: ?>
                        <?= strtoupper(substr($dev['nombre'], 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div class="dev-name"><?= htmlspecialchars($dev['nombre']) ?></div>
                <div class="dev-cargo"><?= htmlspecialchars($dev['cargo']) ?></div>
            </div>
            <div class="dev-body">
                <?php if ($dev['descripcion']): ?>
                <p class="dev-desc"><?= htmlspecialchars($dev['descripcion']) ?></p>
                <?php endif; ?>
                <?php if ($dev['contribuciones']): ?>
                <p class="dev-contrib"><?= htmlspecialchars($dev['contribuciones']) ?></p>
                <?php endif; ?>
                <div class="dev-social">
                    <?php if ($dev['github']): ?>
                    <a href="<?= htmlspecialchars($dev['github']) ?>" target="_blank" class="dev-social-btn" title="GitHub"><i class="fab fa-github"></i></a>
                    <?php endif; ?>
                    <?php if ($dev['linkedin']): ?>
                    <a href="<?= htmlspecialchars($dev['linkedin']) ?>" target="_blank" class="dev-social-btn" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>
                    <?php if ($dev['instagram']): ?>
                    <a href="<?= htmlspecialchars($dev['instagram']) ?>" target="_blank" class="dev-social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ($dev['facebook']): ?>
                    <a href="<?= htmlspecialchars($dev['facebook']) ?>" target="_blank" class="dev-social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if ($dev['sitio_web']): ?>
                    <a href="<?= htmlspecialchars($dev['sitio_web']) ?>" target="_blank" class="dev-social-btn" title="Sitio Web"><i class="fas fa-globe"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($devs)): ?>
        <!-- Demo card si no hay BD -->
        <?php foreach ([
            ['nombre'=>'Daniel Morales Ramírez','cargo'=>'Full Stack Developer & Arquitecto','desc'=>'Co-fundador y arquitecto principal de Barber Hub. Responsable del diseño del sistema, base de datos y backend.','github'=>'#','contribuciones'=>'Arquitectura MVC, Base de Datos, Backend PHP, Seguridad'],
            ['nombre'=>'David Santos Galicia','cargo'=>'Full Stack Developer & UI/UX','desc'=>'Co-fundador de Barber Hub. Responsable del frontend, diseño visual y experiencia de usuario.','github'=>'#','contribuciones'=>'Diseño UI, Frontend HTML/CSS/JS, Animaciones, UX'],
        ] as $i => $dev): ?>
        <div class="dev-card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
            <div class="dev-header">
                <div class="dev-avatar"><?= strtoupper(substr($dev['nombre'], 0, 1)) ?></div>
                <div class="dev-name"><?= $dev['nombre'] ?></div>
                <div class="dev-cargo"><?= $dev['cargo'] ?></div>
            </div>
            <div class="dev-body">
                <p class="dev-desc"><?= $dev['desc'] ?></p>
                <p class="dev-contrib"><?= $dev['contribuciones'] ?></p>
                <div class="dev-social">
                    <a href="<?= $dev['github'] ?>" class="dev-social-btn" title="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<footer class="page-footer">
    <p>&copy; <?= date('Y') ?> Barber Hub. Construido con dedicación.</p>
    <a href="<?= BASE_URL ?>/">← Volver al inicio</a>
</footer>

</div>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ once:true, offset:40, duration:700, easing:'ease-out-cubic' });</script>
</body>
</html>
