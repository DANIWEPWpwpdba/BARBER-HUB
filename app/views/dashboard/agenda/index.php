<div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
    <div>
        <p style="color:var(--gold); font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Gestión Diaria</p>
        <h2 style="font-size:1.8rem; font-weight:800; color:var(--white);">Agenda de Citas</h2>
    </div>
    
    <form method="GET" action="<?= BASE_URL ?>/dashboard/agenda" style="display:flex; gap:12px; align-items:center;">
        <?php if($_SESSION['rol_id'] <= 4): ?>
        <select name="barberia_id" style="padding:10px; background:var(--card); border:1px solid var(--border); border-radius:8px; color:var(--white); font-family:inherit;">
            <?php foreach($barberias as $b): ?>
                <option value="<?= $b['id'] ?>" <?= (isset($_GET['barberia_id']) && $_GET['barberia_id'] == $b['id']) ? 'selected' : '' ?>><?= htmlspecialchars($b['nombre_comercial']) ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
        
        <input type="date" name="fecha" value="<?= htmlspecialchars($fecha_actual) ?>" style="padding:10px; background:var(--card); border:1px solid var(--border); border-radius:8px; color:var(--white); font-family:inherit;">
        
        <button type="submit" style="padding:10px 16px; background:var(--gold); border:none; border-radius:8px; font-weight:700; cursor:pointer;"><i class="fas fa-search"></i> Buscar</button>
    </form>
</div>

<div style="background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead>
            <tr style="border-bottom:1px solid var(--border); color:var(--muted); font-size:0.85rem; background:rgba(255,255,255,0.02);">
                <th style="padding:16px;">Hora</th>
                <th style="padding:16px;">Cliente</th>
                <th style="padding:16px;">Servicio</th>
                <?php if($_SESSION['rol_id'] != 5): ?>
                <th style="padding:16px;">Barbero</th>
                <?php endif; ?>
                <th style="padding:16px;">Código</th>
                <th style="padding:16px;">Estado</th>
                <th style="padding:16px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $c): ?>
            <?php 
                $color_estado = '#34D399'; // Confirmada
                if($c['estado'] == 'Cancelada' || $c['estado'] == 'No asistio') $color_estado = '#FCA5A5';
                if($c['estado'] == 'Finalizada') $color_estado = '#60A5FA';
            ?>
            <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                <td style="padding:16px; font-weight:700; font-size:1.1rem; color:var(--gold);">
                    <?= date('H:i', strtotime($c['hora'])) ?>
                </td>
                <td style="padding:16px;"><strong><?= htmlspecialchars($c['cliente_nombre']) ?></strong></td>
                <td style="padding:16px;">
                    <?= htmlspecialchars($c['servicio_nombre']) ?>
                    <div style="font-size:0.8rem; color:var(--muted);"><i class="fas fa-clock"></i> <?= $c['duracion_minutos'] ?> min</div>
                </td>
                <?php if($_SESSION['rol_id'] != 5): ?>
                <td style="padding:16px; color:var(--muted);"><?= htmlspecialchars($c['barbero_nombre']) ?></td>
                <?php endif; ?>
                <td style="padding:16px;"><span style="background:rgba(255,255,255,0.05); padding:4px 8px; border-radius:4px; font-family:monospace;"><?= $c['codigo_unico'] ?></span></td>
                <td style="padding:16px; color:<?= $color_estado ?>; font-weight:600; font-size:0.85rem;">
                    <?= $c['estado'] ?>
                </td>
                <td style="padding:16px;">
                    <?php if($c['estado'] == 'Confirmada'): ?>
                        <div style="display:flex; gap:8px;">
                            <a href="<?= BASE_URL ?>/finanzas/cobrar_cita/<?= $c['id'] ?>" title="Cobrar Cita" style="color:#10B981; font-size:1.2rem;"><i class="fas fa-cash-register"></i></a>
                            <a href="<?= BASE_URL ?>/dashboard/estado_cita/<?= $c['id'] ?>/Cancelada" title="Cancelar Cita" style="color:#FCA5A5; font-size:1.2rem;"><i class="fas fa-times-circle"></i></a>
                            <a href="<?= BASE_URL ?>/dashboard/estado_cita/<?= $c['id'] ?>/No asistio" title="No Asistió" style="color:var(--muted); font-size:1.2rem;"><i class="fas fa-user-alt-slash"></i></a>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($citas)): ?>
            <tr><td colspan="7" style="padding:40px; text-align:center; color:var(--muted);">No hay citas programadas para esta fecha.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
