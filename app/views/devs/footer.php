<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Configurar Footer' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --gold:#E2B04A; --dark:#0D0D0F; --card:#141418; --border:rgba(255,255,255,0.08); --white:#fff; --muted:#7A7A8C; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; }
        h1,h2,h3 { font-family:'Outfit',sans-serif; }

        .topbar { background:rgba(13,13,15,0.9); border-bottom:1px solid var(--border); padding:16px 40px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; backdrop-filter:blur(16px); }
        .topbar-logo { color:var(--gold); font-weight:800; font-size:1.3rem; text-decoration:none; display:flex; align-items:center; gap:8px; }
        .btn-sm { font-size:0.85rem; padding:8px 18px; border-radius:8px; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; border:none; cursor:pointer; }
        .btn-gold { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; }
        .btn-gold:hover { opacity:0.9; }
        .btn-outline { border:1.5px solid rgba(255,255,255,0.15); color:var(--white); background:transparent; }

        .main { padding:40px; max-width:900px; margin:0 auto; }
        .page-title { font-size:1.8rem; font-weight:800; color:var(--white); margin-bottom:6px; }
        .page-sub { font-size:0.9rem; color:var(--muted); margin-bottom:32px; }

        .success-box { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.25); border-radius:12px; padding:14px 18px; color:#6EE7B7; font-size:0.88rem; margin-bottom:20px; display:flex; align-items:center; gap:8px; }

        .form-card { background:var(--card); border:1px solid var(--border); border-radius:18px; padding:30px; margin-bottom:20px; }
        .form-card h3 { font-size:1rem; font-weight:700; color:var(--gold); margin-bottom:22px; padding-bottom:12px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:8px; }
        .form-group { margin-bottom:18px; }
        label { display:block; font-size:0.82rem; font-weight:600; color:#B0B0C0; margin-bottom:7px; letter-spacing:0.3px; }
        input[type="text"], input[type="url"], input[type="email"], textarea, select {
            width:100%; padding:12px 14px; background:rgba(255,255,255,0.04);
            border:1px solid rgba(255,255,255,0.1); border-radius:10px;
            color:var(--white); font-size:0.9rem; font-family:'Inter',sans-serif; outline:none;
            transition:border-color 0.25s, box-shadow 0.25s;
        }
        input:focus, textarea:focus { border-color:rgba(226,176,74,0.45); box-shadow:0 0 0 3px rgba(226,176,74,0.08); }
        input::placeholder, textarea::placeholder { color:var(--muted); }
        .grid2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .submit-row { display:flex; justify-content:flex-end; gap:12px; margin-top:24px; }

        @media (max-width:768px) {
            .topbar { padding:14px 20px; }
            .main { padding:24px 16px; }
            .grid2 { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<nav class="topbar">
    <a href="<?= BASE_URL ?>/" class="topbar-logo"><i class="fas fa-crown"></i> Barber Hub</a>
    <div style="display:flex;gap:10px;">
        <a href="<?= BASE_URL ?>/devs/admin" class="btn-sm btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
        <a href="<?= BASE_URL ?>/" class="btn-sm btn-outline"><i class="fas fa-eye"></i> Ver Footer</a>
    </div>
</nav>

<div class="main">
    <h1 class="page-title">Configurar Pie de Página</h1>
    <p class="page-sub">Todos los cambios se reflejarán inmediatamente en el footer del sitio.</p>

    <?php if ($guardado): ?>
    <div class="success-box"><i class="fas fa-check-circle"></i> ¡Cambios guardados exitosamente!</div>
    <?php endif; ?>

    <form method="POST">
        <!-- Información General -->
        <div class="form-card">
            <h3><i class="fas fa-building"></i> Información de la Empresa</h3>
            <div class="grid2">
                <div class="form-group">
                    <label>Nombre de la Empresa</label>
                    <input type="text" name="config[empresa_nombre]" value="<?= htmlspecialchars($config['empresa_nombre'] ?? '') ?>" placeholder="Barber Hub">
                </div>
                <div class="form-group">
                    <label>Slogan</label>
                    <input type="text" name="config[empresa_slogan]" value="<?= htmlspecialchars($config['empresa_slogan'] ?? '') ?>" placeholder="El estilo es nuestra identidad.">
                </div>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="config[empresa_descripcion]" rows="3" placeholder="Descripción breve del negocio..."><?= htmlspecialchars($config['empresa_descripcion'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Texto de Derechos</label>
                <input type="text" name="config[derechos]" value="<?= htmlspecialchars($config['derechos'] ?? '') ?>" placeholder="Todos los derechos reservados.">
            </div>
        </div>

        <!-- Contacto -->
        <div class="form-card">
            <h3><i class="fas fa-phone"></i> Información de Contacto</h3>
            <div class="grid2">
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="config[telefono]" value="<?= htmlspecialchars($config['telefono'] ?? '') ?>" placeholder="+52 222 000 0000">
                </div>
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="config[correo]" value="<?= htmlspecialchars($config['correo'] ?? '') ?>" placeholder="contacto@barberhub.mx">
                </div>
            </div>
            <div class="form-group">
                <label>Dirección / Ciudad</label>
                <input type="text" name="config[direccion]" value="<?= htmlspecialchars($config['direccion'] ?? '') ?>" placeholder="Puebla, México">
            </div>
        </div>

        <!-- Redes Sociales -->
        <div class="form-card">
            <h3><i class="fas fa-share-alt"></i> Redes Sociales <small style="font-size:0.75rem;color:var(--muted);font-family:'Inter';font-weight:400;">(Dejar vacío para ocultar el icono)</small></h3>
            <div class="grid2">
                <div class="form-group">
                    <label><i class="fab fa-instagram me-1"></i> Instagram</label>
                    <input type="url" name="config[instagram]" value="<?= htmlspecialchars($config['instagram'] ?? '') ?>" placeholder="https://instagram.com/...">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-facebook-f me-1"></i> Facebook</label>
                    <input type="url" name="config[facebook]" value="<?= htmlspecialchars($config['facebook'] ?? '') ?>" placeholder="https://facebook.com/...">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-x-twitter me-1"></i> Twitter / X</label>
                    <input type="url" name="config[twitter]" value="<?= htmlspecialchars($config['twitter'] ?? '') ?>" placeholder="https://twitter.com/...">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-tiktok me-1"></i> TikTok</label>
                    <input type="url" name="config[tiktok]" value="<?= htmlspecialchars($config['tiktok'] ?? '') ?>" placeholder="https://tiktok.com/@...">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-youtube me-1"></i> YouTube</label>
                    <input type="url" name="config[youtube]" value="<?= htmlspecialchars($config['youtube'] ?? '') ?>" placeholder="https://youtube.com/...">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-code me-1"></i> Mostrar link a Equipo Dev</label>
                    <select name="config[mostrar_devs]">
                        <option value="1" <?= ($config['mostrar_devs'] ?? '1') === '1' ? 'selected' : '' ?>>Sí, mostrar en footer</option>
                        <option value="0" <?= ($config['mostrar_devs'] ?? '1') === '0' ? 'selected' : '' ?>>No, ocultar</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="submit-row">
            <a href="<?= BASE_URL ?>/devs/admin" class="btn-sm btn-outline">Cancelar</a>
            <button type="submit" class="btn-sm btn-gold"><i class="fas fa-save"></i> Guardar Cambios</button>
        </div>
    </form>
</div>
</body>
</html>
