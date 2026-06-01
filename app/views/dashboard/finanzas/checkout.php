<?php ob_start(); ?>
<style>
    .checkout-container { max-width: 600px; margin: 0 auto; background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 32px; }
    .checkout-header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px; }
    .checkout-header h3 { font-size: 1.5rem; color: var(--gold); margin-bottom: 5px; }
    .checkout-header p { color: var(--muted); font-size: 0.9rem; }
    
    .ticket-info { background: rgba(255,255,255,0.02); border-radius: 12px; padding: 20px; margin-bottom: 30px; border: 1px dashed rgba(255,255,255,0.1); }
    .ticket-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; }
    .ticket-row.total { border-top: 1px solid var(--border); padding-top: 12px; margin-top: 12px; font-size: 1.3rem; font-weight: 800; color: #34D399; }
    
    .form-group { margin-bottom: 24px; }
    .form-group label { display: block; font-size: 0.85rem; color: #B0B0C0; margin-bottom: 10px; font-weight: 600; }
    
    .payment-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .payment-method { border: 1px solid var(--border); border-radius: 12px; padding: 16px; text-align: center; cursor: pointer; transition: all 0.2s; position: relative; }
    .payment-method input { position: absolute; opacity: 0; cursor: pointer; }
    .payment-method:hover { background: rgba(255,255,255,0.02); }
    .payment-method.selected { border-color: var(--gold); background: rgba(226,176,74,0.05); }
    .payment-method i { font-size: 1.5rem; color: var(--muted); margin-bottom: 8px; display: block; transition: color 0.2s; }
    .payment-method.selected i { color: var(--gold); }
    .payment-method span { font-size: 0.9rem; font-weight: 600; color: var(--white); }
    
    .btn-pay { background: linear-gradient(135deg, #34D399, #10B981); color: #000; border: none; padding: 14px 28px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 1.1rem; width: 100%; transition: transform 0.2s; }
    .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(52,211,153,0.3); }
</style>

<div class="checkout-container">
    <div class="checkout-header">
        <h3>Procesar Cobro</h3>
        <p>Cita <strong style="font-family:monospace; color:var(--white);">#<?= htmlspecialchars($cita['codigo_unico']) ?></strong></p>
    </div>

    <div class="ticket-info">
        <div class="ticket-row">
            <span style="color:var(--muted);">Cliente:</span>
            <span>Usuario ID: <?= $cita['cliente_usuario_id'] ?></span>
        </div>
        <div class="ticket-row">
            <span style="color:var(--muted);">Servicio:</span>
            <span><?= htmlspecialchars($cita['servicio_nombre']) ?></span>
        </div>
        <div class="ticket-row">
            <span style="color:var(--muted);">Fecha:</span>
            <span><?= htmlspecialchars($cita['fecha']) ?> a las <?= date('H:i', strtotime($cita['hora'])) ?></span>
        </div>
        <div class="ticket-row total">
            <span>Total a Cobrar:</span>
            <span>$<?= number_format($cita['precio'], 2) ?></span>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/finanzas/cobrar_cita/<?= $cita['id'] ?>" onsubmit="return confirm('¿Confirmar pago y cerrar cita?');">
        <div class="form-group">
            <label>Seleccionar Método de Pago</label>
            <div class="payment-methods">
                <label class="payment-method selected" id="lbl-efectivo">
                    <input type="radio" name="metodo" value="Efectivo" checked onchange="selectMethod('efectivo')">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Efectivo</span>
                </label>
                <label class="payment-method" id="lbl-debito">
                    <input type="radio" name="metodo" value="Tarjeta Debito" onchange="selectMethod('debito')">
                    <i class="fas fa-credit-card"></i>
                    <span>T. Débito</span>
                </label>
                <label class="payment-method" id="lbl-credito">
                    <input type="radio" name="metodo" value="Tarjeta Credito" onchange="selectMethod('credito')">
                    <i class="fab fa-cc-visa"></i>
                    <span>T. Crédito</span>
                </label>
                <label class="payment-method" id="lbl-trans">
                    <input type="radio" name="metodo" value="Transferencia Bancaria" onchange="selectMethod('trans')">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Transferencia</span>
                </label>
            </div>
        </div>

        <div style="display:flex; gap:15px; margin-top:30px;">
            <a href="<?= BASE_URL ?>/dashboard/agenda" style="text-decoration:none; padding:14px; text-align:center; flex:1; border:1px solid var(--border); border-radius:10px; color:var(--white); font-weight:600;">Cancelar</a>
            <button type="submit" class="btn-pay" style="flex:2;"><i class="fas fa-check-circle me-2"></i> Confirmar Cobro</button>
        </div>
    </form>
</div>

<script>
    function selectMethod(id) {
        document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
        document.getElementById('lbl-' + id).classList.add('selected');
    }
</script>

<?php
$vista_hija = __FILE__;
echo ob_get_clean();
?>
