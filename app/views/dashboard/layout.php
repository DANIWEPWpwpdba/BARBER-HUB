<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Dashboard | Barber Hub' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --gold:#E2B04A; --dark:#0D0D0F; --card:#141418; --border:rgba(255,255,255,0.08); --white:#fff; --muted:#7A7A8C; --sidebar:260px; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; display:flex; }
        h1,h2,h3 { font-family:'Outfit',sans-serif; }

        /* Sidebar */
        .sidebar { width:var(--sidebar); background:rgba(13,13,15,0.95); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; height:100vh; z-index:100; backdrop-filter:blur(10px); }
        .sidebar-brand { padding:24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; font-family:'Outfit',sans-serif; font-size:1.4rem; font-weight:800; color:var(--gold); text-decoration:none; }
        .sidebar-nav { padding:20px 14px; flex:1; overflow-y:auto; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:12px 16px; color:var(--muted); text-decoration:none; font-weight:500; font-size:0.9rem; border-radius:10px; margin-bottom:6px; transition:all 0.2s; }
        .nav-item i { width:20px; text-align:center; font-size:1.1rem; }
        .nav-item:hover { background:rgba(255,255,255,0.04); color:var(--white); }
        .nav-item.active { background:linear-gradient(90deg, rgba(226,176,74,0.1), transparent); color:var(--gold); border-left:3px solid var(--gold); }
        .sidebar-footer { padding:20px; border-top:1px solid var(--border); }
        .user-info { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
        .user-avatar { width:40px; height:40px; border-radius:50%; background:var(--gold); color:#000; display:flex; align-items:center; justify-content:center; font-weight:800; }
        .user-details h4 { font-size:0.9rem; color:var(--white); margin-bottom:2px; }
        .user-details p { font-size:0.75rem; color:var(--muted); }
        .btn-logout { display:flex; align-items:center; gap:8px; width:100%; padding:10px; border:none; background:rgba(239,68,68,0.1); color:#FCA5A5; border-radius:8px; font-weight:600; cursor:pointer; transition:all 0.2s; text-decoration:none; justify-content:center; }
        .btn-logout:hover { background:rgba(239,68,68,0.2); }

        /* Main Content */
        .main-wrapper { flex:1; margin-left:var(--sidebar); display:flex; flex-direction:column; min-height:100vh; }
        .topbar { padding:20px 40px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; background:rgba(13,13,15,0.8); backdrop-filter:blur(10px); position:sticky; top:0; z-index:90; }
        .topbar-title { font-size:1.2rem; font-weight:700; }
        .topbar-actions { display:flex; gap:16px; align-items:center; }
        
        .content { padding:40px; flex:1; }

        @media (max-width: 768px) {
            .sidebar { transform:translateX(-100%); transition:transform 0.3s; }
            .sidebar.open { transform:translateX(0); }
            .main-wrapper { margin-left:0; }
            .topbar { padding:16px 20px; }
            .content { padding:20px; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <a href="<?= BASE_URL ?>/" class="sidebar-brand"><i class="fas fa-crown"></i> Barber Hub</a>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/dashboard" class="nav-item <?= ($seccion ?? '') == 'inicio' ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i> Inicio
        </a>
        <?php if ($_SESSION['rol_id'] <= 4): ?>
        <a href="<?= BASE_URL ?>/dashboard/clientes_pendientes" class="nav-item <?= ($seccion ?? '') == 'pendientes' ? 'active' : '' ?>">
            <i class="fas fa-user-clock"></i> Aprobaciones
        </a>
        <a href="<?= BASE_URL ?>/dashboard/sucursales" class="nav-item <?= ($seccion ?? '') == 'sucursales' ? 'active' : '' ?>">
            <i class="fas fa-store"></i> Sucursales
        </a>
        <a href="<?= BASE_URL ?>/dashboard/barberos" class="nav-item <?= ($seccion ?? '') == 'barberos' ? 'active' : '' ?>">
            <i class="fas fa-cut"></i> Personal
        </a>
        <a href="<?= BASE_URL ?>/dashboard/servicios" class="nav-item <?= ($seccion ?? '') == 'servicios' ? 'active' : '' ?>">
            <i class="fas fa-list-ul"></i> Servicios
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['rol_id'] <= 4): ?>
        <a href="<?= BASE_URL ?>/finanzas/index" class="nav-item <?= ($seccion ?? '') == 'finanzas' ? 'active' : '' ?>">
            <i class="fas fa-wallet"></i> Finanzas
        </a>
        <a href="<?= BASE_URL ?>/finanzas/comisiones" class="nav-item <?= ($seccion ?? '') == 'comisiones' ? 'active' : '' ?>">
            <i class="fas fa-percentage"></i> Comisiones
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['rol_id'] == 5): ?>
        <a href="<?= BASE_URL ?>/finanzas/mis_comisiones" class="nav-item <?= ($seccion ?? '') == 'mis_comisiones' ? 'active' : '' ?>">
            <i class="fas fa-hand-holding-usd"></i> Mis Comisiones
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['rol_id'] <= 2): ?>
        <a href="<?= BASE_URL ?>/devs/admin" class="nav-item">
            <i class="fas fa-user-shield"></i> Desarrolladores
        </a>
        <a href="<?= BASE_URL ?>/herramientas/index" class="nav-item <?= ($seccion ?? '') == 'herramientas' ? 'active' : '' ?>">
            <i class="fas fa-tools"></i> Herramientas
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['rol_id'] <= 3): ?>
        <a href="<?= BASE_URL ?>/auditoria/index" class="nav-item <?= ($seccion ?? '') == 'seguridad' ? 'active' : '' ?>">
            <i class="fas fa-shield-alt"></i> Auditoría
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['rol_id'] <= 2): ?>
        <a href="<?= BASE_URL ?>/devs/footer" class="nav-item">
            <i class="fas fa-cogs"></i> Configuración
        </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/dashboard/agenda" class="nav-item <?= ($seccion ?? '') == 'agenda' ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i> Agenda
        </a>
        <a href="<?= BASE_URL ?>/dashboard/clientes" class="nav-item <?= ($seccion ?? '') == 'clientes' ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Clientes
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?></div>
            <div class="user-details">
                <h4><?= htmlspecialchars($_SESSION['nombre']) ?></h4>
                <p>Rol: <?= $_SESSION['rol_id'] ?></p>
            </div>
        </div>
        <a href="<?= BASE_URL ?>/auth/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </div>
</aside>

<div class="main-wrapper">
    <header class="topbar">
        <h2 class="topbar-title"><?= $titulo ?? 'Dashboard' ?></h2>
        <div class="topbar-actions">
            <!-- Menú hamburguesa para móvil -->
            <button style="background:transparent;border:none;color:var(--white);font-size:1.2rem;cursor:pointer;" class="d-md-none" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="fas fa-bars"></i></button>
        </div>
    </header>
    
    <main class="content">
        <!-- CONTENIDO DINÁMICO AQUÍ -->
        <?php require_once $vista_hija; ?>
    </main>
</div>

</body>
</html>
