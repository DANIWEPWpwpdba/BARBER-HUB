<?php ob_start(); ?>
<style>
    .header-actions { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
    .btn-primary { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:10px 20px; border-radius:10px; font-weight:700; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:0.9rem; }
    
    .table-container { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:16px 24px; text-align:left; font-size:0.9rem; }
    th { background:rgba(255,255,255,0.02); color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:1px; font-size:0.75rem; border-bottom:1px solid var(--border); }
    td { border-bottom:1px solid var(--border); color:#C8C8D8; }
    tr:last-child td { border-bottom:none; }
    tr:hover { background:rgba(255,255,255,0.02); }
    
    .badge-active { background:rgba(52,211,153,0.15); color:#6EE7B7; padding:4px 10px; border-radius:50px; font-size:0.75rem; font-weight:600; border:1px solid rgba(52,211,153,0.3); }
    .badge-inactive { background:rgba(239,68,68,0.15); color:#FCA5A5; padding:4px 10px; border-radius:50px; font-size:0.75rem; font-weight:600; border:1px solid rgba(239,68,68,0.3); }

    /* Modal */
    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:1000; display:none; align-items:center; justify-content:center; backdrop-filter:blur(5px); }
    .modal { background:var(--card); border:1px solid var(--border); border-radius:16px; width:100%; max-width:500px; padding:30px; box-shadow:0 25px 50px rgba(0,0,0,0.5); }
    .modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
    .modal-header h3 { font-size:1.3rem; margin:0; color:var(--white); }
    .close-btn { background:none; border:none; color:var(--muted); font-size:1.2rem; cursor:pointer; }
    .close-btn:hover { color:var(--white); }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:0.85rem; color:#B0B0C0; margin-bottom:8px; font-weight:600; }
    .form-group input, .form-group select { width:100%; padding:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:white; font-family:'Inter',sans-serif; }
    .form-group input:focus, .form-group select:focus { outline:none; border-color:var(--gold); }
</style>

<div class="header-actions">
    <div>
        <p style="color:var(--muted); font-size:0.9rem;">Gestiona los puntos físicos de tu negocio.</p>
    </div>
    <button class="btn-primary" onclick="document.getElementById('modalSucursal').style.display='flex'">
        <i class="fas fa-plus"></i> Nueva Sucursal
    </button>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'creada'): ?>
<div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#6EE7B7; padding:12px 16px; border-radius:10px; margin-bottom:24px;">
    <i class="fas fa-check-circle"></i> Sucursal creada exitosamente.
</div>
<?php endif; ?>

<div class="table-container">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Nombre Sucursal</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Micrositio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sucursales as $s): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($s['nombre_comercial']) ?></strong></td>
                    <td><?= htmlspecialchars($s['telefono']) ?></td>
                    <td><?= htmlspecialchars($s['calle'] ?? 'No registrada') ?></td>
                    <td><a href="#" style="color:var(--gold);"><i class="fas fa-link"></i> Ver Micrositio</a></td>
                    <td>
                        <span class="badge-active">Activa</span>
                    </td>
                    <td>
                        <button style="background:transparent;border:none;color:var(--gold);cursor:pointer;"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($sucursales)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:var(--muted);">No hay sucursales registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Nueva Sucursal -->
<div class="modal-overlay" id="modalSucursal">
    <div class="modal">
        <div class="modal-header">
            <h3>Registrar Sucursal</h3>
            <button class="close-btn" onclick="document.getElementById('modalSucursal').style.display='none'"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>/dashboard/crear_sucursal">
            <div class="form-group">
                <label>Nombre de la Sucursal</label>
                <input type="text" name="nombre" required placeholder="Ej. Barber Hub Centro">
            </div>
            <div class="form-group">
                <label>Descripción Corta (Para el micrositio)</label>
                <input type="text" name="descripcion" placeholder="Ej. Nuestra sucursal matriz...">
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" required placeholder="10 dígitos">
            </div>
            <div class="form-group">
                <label>Municipio (Puebla)</label>
                <select name="municipio" required>
                    <option value="Puebla">Puebla (Capital)</option>
                    <option value="San Andrés Cholula">San Andrés Cholula</option>
                    <option value="San Pedro Cholula">San Pedro Cholula</option>
                    <option value="Cuautlancingo">Cuautlancingo</option>
                    <option value="Amozoc">Amozoc</option>
                    <option value="Atlixco">Atlixco</option>
                </select>
            </div>
            <div class="form-group">
                <label>Dirección Completa (Calle y Colonia)</label>
                <input type="text" name="direccion" required placeholder="Calle, Número, Colonia">
            </div>
            <div class="form-group">
                <label>Enlace a Google Maps (URL corta o completa)</label>
                <input type="url" name="url_maps" placeholder="https://maps.app.goo.gl/..." style="border-color: rgba(96,165,250,0.5);">
            </div>
            <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">Guardar Sucursal</button>
        </form>
    </div>
</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
