<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Gestión de Desarrolladores' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --gold:#E2B04A; --dark:#0D0D0F; --card:#141418; --card2:#1C1C22; --border:rgba(255,255,255,0.08); --white:#fff; --muted:#7A7A8C; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; }
        h1,h2,h3,h4,h5 { font-family:'Outfit',sans-serif; }

        .topbar { background:rgba(13,13,15,0.9); border-bottom:1px solid var(--border); padding:16px 40px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; backdrop-filter:blur(16px); }
        .topbar-logo { color:var(--gold); font-weight:800; font-size:1.3rem; text-decoration:none; display:flex; align-items:center; gap:8px; }
        .topbar-links { display:flex; gap:12px; align-items:center; }
        .btn-sm { font-size:0.85rem; padding:8px 18px; border-radius:8px; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; border:none; cursor:pointer; }
        .btn-gold { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; }
        .btn-gold:hover { opacity:0.9; transform:translateY(-1px); }
        .btn-outline { border:1.5px solid rgba(255,255,255,0.15); color:var(--white); background:transparent; }
        .btn-outline:hover { border-color:rgba(255,255,255,0.3); }
        .btn-danger { background:rgba(239,68,68,0.15); color:#FCA5A5; border:1px solid rgba(239,68,68,0.3); }
        .btn-danger:hover { background:rgba(239,68,68,0.25); }

        .main { padding:40px; max-width:1100px; margin:0 auto; }
        .page-title { font-size:1.8rem; font-weight:800; color:var(--white); margin-bottom:6px; }
        .page-sub { font-size:0.9rem; color:var(--muted); margin-bottom:32px; }

        .warning-box { background:rgba(251,191,36,0.08); border:1px solid rgba(251,191,36,0.25); border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-size:0.88rem; color:#FDE68A; margin-bottom:28px; }

        /* Tabla */
        .table-wrap { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { background:rgba(255,255,255,0.03); color:var(--muted); font-size:0.78rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:14px 18px; text-align:left; border-bottom:1px solid var(--border); }
        tbody tr { border-bottom:1px solid var(--border); transition:background 0.2s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,0.02); }
        tbody td { padding:14px 18px; font-size:0.88rem; color:#C8C8D8; vertical-align:middle; }
        tbody td strong { color:var(--white); font-size:0.95rem; }
        .estado-activo { color:#34D399; font-weight:600; font-size:0.8rem; }
        .estado-inactivo { color:var(--muted); font-weight:600; font-size:0.8rem; }

        .actions { display:flex; gap:8px; }

        @media (max-width:768px) {
            .topbar { padding:14px 20px; }
            .main { padding:24px 16px; }
            table { font-size:0.82rem; }
        }
    </style>
</head>
<body>

<nav class="topbar">
    <a href="<?= BASE_URL ?>/" class="topbar-logo"><i class="fas fa-crown"></i> Barber Hub</a>
    <div class="topbar-links">
        <a href="<?= BASE_URL ?>/devs/credenciales" class="btn-sm btn-outline"><i class="fas fa-key"></i> Mis Credenciales</a>
        <a href="<?= BASE_URL ?>/devs/footer" class="btn-sm btn-outline"><i class="fas fa-sliders-h"></i> Configurar Footer</a>
        <a href="<?= BASE_URL ?>/devs" class="btn-sm btn-outline"><i class="fas fa-eye"></i> Vista Pública</a>
        <a href="<?= BASE_URL ?>/devs/crear" class="btn-sm btn-gold"><i class="fas fa-plus"></i> Agregar Dev</a>
    </div>
</nav>

<div class="main">
    <h1 class="page-title">Gestión de Desarrolladores</h1>
    <p class="page-sub">Solo <strong>Daniel Morales</strong> y <strong>David Santos</strong> pueden administrar esta sección.</p>

    <div class="warning-box">
        <i class="fas fa-exclamation-triangle"></i>
        Los desarrolladores marcados como <strong>Inactivo</strong> no aparecerán en la página pública de créditos.
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th>Orden</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($devs as $dev): ?>
                <tr>
                    <td><?= $dev['id'] ?></td>
                    <td><strong><?= htmlspecialchars($dev['nombre']) ?></strong></td>
                    <td><?= htmlspecialchars($dev['cargo']) ?></td>
                    <td>
                        <?php if ($dev['estado'] === 'Activo'): ?>
                            <span class="estado-activo">● Activo</span>
                        <?php else: ?>
                            <span class="estado-inactivo">○ Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $dev['orden'] ?></td>
                    <td>
                        <div class="actions">
                            <a href="<?= BASE_URL ?>/devs/editar/<?= $dev['id'] ?>" class="btn-sm btn-outline"><i class="fas fa-edit"></i> Editar</a>
                            <a href="<?= BASE_URL ?>/devs/toggleEstado/<?= $dev['id'] ?>" class="btn-sm btn-danger" onclick="return confirm('¿Cambiar estado de este desarrollador?')">
                                <?= $dev['estado'] === 'Activo' ? '<i class="fas fa-eye-slash"></i> Desactivar' : '<i class="fas fa-eye"></i> Activar' ?>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($devs)): ?>
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted);">No hay desarrolladores registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
