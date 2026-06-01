<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --gold:#E2B04A; --dark:#0D0D0F; --card:#141418; --border:rgba(255,255,255,0.08); --white:#fff; --muted:#7A7A8C; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 30px; }
        h1 { font-family:'Outfit',sans-serif; color:var(--gold); margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display:block; margin-bottom:8px; font-size:0.9rem; color:var(--muted); }
        input, select, textarea { width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--border); border-radius:8px; padding:12px 16px; color:var(--white); font-family:inherit; }
        input:focus, select:focus, textarea:focus { border-color:var(--gold); outline:none; }
        .btn { display:inline-block; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:600; cursor:pointer; border:none; text-align:center; }
        .btn-gold { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; width:100%; }
        .btn-outline { border:1px solid var(--border); color:var(--white); background:transparent; margin-bottom:20px; }
        .btn-outline:hover { background:rgba(255,255,255,0.05); }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= BASE_URL ?>/devs/admin" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver a Desarrolladores</a>
        
        <h1><?= $titulo ?></h1>
        <form method="POST">
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($dev['nombre'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Cargo / Rol</label>
                <input type="text" name="cargo" value="<?= htmlspecialchars($dev['cargo'] ?? '') ?>" required placeholder="Ej. Full Stack Developer">
            </div>
            <div class="form-group">
                <label>Biografía Breve</label>
                <textarea name="bio" rows="3"><?= htmlspecialchars($dev['bio'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Enlace de Foto (URL)</label>
                <input type="url" name="foto_url" value="<?= htmlspecialchars($dev['foto_url'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>GitHub (URL)</label>
                <input type="url" name="github" value="<?= htmlspecialchars($dev['github'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>LinkedIn (URL)</label>
                <input type="url" name="linkedin" value="<?= htmlspecialchars($dev['linkedin'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Orden (Prioridad en la lista)</label>
                <input type="number" name="orden" value="<?= htmlspecialchars($dev['orden'] ?? '0') ?>">
            </div>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Guardar Desarrollador</button>
        </form>
    </div>
</body>
</html>
