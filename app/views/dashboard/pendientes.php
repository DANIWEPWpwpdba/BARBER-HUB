<?php ob_start(); ?>
<style>
    .table-container { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
    .table-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .table-header h3 { font-size:1.1rem; color:var(--white); font-weight:700; margin:0; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:16px 24px; text-align:left; font-size:0.9rem; }
    th { background:rgba(255,255,255,0.02); color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:1px; font-size:0.75rem; border-bottom:1px solid var(--border); }
    td { border-bottom:1px solid var(--border); color:#C8C8D8; }
    tr:last-child td { border-bottom:none; }
    tr:hover { background:rgba(255,255,255,0.02); }
    
    .badge-pending { background:rgba(245,158,11,0.15); color:#FCD34D; padding:4px 10px; border-radius:50px; font-size:0.75rem; font-weight:600; border:1px solid rgba(245,158,11,0.3); }
    
    .action-btns { display:flex; gap:8px; }
    .btn-sm { padding:6px 12px; border-radius:6px; font-size:0.8rem; font-weight:600; cursor:pointer; border:none; display:inline-flex; align-items:center; gap:6px; text-decoration:none; transition:all 0.2s; }
    .btn-approve { background:rgba(52,211,153,0.15); color:#6EE7B7; border:1px solid rgba(52,211,153,0.3); }
    .btn-approve:hover { background:rgba(52,211,153,0.25); }
    .btn-pwd { background:rgba(96,165,250,0.15); color:#93C5FD; border:1px solid rgba(96,165,250,0.3); }
    .btn-pwd:hover { background:rgba(96,165,250,0.25); }

    /* Modal simple */
    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:1000; display:none; align-items:center; justify-content:center; backdrop-filter:blur(5px); }
    .modal { background:var(--card); border:1px solid var(--border); border-radius:16px; width:100%; max-width:400px; padding:24px; box-shadow:0 25px 50px rgba(0,0,0,0.5); }
    .modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .modal-header h3 { font-size:1.2rem; margin:0; color:var(--white); }
    .close-btn { background:none; border:none; color:var(--muted); font-size:1.2rem; cursor:pointer; }
    .close-btn:hover { color:var(--white); }
    .form-group { margin-bottom:16px; }
    .form-group label { display:block; font-size:0.85rem; color:#B0B0C0; margin-bottom:8px; }
    .form-group input { width:100%; padding:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:white; font-family:'Inter',sans-serif; }
    .form-group input:focus { outline:none; border-color:var(--gold); }
    .btn-submit { width:100%; background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:12px; border-radius:8px; font-weight:700; cursor:pointer; }
</style>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'aprobado'): ?>
<div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#6EE7B7; padding:12px 16px; border-radius:10px; margin-bottom:24px;">
    <i class="fas fa-check-circle"></i> Usuario aprobado exitosamente.
</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'pwd_changed'): ?>
<div style="background:rgba(96,165,250,0.1); border:1px solid rgba(96,165,250,0.3); color:#93C5FD; padding:12px 16px; border-radius:10px; margin-bottom:24px;">
    <i class="fas fa-check-circle"></i> Contraseña actualizada correctamente.
</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'pwd_short'): ?>
<div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5; padding:12px 16px; border-radius:10px; margin-bottom:24px;">
    <i class="fas fa-exclamation-triangle"></i> La contraseña debe tener al menos 6 caracteres.
</div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header">
        <h3>Clientes Pendientes de Aprobación</h3>
        <span style="font-size:0.85rem;color:var(--muted);"><?= count($pendientes) ?> registros</span>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Fecha Registro</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendientes as $p): ?>
                <tr>
                    <td>#<?= $p['id'] ?></td>
                    <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                    <td><?= htmlspecialchars($p['correo']) ?></td>
                    <td><?= htmlspecialchars($p['telefono']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($p['fecha_registro'])) ?></td>
                    <td><span class="badge-pending">Pendiente</span></td>
                    <td>
                        <div class="action-btns">
                            <a href="<?= BASE_URL ?>/dashboard/aprobar_usuario/<?= $p['id'] ?>" class="btn-sm btn-approve" onclick="return confirm('¿Aprobar a este cliente?')">
                                <i class="fas fa-check"></i> Aprobar
                            </a>
                            <button class="btn-sm btn-pwd" onclick="openPwdModal(<?= $p['id'] ?>, '<?= htmlspecialchars($p['nombre']) ?>')">
                                <i class="fas fa-key"></i> Pass
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($pendientes)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:var(--muted);">
                        No hay clientes pendientes de aprobación.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Cambiar Password -->
<div class="modal-overlay" id="pwdModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Cambiar Contraseña</h3>
            <button class="close-btn" onclick="closePwdModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="pwdForm" method="POST" action="">
            <p style="font-size:0.85rem; color:var(--muted); margin-bottom:16px;">
                Cambiando contraseña para: <strong id="pwdUserName" style="color:var(--white);"></strong>
            </p>
            <div class="form-group">
                <label>Nueva Contraseña</label>
                <input type="password" name="nueva_password" required minlength="6" placeholder="Mínimo 6 caracteres">
            </div>
            <button type="submit" class="btn-submit">Guardar Contraseña</button>
        </form>
    </div>
</div>

<script>
    function openPwdModal(id, nombre) {
        document.getElementById('pwdUserName').innerText = nombre;
        document.getElementById('pwdForm').action = '<?= BASE_URL ?>/dashboard/cambiar_password/' + id;
        document.getElementById('pwdModal').style.display = 'flex';
    }
    function closePwdModal() {
        document.getElementById('pwdModal').style.display = 'none';
    }
</script>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
