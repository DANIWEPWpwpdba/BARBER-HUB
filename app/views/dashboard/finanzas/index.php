<?php ob_start(); ?>
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 30px; }
    .kpi-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; position: relative; overflow: hidden; }
    .kpi-card h4 { font-size: 0.9rem; color: var(--muted); margin-bottom: 10px; font-weight: 500; }
    .kpi-val { font-size: 2.2rem; font-family: 'Outfit', sans-serif; font-weight: 800; color: var(--white); }
    .kpi-icon { position: absolute; right: 20px; top: 30px; font-size: 3rem; opacity: 0.05; color: var(--gold); }
    
    .table-container { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 30px; overflow-x: auto; }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .table-header h3 { font-size: 1.2rem; margin: 0; }
    
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 12px 16px; font-size: 0.85rem; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 1px; }
    td { padding: 16px; font-size: 0.95rem; border-bottom: 1px solid rgba(255,255,255,0.03); }
    tr:hover td { background: rgba(255,255,255,0.02); }
    
    .badge-metodo { padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
    .met-efectivo { background: rgba(52,211,153,0.1); color: #34D399; border: 1px solid rgba(52,211,153,0.2); }
    .met-tarjeta { background: rgba(96,165,250,0.1); color: #60A5FA; border: 1px solid rgba(96,165,250,0.2); }
    .met-transferencia { background: rgba(167,139,250,0.1); color: #A78BFA; border: 1px solid rgba(167,139,250,0.2); }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-wallet" style="color:var(--gold);"></i> Resumen Financiero</h2>
    <div>
        <a href="<?= BASE_URL ?>/finanzas/comisiones" class="btn-primary" style="text-decoration:none; display:inline-block;">Ver Comisiones</a>
    </div>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'cobrado'): ?>
    <div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#34D399; padding:12px; border-radius:8px; margin-bottom:24px;">
        <i class="fas fa-check-circle"></i> Cita cobrada y finalizada correctamente.
    </div>
<?php endif; ?>

<div class="kpi-grid">
    <div class="kpi-card">
        <h4>Ingresos del Mes</h4>
        <div class="kpi-val">$<?= number_format($total_mes, 2) ?></div>
        <i class="fas fa-dollar-sign kpi-icon"></i>
    </div>
    
    <?php foreach($ingresos as $i): ?>
    <div class="kpi-card">
        <h4>Por <?= htmlspecialchars($i['metodo']) ?></h4>
        <div class="kpi-val" style="font-size:1.8rem;">$<?= number_format($i['total_ingresos'], 2) ?></div>
        <div style="font-size:0.85rem; color:var(--muted); margin-top:5px;"><?= $i['total_operaciones'] ?> pagos</div>
    </div>
    <?php endforeach; ?>
</div>

<div class="table-container">
    <div class="table-header">
        <h3>Últimos Pagos Recibidos</h3>
    </div>
    
    <?php if(empty($historial)): ?>
        <p style="color:var(--muted);">No hay registros de pagos recientes.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cita</th>
                    <th>Cliente</th>
                    <th>Servicio / Barbero</th>
                    <th>Método</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($historial as $p): ?>
                <tr>
                    <td><?= date('d M Y, H:i', strtotime($p['fecha_pago'])) ?></td>
                    <td><span style="font-family:monospace; color:var(--gold);">#<?= htmlspecialchars($p['codigo_unico']) ?></span></td>
                    <td><?= htmlspecialchars($p['cliente']) ?></td>
                    <td>
                        <?= htmlspecialchars($p['servicio']) ?><br>
                        <small style="color:var(--muted);"><i class="fas fa-cut"></i> <?= htmlspecialchars($p['barbero']) ?></small>
                    </td>
                    <td>
                        <?php 
                            $class = 'met-efectivo';
                            if (strpos($p['metodo'], 'Tarjeta') !== false) $class = 'met-tarjeta';
                            if ($p['metodo'] == 'Transferencia Bancaria') $class = 'met-transferencia';
                        ?>
                        <span class="badge-metodo <?= $class ?>"><?= htmlspecialchars($p['metodo']) ?></span>
                    </td>
                    <td style="font-weight:700;">$<?= number_format($p['monto'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
