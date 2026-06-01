<?php
// Envolvemos el contenido en una variable para pasarlo al layout
ob_start();
?>
<style>
    .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:24px; margin-bottom:40px; }
    .stat-card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:24px; display:flex; align-items:center; gap:20px; transition:all 0.2s; }
    .stat-card:hover { transform:translateY(-3px); border-color:rgba(226,176,74,0.3); }
    .stat-icon { width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.6rem; }
    .stat-gold { background:rgba(226,176,74,0.1); color:var(--gold); }
    .stat-green { background:rgba(52,211,153,0.1); color:#34D399; }
    .stat-blue { background:rgba(96,165,250,0.1); color:#60A5FA; }
    .stat-purple { background:rgba(167,139,250,0.1); color:#A78BFA; }
    .stat-info h3 { font-size:1.8rem; font-weight:800; color:var(--white); line-height:1; margin-bottom:4px; }
    .stat-info p { font-size:0.85rem; color:var(--muted); font-weight:500; }
    
    .welcome-banner { background:linear-gradient(135deg,rgba(226,176,74,0.15),transparent); border:1px solid rgba(226,176,74,0.3); border-radius:16px; padding:32px; margin-bottom:40px; position:relative; overflow:hidden; }
    .welcome-banner h2 { font-size:1.6rem; color:var(--gold); margin-bottom:8px; }
    .welcome-banner p { color:#C8C8D8; font-size:0.95rem; max-width:600px; line-height:1.6; }
</style>

<div class="welcome-banner">
    <h2>¡Hola, <?= htmlspecialchars($_SESSION['nombre']) ?>!</h2>
    <p>Bienvenido al Panel de Administración de Barber Hub. Desde aquí podrás gestionar las citas, aprobar clientes, revisar estadísticas y controlar el inventario de tu sucursal.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon stat-gold"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-info">
            <h3>0</h3>
            <p>Citas Hoy</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-green"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-info">
            <h3>$0.00</h3>
            <p>Ingresos del Día</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-blue"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <h3>0</h3>
            <p>Nuevos Clientes</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-purple"><i class="fas fa-box-open"></i></div>
        <div class="stat-info">
            <h3>0</h3>
            <p>Alertas Stock</p>
        </div>
    </div>
</div>

<?php
$vista_hija = __FILE__;
$contenido_html = ob_get_clean();
// Si se llama directo, lo mostramos (hack para no reescribir el render de Controller base)
echo $contenido_html;
?>
