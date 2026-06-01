<div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:24px;">
    <div>
        <p style="color:var(--gold); font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Catálogo</p>
        <h2 style="font-size:1.8rem; font-weight:800; color:var(--white);">Servicios Ofrecidos</h2>
    </div>
    <button onclick="document.getElementById('modalServicio').style.display='flex'" style="background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:10px 20px; border-radius:8px; font-weight:700; cursor:pointer;"><i class="fas fa-plus"></i> Nuevo Servicio</button>
</div>

<div style="background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead>
            <tr style="border-bottom:1px solid var(--border); color:var(--muted); font-size:0.85rem; background:rgba(255,255,255,0.02);">
                <th style="padding:16px;">Servicio</th>
                <th style="padding:16px;">Sucursal (Barbería)</th>
                <th style="padding:16px;">Duración</th>
                <th style="padding:16px;">Precio</th>
                <th style="padding:16px;">Estado</th>
                <th style="padding:16px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicios as $s): ?>
            <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                <td style="padding:16px;">
                    <strong style="color:var(--white); font-size:1rem;"><?= htmlspecialchars($s['nombre']) ?></strong>
                    <div style="font-size:0.8rem; color:var(--muted); margin-top:4px; max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($s['descripcion']) ?></div>
                </td>
                <td style="padding:16px;"><?= htmlspecialchars($s['barberia_nombre']) ?></td>
                <td style="padding:16px; color:#93C5FD;"><i class="fas fa-clock" style="margin-right:4px;"></i> <?= $s['duracion_minutos'] ?> min</td>
                <td style="padding:16px; font-weight:700; color:#34D399;">$<?= number_format($s['precio'], 2) ?></td>
                <td style="padding:16px;">
                    <?php if($s['estado'] == 'Activo'): ?>
                        <span style="color:#34D399; font-weight:600; font-size:0.85rem;"><i class="fas fa-check-circle"></i> Activo</span>
                    <?php else: ?>
                        <span style="color:var(--muted); font-weight:600; font-size:0.85rem;"><i class="fas fa-times-circle"></i> Inactivo</span>
                    <?php endif; ?>
                </td>
                <td style="padding:16px;">
                    <a href="<?= BASE_URL ?>/dashboard/toggle_servicio/<?= $s['id'] ?>" style="color:<?= $s['estado']=='Activo'?'#FCA5A5':'#34D399' ?>; text-decoration:none; font-size:0.9rem;">
                        <i class="fas <?= $s['estado']=='Activo'?'fa-eye-slash':'fa-eye' ?>"></i> <?= $s['estado']=='Activo'?'Desactivar':'Activar' ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($servicios)): ?>
            <tr><td colspan="6" style="padding:30px; text-align:center; color:var(--muted);">No hay servicios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Nuevo Servicio -->
<div id="modalServicio" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); backdrop-filter:blur(5px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:var(--card); border:1px solid var(--border); border-radius:16px; width:100%; max-width:500px; padding:30px; position:relative;">
        <button onclick="document.getElementById('modalServicio').style.display='none'" style="position:absolute; right:20px; top:20px; background:none; border:none; color:var(--muted); font-size:1.2rem; cursor:pointer;"><i class="fas fa-times"></i></button>
        <h3 style="color:var(--gold); margin-bottom:20px;">Agregar Nuevo Servicio</h3>
        <form method="POST" action="<?= BASE_URL ?>/dashboard/crear_servicio">
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:6px; color:var(--muted); font-size:0.85rem;">Sucursal</label>
                <select name="barberia_id" required style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
                    <?php foreach ($barberias as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nombre_comercial']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:6px; color:var(--muted); font-size:0.85rem;">Nombre del Servicio</label>
                <input type="text" name="nombre" required placeholder="Ej. Corte de Cabello Clásico" style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:6px; color:var(--muted); font-size:0.85rem;">Descripción Breve</label>
                <textarea name="descripcion" rows="2" placeholder="Incluye lavado, corte con tijera y máquina..." style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;"></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--muted); font-size:0.85rem;">Duración (Minutos)</label>
                    <input type="number" name="duracion_minutos" required min="5" step="5" value="30" style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--muted); font-size:0.85rem;">Precio (MXN)</label>
                    <input type="number" name="precio" required min="0" step="1" placeholder="Ej. 150" style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
                </div>
            </div>
            <button type="submit" style="width:100%; padding:12px; background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; border-radius:8px; font-weight:700; cursor:pointer;">Guardar Servicio</button>
        </form>
    </div>
</div>
