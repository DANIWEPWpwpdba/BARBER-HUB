<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shield-alt" style="color:#F87171;"></i> Auditoría del Sistema</h2>
</div>

<p style="color:var(--muted); margin-bottom:30px;">
    Esta es la bitácora de seguridad inmutable. Aquí se registran todas las acciones importantes realizadas por los administradores y usuarios del sistema (Cobros, cambios, accesos, etc.).
</p>

<div class="card" style="padding:0; overflow:hidden;">
    <div class="table-responsive">
        <table class="table" style="margin:0;">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acción</th>
                    <th>Resultado</th>
                    <th>Dirección IP</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($historial)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:var(--muted);">No hay registros de auditoría.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($historial as $h): ?>
                    <tr>
                        <td style="color:var(--muted);"><i class="fas fa-clock"></i> <?= date('d/m/Y H:i:s', strtotime($h['fecha'])) ?></td>
                        <td style="font-weight:600;"><?= htmlspecialchars($h['nombre'] ?? 'Sistema') ?></td>
                        <td>
                            <?php if ($h['rol']): ?>
                                <span style="background:rgba(255,255,255,0.05); padding:4px 8px; border-radius:6px; font-size:0.85em;"><?= htmlspecialchars($h['rol']) ?></span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($h['accion']) ?></td>
                        <td>
                            <?php if ($h['resultado'] == 'Exito'): ?>
                                <span style="color:#34D399;"><i class="fas fa-check-circle"></i> Éxito</span>
                            <?php else: ?>
                                <span style="color:#F87171;"><i class="fas fa-times-circle"></i> <?= htmlspecialchars($h['resultado']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--muted); font-family:monospace;"><?= htmlspecialchars($h['direccion_ip']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
