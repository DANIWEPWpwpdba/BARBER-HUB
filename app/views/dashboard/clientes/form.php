<div style="max-width: 600px; background:var(--card); border:1px solid var(--border); border-radius:16px; padding:30px;">
    <h3 style="color:var(--gold); margin-bottom:20px;">Editar Datos del Cliente</h3>
    <form method="POST">
        <div style="margin-bottom:16px;">
            <label style="display:block; margin-bottom:8px; color:var(--muted); font-size:0.9rem;">Nombre Completo</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:block; margin-bottom:8px; color:var(--muted); font-size:0.9rem;">Teléfono</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:block; margin-bottom:8px; color:var(--muted); font-size:0.9rem;">Estado</label>
            <select name="estado" style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
                <option value="Activo" <?= $cliente['estado']=='Activo'?'selected':'' ?>>Activo</option>
                <option value="Inactivo" <?= $cliente['estado']=='Inactivo'?'selected':'' ?>>Inactivo</option>
                <option value="Suspendido" <?= $cliente['estado']=='Suspendido'?'selected':'' ?>>Suspendido</option>
            </select>
        </div>
        <div style="margin-bottom:24px; padding:16px; border:1px dashed var(--border); border-radius:8px; background:rgba(255,255,255,0.02);">
            <label style="display:block; margin-bottom:8px; color:var(--muted); font-size:0.9rem;">Nueva Contraseña (Opcional)</label>
            <input type="password" name="password" placeholder="Dejar en blanco para no cambiar" style="width:100%; padding:10px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff;">
            <small style="color:var(--muted); display:block; margin-top:6px;">Si escribes aquí, sobreescribirás la contraseña del cliente.</small>
        </div>
        <div style="display:flex; gap:12px;">
            <button type="submit" style="flex:1; padding:12px; border-radius:8px; background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; font-weight:700; border:none; cursor:pointer;">Guardar Cambios</button>
            <a href="<?= BASE_URL ?>/dashboard/clientes" style="padding:12px 24px; border-radius:8px; border:1px solid var(--border); color:#fff; text-decoration:none; text-align:center;">Cancelar</a>
        </div>
    </form>
</div>
