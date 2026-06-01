<?php ob_start(); ?>
<style>
    .form-container { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:32px; max-width:800px; margin:0 auto; }
    .form-header { margin-bottom:32px; padding-bottom:16px; border-bottom:1px solid var(--border); }
    .form-header h3 { font-size:1.3rem; color:var(--white); margin-bottom:8px; }
    .form-header p { font-size:0.9rem; color:var(--muted); }
    
    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
    .form-group { margin-bottom:20px; }
    .form-group label { display:block; font-size:0.85rem; color:#B0B0C0; margin-bottom:8px; font-weight:600; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:14px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:white; font-family:'Inter',sans-serif; transition:all 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline:none; border-color:var(--gold); background:rgba(255,255,255,0.05); }
    
    .btn-submit { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; border:none; padding:14px 28px; border-radius:10px; font-weight:700; cursor:pointer; font-size:1rem; display:inline-flex; align-items:center; gap:8px; }
    
    .info-box { background:rgba(96,165,250,0.1); border:1px solid rgba(96,165,250,0.2); padding:16px; border-radius:10px; color:#93C5FD; font-size:0.85rem; margin-bottom:24px; display:flex; gap:12px; }
    .info-box i { font-size:1.2rem; margin-top:2px; }
</style>

<div class="form-container">
    <div class="form-header">
        <h3>Registrar Nuevo Barbero</h3>
        <p>Completa la información del empleado. El sistema le creará automáticamente su acceso.</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5; padding:14px; border-radius:10px; margin-bottom:24px;">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
    </div>
    <?php endif; ?>

    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <div>
            <strong>Seguridad Corporativa:</strong> Al guardar, el sistema le creará una cuenta de usuario con el rol de Barbero y la contraseña temporal: <code>Hub2026</code>. Entrégale estas credenciales al empleado para su primer acceso.
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/dashboard/crear_barbero">
        <h4 style="color:var(--gold); margin-bottom:16px; font-size:1rem;">1. Datos Personales y Acceso</h4>
        <div class="grid-2">
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" required placeholder="Ej. Carlos Gómez">
            </div>
            <div class="form-group">
                <label>Correo Electrónico (Para iniciar sesión)</label>
                <input type="email" name="correo" required placeholder="carlos@barberhub.mx">
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" required placeholder="10 dígitos">
            </div>
        </div>

        <h4 style="color:var(--gold); margin:bottom:16px; margin-top:16px; font-size:1rem;">2. Asignación y Perfil</h4>
        <div class="grid-2">
            <div class="form-group">
                <label>Sucursal Asignada</label>
                <select name="barberia_id" required>
                    <option value="">-- Selecciona una Sucursal --</option>
                    <?php foreach ($barberias as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nombre_comercial']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Años de Experiencia</label>
                <input type="number" name="anios_experiencia" min="0" max="50" required placeholder="Ej. 3">
            </div>
        </div>
        <div class="form-group">
            <label>Biografía Breve</label>
            <textarea name="biografia" rows="3" placeholder="Especialista en cortes clásicos, desvanecidos..."></textarea>
        </div>

        <div style="text-align:right; margin-top:24px;">
            <a href="<?= BASE_URL ?>/dashboard/barberos" style="color:var(--muted); text-decoration:none; margin-right:20px; font-size:0.9rem;">Cancelar</a>
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Registrar Barbero</button>
        </div>
    </form>
</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
