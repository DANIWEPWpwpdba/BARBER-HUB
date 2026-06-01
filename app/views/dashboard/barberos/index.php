<?php ob_start(); ?>
<style>
    .header-actions { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
    .btn-primary { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:10px 20px; border-radius:10px; font-weight:700; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:0.9rem; }
    
    .grid-barberos { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
    .card-barbero { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; display:flex; flex-direction:column; }
    .card-barbero:hover { border-color:rgba(226,176,74,0.3); }
    .card-header { padding:20px; text-align:center; border-bottom:1px solid var(--border); position:relative; }
    .avatar { width:80px; height:80px; border-radius:50%; background:var(--gold); color:#000; font-size:2rem; font-weight:800; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; font-family:'Outfit',sans-serif; }
    .avatar img { width:100%; height:100%; border-radius:50%; object-fit:cover; }
    .nombre { font-size:1.1rem; font-weight:700; color:var(--white); margin-bottom:4px; }
    .sucursal { font-size:0.8rem; color:var(--gold); background:rgba(226,176,74,0.1); padding:4px 10px; border-radius:50px; display:inline-block; }
    .card-body { padding:20px; flex:1; }
    .info-row { display:flex; justify-content:space-between; margin-bottom:10px; font-size:0.85rem; }
    .info-label { color:var(--muted); }
    .info-val { color:var(--white); font-weight:500; }
    .card-footer { padding:16px 20px; border-top:1px solid var(--border); display:flex; gap:10px; background:rgba(255,255,255,0.01); }
    .btn-sm-outline { flex:1; padding:8px; text-align:center; border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:var(--white); text-decoration:none; font-size:0.85rem; font-weight:600; transition:all 0.2s; }
    .btn-sm-outline:hover { background:rgba(255,255,255,0.05); }
    .status-badge { position:absolute; top:16px; right:16px; width:12px; height:12px; border-radius:50%; }
    .status-active { background:#34D399; box-shadow:0 0 10px rgba(52,211,153,0.5); }
</style>

<div class="header-actions">
    <div>
        <p style="color:var(--muted); font-size:0.9rem;">Gestiona a tu equipo de profesionales.</p>
    </div>
    <a href="<?= BASE_URL ?>/dashboard/barberos/nuevo" class="btn-primary">
        <i class="fas fa-plus"></i> Añadir Personal
    </a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'creado'): ?>
<div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#6EE7B7; padding:12px 16px; border-radius:10px; margin-bottom:24px;">
    <i class="fas fa-check-circle"></i> Personal registrado exitosamente. Se ha generado su acceso.
</div>
<?php endif; ?>

<div class="grid-barberos">
    <?php foreach ($barberos as $b): ?>
    <div class="card-barbero">
        <div class="card-header">
            <div class="status-badge status-active" title="Activo"></div>
            <div class="avatar">
                <?php if($b['fotografia']): ?>
                    <img src="<?= htmlspecialchars($b['fotografia']) ?>" alt="Foto">
                <?php else: ?>
                    <?= strtoupper(substr($b['nombre'], 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="nombre"><?= htmlspecialchars($b['nombre']) ?></div>
            <div class="sucursal"><i class="fas fa-store-alt"></i> <?= htmlspecialchars($b['barberia_nombre'] ?? 'Global') ?></div>
        </div>
        <div class="card-body">
            <div class="info-row">
                <span class="info-label"><i class="fas fa-envelope"></i> Correo:</span>
                <span class="info-val"><?= htmlspecialchars($b['correo']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-phone"></i> Tel:</span>
                <span class="info-val"><?= htmlspecialchars($b['telefono'] ?: 'N/D') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-star"></i> Exp:</span>
                <span class="info-val"><?= htmlspecialchars($b['anios_experiencia']) ?> años</span>
            </div>
        </div>
        <div class="card-footer">
            <a href="#" class="btn-sm-outline"><i class="fas fa-calendar-alt"></i> Agenda</a>
            <a href="#" class="btn-sm-outline"><i class="fas fa-edit"></i> Editar</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php if (empty($barberos)): ?>
<div style="background:var(--card); border:1px solid var(--border); padding:60px; text-align:center; border-radius:16px; color:var(--muted);">
    <i class="fas fa-users" style="font-size:3rem; margin-bottom:16px; opacity:0.5;"></i>
    <h3>Sin Personal</h3>
    <p>Aún no has registrado a ningún barbero en tu empresa.</p>
</div>
<?php endif; ?>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
