<div style="background:var(--card); border:1px solid var(--border); border-radius:16px; padding:24px;">
    <h3 style="color:var(--gold); margin-bottom:16px;">Directorio de Clientes</h3>
    <?php if(isset($_GET['msg']) && $_GET['msg']=='actualizado'): ?>
        <p style="color:#34D399; margin-bottom:16px;">Cliente actualizado correctamente.</p>
    <?php endif; ?>
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead>
            <tr style="border-bottom:1px solid var(--border); color:var(--muted); font-size:0.85rem;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Nombre</th>
                <th style="padding:12px;">Correo</th>
                <th style="padding:12px;">Teléfono</th>
                <th style="padding:12px;">Estado</th>
                <th style="padding:12px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
            <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                <td style="padding:12px;"><?= $c['id'] ?></td>
                <td style="padding:12px;"><strong><?= htmlspecialchars($c['nombre']) ?></strong></td>
                <td style="padding:12px; color:var(--muted);"><?= htmlspecialchars($c['correo']) ?></td>
                <td style="padding:12px;"><?= htmlspecialchars($c['telefono']) ?></td>
                <td style="padding:12px; color:<?= $c['estado']=='Activo'?'#34D399':'#FCA5A5' ?>;"><?= $c['estado'] ?></td>
                <td style="padding:12px;">
                    <a href="<?= BASE_URL ?>/dashboard/editar_cliente/<?= $c['id'] ?>" style="color:var(--gold); text-decoration:none;"><i class="fas fa-edit"></i> Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
