<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Mis Credenciales' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --gold:#E2B04A; --dark:#0D0D0F; --card:#141418; --card2:#1C1C22; --border:rgba(255,255,255,0.08); --white:#fff; --muted:#7A7A8C; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; }
        h1,h2,h3,h4,h5 { font-family:'Outfit',sans-serif; }

        .topbar { background:rgba(13,13,15,0.9); border-bottom:1px solid var(--border); padding:16px 40px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; backdrop-filter:blur(16px); }
        .topbar-logo { color:var(--gold); font-weight:800; font-size:1.3rem; text-decoration:none; display:flex; align-items:center; gap:8px; }
        .btn-outline { border:1.5px solid rgba(255,255,255,0.15); color:var(--white); background:transparent; padding:8px 18px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.85rem; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; }
        .btn-outline:hover { border-color:rgba(255,255,255,0.3); }
        
        .main { padding:40px; max-width:600px; margin:0 auto; }
        .page-title { font-size:1.8rem; font-weight:800; color:var(--white); margin-bottom:6px; text-align:center; }
        .page-sub { font-size:0.9rem; color:var(--muted); margin-bottom:32px; text-align:center; }

        .alert-error { background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5; padding:12px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; }
        .alert-success { background:rgba(52,211,153,0.15); border:1px solid rgba(52,211,153,0.3); color:#6EE7B7; padding:12px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; }

        .form-card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:30px; }
        
        .form-group { margin-bottom:20px; }
        .form-group label { display:block; font-size:0.85rem; font-weight:600; color:var(--muted); margin-bottom:8px; }
        .form-group input { width:100%; background:var(--card2); border:1px solid var(--border); color:var(--white); padding:12px 16px; border-radius:10px; font-family:'Inter',sans-serif; font-size:0.95rem; outline:none; transition:border-color 0.2s; }
        .form-group input:focus { border-color:var(--gold); }
        
        .form-help { font-size:0.8rem; color:var(--muted); margin-top:6px; display:block; }

        .btn-submit { width:100%; background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:14px; border-radius:10px; font-weight:700; font-size:1rem; cursor:pointer; transition:opacity 0.2s; margin-top:10px; display:flex; align-items:center; justify-content:center; gap:8px; }
        .btn-submit:hover { opacity:0.9; }

    </style>
</head>
<body>

<nav class="topbar">
    <a href="<?= BASE_URL ?>/" class="topbar-logo"><i class="fas fa-crown"></i> Barber Hub</a>
    <a href="<?= BASE_URL ?>/devs/admin" class="btn-outline"><i class="fas fa-arrow-left"></i> Volver a Gestión</a>
</nav>

<div class="main">
    <h1 class="page-title">Mis Credenciales</h1>
    <p class="page-sub">Cambia tu correo de acceso o tu contraseña maestra.</p>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <form action="<?= BASE_URL ?>/devs/actualizar_credenciales" method="POST">
            
            <div class="form-group">
                <label>Nombre Público (Solo visualización)</label>
                <input type="text" value="<?= htmlspecialchars($usuario['nombre']) ?>" disabled style="opacity:0.6;">
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico (Login)</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Escribe una nueva contraseña si deseas cambiarla">
                <span class="form-help">Déjalo en blanco para mantener tu contraseña actual intacta.</span>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Guardar Cambios</button>
        </form>
    </div>
</div>

</body>
</html>
