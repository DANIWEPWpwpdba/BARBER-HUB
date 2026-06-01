<?php ob_start(); ?>
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 30px; }
    .kpi-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; position: relative; overflow: hidden; text-align: center; }
    .kpi-card h4 { font-size: 0.9rem; color: var(--muted); margin-bottom: 10px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
    .kpi-val { font-size: 2.5rem; font-family: 'Outfit', sans-serif; font-weight: 800; color: var(--white); }
    .kpi-val.green { color: #34D399; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-hand-holding-usd" style="color:#34D399;"></i> Mis Comisiones</h2>
    <div>
        <a href="<?= BASE_URL ?>/dashboard/agenda" class="btn-primary" style="text-decoration:none; display:inline-block;"><i class="fas fa-calendar"></i> Ir a Agenda</a>
    </div>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'cobrado'): ?>
    <div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#34D399; padding:12px; border-radius:8px; margin-bottom:24px;">
        <i class="fas fa-check-circle"></i> Cita cobrada correctamente. Tu comisión se ha actualizado.
    </div>
<?php endif; ?>

<p style="color:var(--muted); margin-bottom:30px;">
    Este es tu reporte personal de la semana actual. Al cobrar citas desde tu agenda, tu saldo aumentará automáticamente.
</p>

<div class="kpi-grid">
    <div class="kpi-card">
        <h4>Servicios Finalizados</h4>
        <div class="kpi-val"><?= $mi_comision['total_servicios'] ?></div>
    </div>
    
    <div class="kpi-card">
        <h4>Total Cobrado</h4>
        <div class="kpi-val" style="font-size:1.5rem; margin-top:15px;">$<?= number_format($mi_comision['total_generado'], 2) ?></div>
    </div>

    <div class="kpi-card">
        <h4>Tu Porcentaje</h4>
        <div class="kpi-val" style="color:var(--gold); font-size:2rem; margin-top:5px;"><?= floatval($mi_comision['porcentaje_comision']) ?>%</div>
    </div>
    
    <div class="kpi-card" style="border-color:rgba(52,211,153,0.5); background:rgba(52,211,153,0.05);">
        <h4 style="color:#34D399;">Comisión a Recibir</h4>
        <div class="kpi-val green">$<?= number_format($mi_comision['total_comision'], 2) ?></div>
    </div>
</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
