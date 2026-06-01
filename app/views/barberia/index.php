<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --gold: #E2B04A; --dark: #0D0D0F; --card: #141418; --border: rgba(255,255,255,0.07); --white: #FFFFFF; --muted: #7A7A8C; }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--white); overflow-x: hidden; }
        h1,h2,h3 { font-family: 'Outfit', sans-serif; }
        
        .navbar { padding: 16px 52px; background: rgba(13,13,15,0.9); border-bottom: 1px solid var(--border); display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; backdrop-filter:blur(10px); }
        .nav-logo { font-family:'Outfit',sans-serif; font-weight:800; font-size:1.5rem; color:var(--gold); text-decoration:none; }
        .btn-back { color:var(--muted); text-decoration:none; font-size:0.9rem; font-weight:600; transition:color 0.2s; }
        .btn-back:hover { color:var(--white); }

        .hero-microsite { position:relative; height:450px; display:flex; align-items:flex-end; padding:60px 52px; }
        .hero-bg { position:absolute; inset:0; z-index:0; }
        .hero-bg img { width:100%; height:100%; object-fit:cover; opacity:0.4; }
        .hero-overlay { position:absolute; inset:0; background:linear-gradient(to top, var(--dark) 0%, transparent 100%); z-index:1; }
        .hero-content { position:relative; z-index:2; max-width:800px; }
        .hero-content h1 { font-size:3.5rem; font-weight:800; margin-bottom:10px; color:var(--white); }
        .hero-content p { font-size:1.1rem; color:#C8C8D8; line-height:1.6; }

        .content-section { padding:60px 52px; display:grid; grid-template-columns:2fr 1fr; gap:40px; }
        
        .section-title { font-size:1.5rem; font-weight:700; color:var(--gold); margin-bottom:24px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        
        .barberos-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:20px; }
        .barbero-card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:24px; text-align:center; transition:transform 0.3s; }
        .barbero-card:hover { transform:translateY(-5px); border-color:var(--gold); }
        .b-avatar { width:80px; height:80px; border-radius:50%; background:var(--gold); color:#000; font-size:2rem; font-weight:800; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
        .barbero-card h3 { font-size:1.1rem; margin-bottom:4px; }
        .barbero-card p { font-size:0.85rem; color:var(--muted); margin-bottom:16px; }
        .btn-book { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:10px 20px; border-radius:50px; font-weight:700; font-size:0.85rem; cursor:pointer; width:100%; transition:all 0.2s; }
        .btn-book:hover { transform:scale(1.05); box-shadow:0 5px 15px rgba(226,176,74,0.3); }

        .sidebar-info { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:32px; height:fit-content; }
        .info-item { display:flex; gap:16px; margin-bottom:24px; }
        .info-icon { width:40px; height:40px; border-radius:10px; background:rgba(226,176,74,0.1); color:var(--gold); display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
        .info-text h4 { font-size:0.95rem; margin-bottom:4px; color:var(--white); }
        .info-text p { font-size:0.85rem; color:var(--muted); line-height:1.5; }

        @media (max-width: 900px) {
            .content-section { grid-template-columns:1fr; }
            .hero-microsite { padding:40px 20px; height:350px; }
            .hero-content h1 { font-size:2.5rem; }
            .navbar { padding:16px 20px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="<?= BASE_URL ?>/" class="nav-logo"><i class="fas fa-crown"></i> BARBER HUB</a>
    <a href="<?= BASE_URL ?>/" class="btn-back"><i class="fas fa-arrow-left"></i> Volver al Directorio</a>
</nav>

<header class="hero-microsite">
    <div class="hero-bg">
        <!-- Imagen de portada genérica por ahora -->
        <img src="https://images.unsplash.com/photo-1585747860715-2ba37e788b70?auto=format&fit=crop&q=80&w=2000" alt="Portada">
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1><?= htmlspecialchars($barberia['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($barberia['descripcion'] ?: 'La mejor experiencia en barbería, cuidando cada detalle de tu estilo.') ?></p>
    </div>
</header>

<div class="content-section">
    <div class="main-content">
        <h2 class="section-title">Elige a tu Profesional</h2>
        
        <?php if(empty($barberos)): ?>
            <div style="padding:40px; text-align:center; background:rgba(255,255,255,0.02); border:1px dashed var(--border); border-radius:16px; color:var(--muted);">
                <i class="fas fa-cut" style="font-size:2rem; margin-bottom:12px; opacity:0.5;"></i>
                <p>Próximamente se unirán barberos a esta sucursal.</p>
            </div>
        <?php else: ?>
            <div class="barberos-grid">
                <?php foreach($barberos as $b): ?>
                <div class="barbero-card">
                    <div class="b-avatar">
                        <?= strtoupper(substr($b['nombre'], 0, 1)) ?>
                    </div>
                    <h3><?= htmlspecialchars($b['nombre']) ?></h3>
                    <p><i class="fas fa-star" style="color:var(--gold);"></i> <?= $b['anios_experiencia'] ?> años exp.</p>
                    <?php
                        $b_slug = strtolower(str_replace(' ', '-', $barberia['nombre_comercial']));
                    ?>
                    <a href="<?= BASE_URL ?>/cita/reservar/<?= $b_slug ?>" class="btn-book" style="display:inline-block; text-decoration:none; margin-top:10px;">Reservar Cita</a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <aside class="sidebar-info">
        <h2 class="section-title">Información</h2>
        
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="info-text">
                <h4>Ubicación</h4>
                <p><?= htmlspecialchars($barberia['calle'] ?? 'Dirección no registrada') ?></p>
            </div>
        </div>
        
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
            <div class="info-text">
                <h4>Contacto</h4>
                <p><?= htmlspecialchars($barberia['telefono']) ?></p>
            </div>
        </div>
        
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-clock"></i></div>
            <div class="info-text">
                <h4>Horario</h4>
                <p>Lun - Sab: 10:00 AM - 8:00 PM<br>Domingo: Cerrado</p>
            </div>
        </div>
    </aside>
</div>

</body>
</html>
