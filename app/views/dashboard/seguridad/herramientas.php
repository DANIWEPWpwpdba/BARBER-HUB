<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tools" style="color:#60A5FA;"></i> Herramientas y Backups</h2>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'demo_cargada'): ?>
<div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#34D399; padding:12px; border-radius:8px; margin-bottom:20px;">
    <i class="fas fa-check-circle"></i> ¡Demo Masiva cargada exitosamente! Se han generado sucursales, barberos, clientes y citas aleatorias.
</div>
<?php endif; ?>

<p style="color:var(--muted); margin-bottom:30px;">
    Utilidades avanzadas del sistema.
</p>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    
    <div class="card" style="text-align:center;">
        <i class="fas fa-database" style="font-size:3rem; color:#60A5FA; margin-bottom:15px;"></i>
        <h3 style="margin-bottom:10px;">Respaldo de Base de Datos</h3>
        <p style="color:var(--muted); margin-bottom:20px;">Descarga una copia completa de seguridad (.sql) de toda la información del sistema (Citas, clientes, finanzas).</p>
        <a href="<?= BASE_URL ?>/herramientas/backup_db" class="btn-primary" style="text-decoration:none; display:inline-block; background:#60A5FA;"><i class="fas fa-download"></i> Descargar Backup</a>
    </div>

    <div class="card" style="text-align:center; border: 1px solid rgba(239, 68, 68, 0.3);">
        <i class="fas fa-biohazard" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
        <h3 style="margin-bottom:10px;">Recargar Demo Masiva</h3>
        <p style="color:var(--muted); margin-bottom:20px;">
            <strong>¡ADVERTENCIA DE PRUEBA!</strong> Esto borrará todos los datos de clientes, citas y finanzas actuales, 
            e inyectará 10 sucursales, 40 barberos, 100 clientes y 300 citas para probar el sistema al 100%.
        </p>
        <a href="<?= BASE_URL ?>/seeder/run" onclick="return confirm('¿Estás SEGURO de borrar todo y cargar la demo masiva?');" class="btn-primary" style="text-decoration:none; display:inline-block; background:#EF4444; color:#fff;"><i class="fas fa-radiation"></i> Destruir y Cargar Demo</a>
    </div>

</div>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
