<?php ob_start(); ?>
<style>
    .table-container { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 30px; overflow-x: auto; }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .table-header h3 { font-size: 1.2rem; margin: 0; }
    
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 12px 16px; font-size: 0.85rem; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 1px; }
    td { padding: 16px; font-size: 0.95rem; border-bottom: 1px solid rgba(255,255,255,0.03); }
    tr:hover td { background: rgba(255,255,255,0.02); }
    
    .badge-percent { padding: 4px 10px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; background: rgba(226,176,74,0.1); color: var(--gold); border: 1px solid rgba(226,176,74,0.3); }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-percentage" style="color:var(--gold);"></i> Pago de Comisiones</h2>
    <div>
        <a href="<?= BASE_URL ?>/finanzas/index" class="btn-primary" style="text-decoration:none; display:inline-block; background:rgba(255,255,255,0.05); color:var(--white);">Volver a Finanzas</a>
    </div>
</div>

<p style="color:var(--muted); margin-bottom:20px;">
    Esta tabla muestra el cálculo automático de comisiones basado en los <strong>servicios cobrados (Finalizados)</strong> durante la semana actual.
</p>

<div class="table-container">
    <div class="table-header">
        <h3>Reporte Semanal por Barbero</h3>
    </div>
    
    <?php if(empty($comisiones)): ?>
        <p style="color:var(--muted);">No hay comisiones generadas esta semana aún.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Barbero</th>
                    <th>Servicios Realizados</th>
                    <th>Total Generado (Ventas)</th>
                    <th>Acuerdo (%)</th>
                    <th>Comisión a Pagar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_pagar = 0;
                foreach($comisiones as $c): 
                    $total_pagar += $c['total_comision'];
                ?>
                <tr>
                    <td><i class="fas fa-user-tie me-2" style="color:var(--muted);"></i> <strong style="color:var(--white);"><?= htmlspecialchars($c['barbero_nombre']) ?></strong></td>
                    <td><?= $c['total_servicios'] ?> cortes</td>
                    <td>$<?= number_format($c['total_generado'], 2) ?></td>
                    <td><span class="badge-percent"><?= floatval($c['porcentaje_comision']) ?>%</span></td>
                    <td style="font-weight:800; font-size:1.1rem; color:#34D399;">$<?= number_format($c['total_comision'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right; font-weight:600; color:var(--muted);">TOTAL A PAGAR ESTA SEMANA:</td>
                    <td style="font-weight:800; font-size:1.2rem; color:var(--gold); border-top:2px solid var(--border);">$<?= number_format($total_pagar, 2) ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
