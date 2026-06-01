<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --gold:#E2B04A; --dark:#0D0D0F; --card:#141418; --border:rgba(255,255,255,0.08); --white:#fff; --muted:#7A7A8C; }
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; padding: 20px; }
        .wizard-container { width:100%; max-width:800px; background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        .wizard-header { background:rgba(255,255,255,0.02); padding:30px; border-bottom:1px solid var(--border); text-align:center; }
        .wizard-header h2 { font-family:'Outfit',sans-serif; color:var(--gold); margin-bottom:8px; }
        .wizard-header p { color:var(--muted); font-size:0.9rem; }
        .wizard-body { padding:40px; }
        
        .step { display:none; }
        .step.active { display:block; animation: fadeIn 0.4s; }
        @keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

        .form-group { margin-bottom:24px; }
        label { display:block; margin-bottom:10px; font-weight:600; color:var(--white); }
        
        /* Radios customizados para Servicios y Barberos */
        .grid-options { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:16px; }
        .option-card { position:relative; border:1px solid var(--border); border-radius:12px; padding:20px; cursor:pointer; transition:all 0.2s; background:rgba(255,255,255,0.02); }
        .option-card:hover { border-color:rgba(226,176,74,0.5); }
        .option-card input[type="radio"] { position:absolute; opacity:0; }
        .option-card input[type="radio"]:checked + .option-content { color:var(--gold); }
        .option-card:has(input[type="radio"]:checked) { border-color:var(--gold); background:rgba(226,176,74,0.05); }
        
        .option-content h4 { margin-bottom:6px; font-size:1.05rem; }
        .option-content p { font-size:0.85rem; color:var(--muted); }
        
        .nav-buttons { display:flex; justify-content:space-between; margin-top:40px; border-top:1px solid var(--border); padding-top:24px; }
        .btn { padding:12px 24px; border-radius:8px; font-weight:600; cursor:pointer; border:none; transition:all 0.2s; }
        .btn-prev { background:rgba(255,255,255,0.05); color:var(--white); border:1px solid var(--border); }
        .btn-prev:hover { background:rgba(255,255,255,0.1); }
        .btn-next { background:linear-gradient(135deg,var(--gold),#b8892d); color:#000; }
        .btn-next:hover { box-shadow:0 4px 15px rgba(226,176,74,0.3); }

        .time-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(100px, 1fr)); gap:12px; margin-top:16px; }
        .time-slot { background:rgba(255,255,255,0.05); border:1px solid var(--border); padding:12px; text-align:center; border-radius:8px; cursor:pointer; transition:all 0.2s; font-weight:600; }
        .time-slot:hover { border-color:var(--gold); }
        .time-slot.selected { background:var(--gold); color:#000; border-color:var(--gold); }

        #fecha_input { width:100%; max-width:300px; padding:12px 16px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; color:#fff; font-family:inherit; }
    </style>
</head>
<body>

<a href="<?= BASE_URL ?>/barberia/<?= strtolower(str_replace(' ', '-', $barberia['nombre_comercial'])) ?>" style="position:absolute; top:30px; left:40px; color:var(--muted); text-decoration:none; font-weight:600;"><i class="fas fa-arrow-left"></i> Volver</a>

<div class="wizard-container">
    <div class="wizard-header">
        <h2>Reservar en <?= htmlspecialchars($barberia['nombre_comercial']) ?></h2>
        <p id="step-indicator">Paso 1 de 3: Elige un Servicio</p>
    </div>
    
    <div class="wizard-body">
        <form id="bookingForm" method="POST" action="<?= BASE_URL ?>/cita/guardar">
            <input type="hidden" name="barberia_id" value="<?= $barberia['id'] ?>">
            <input type="hidden" name="hora" id="hora_input" required>
            
            <!-- PASO 1: SERVICIOS -->
            <div class="step active" id="step1">
                <label>Selecciona el servicio que deseas:</label>
                <div class="grid-options">
                    <?php foreach($servicios as $s): ?>
                    <label class="option-card">
                        <input type="radio" name="servicio_id" value="<?= $s['id'] ?>" required onchange="enableNext()">
                        <div class="option-content">
                            <h4><?= htmlspecialchars($s['nombre']) ?></h4>
                            <p><i class="fas fa-clock"></i> <?= $s['duracion_minutos'] ?> min &nbsp;|&nbsp; <i class="fas fa-tag"></i> $<?= number_format($s['precio'],2) ?></p>
                        </div>
                    </label>
                    <?php endforeach; ?>
                    <?php if(empty($servicios)): ?><p style="color:#FCA5A5;">Esta sucursal aún no tiene servicios.</p><?php endif; ?>
                </div>
            </div>

            <!-- PASO 2: BARBEROS -->
            <div class="step" id="step2">
                <label>Selecciona a tu profesional:</label>
                <div class="grid-options">
                    <?php foreach($barberos as $b): ?>
                    <label class="option-card">
                        <input type="radio" name="barbero_id" value="<?= $b['id'] ?>" required onchange="enableNext()">
                        <div class="option-content">
                            <h4 style="display:flex; align-items:center; gap:10px;">
                                <div style="width:30px; height:30px; border-radius:50%; background:var(--gold); color:#000; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:800;">
                                    <?= strtoupper(substr($b['nombre'],0,1)) ?>
                                </div>
                                <?= htmlspecialchars($b['nombre']) ?>
                            </h4>
                            <p style="margin-top:8px;"><?= $b['anios_experiencia'] ?> años exp.</p>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- PASO 3: FECHA Y HORA -->
            <div class="step" id="step3">
                <div class="form-group">
                    <label>Selecciona la fecha:</label>
                    <input type="date" name="fecha" id="fecha_input" required min="<?= date('Y-m-d') ?>" onchange="cargarHorarios()">
                </div>
                
                <div class="form-group">
                    <label>Horarios Disponibles:</label>
                    <div id="loader" style="display:none; color:var(--gold);"><i class="fas fa-spinner fa-spin"></i> Cargando disponibilidad...</div>
                    <div class="time-grid" id="time-grid">
                        <p style="color:var(--muted); font-size:0.9rem; grid-column:1/-1;">Selecciona una fecha para ver los horarios.</p>
                    </div>
                </div>
            </div>

            <div class="nav-buttons">
                <button type="button" class="btn btn-prev" id="btnPrev" style="display:none;" onclick="prevStep()">Atrás</button>
                <div style="flex:1;"></div>
                <button type="button" class="btn btn-next" id="btnNext" disabled onclick="nextStep()">Siguiente</button>
                <button type="submit" class="btn btn-next" id="btnSubmit" style="display:none;" disabled>Confirmar Reserva</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function enableNext() {
        if(currentStep === 1) {
            document.getElementById('btnNext').disabled = !document.querySelector('input[name="servicio_id"]:checked');
        } else if(currentStep === 2) {
            document.getElementById('btnNext').disabled = !document.querySelector('input[name="barbero_id"]:checked');
        } else if(currentStep === 3) {
            const dateSelected = document.getElementById('fecha_input').value;
            const timeSelected = document.getElementById('hora_input').value;
            document.getElementById('btnSubmit').disabled = !(dateSelected && timeSelected);
        }
    }

    function showStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
        document.getElementById('step' + step).classList.add('active');
        document.getElementById('step-indicator').innerText = `Paso ${step} de ${totalSteps}`;
        
        document.getElementById('btnPrev').style.display = step > 1 ? 'block' : 'none';
        
        if(step === totalSteps) {
            document.getElementById('btnNext').style.display = 'none';
            document.getElementById('btnSubmit').style.display = 'block';
            cargarHorarios(); // Refrescar si ya había fecha
        } else {
            document.getElementById('btnNext').style.display = 'block';
            document.getElementById('btnSubmit').style.display = 'none';
        }
        enableNext();
    }

    function nextStep() {
        if(currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if(currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    async function cargarHorarios() {
        const fecha = document.getElementById('fecha_input').value;
        const barbero = document.querySelector('input[name="barbero_id"]:checked')?.value;
        const servicio = document.querySelector('input[name="servicio_id"]:checked')?.value;
        const grid = document.getElementById('time-grid');
        const loader = document.getElementById('loader');
        
        document.getElementById('hora_input').value = '';
        enableNext();
        
        if(!fecha || !barbero || !servicio) return;
        
        grid.innerHTML = '';
        loader.style.display = 'block';
        
        try {
            const res = await fetch(`<?= BASE_URL ?>/cita/api_disponibilidad?fecha=${fecha}&barbero_id=${barbero}&servicio_id=${servicio}`);
            const horarios = await res.json();
            
            loader.style.display = 'none';
            
            if(horarios.length === 0) {
                grid.innerHTML = '<p style="color:#FCA5A5; font-size:0.9rem; grid-column:1/-1;">No hay horarios disponibles para esta fecha.</p>';
                return;
            }
            
            horarios.forEach(h => {
                const div = document.createElement('div');
                div.className = 'time-slot';
                div.innerText = h;
                div.onclick = function() {
                    document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('hora_input').value = h;
                    enableNext();
                };
                grid.appendChild(div);
            });
            
        } catch(e) {
            loader.style.display = 'none';
            grid.innerHTML = '<p style="color:#FCA5A5;">Error al cargar horarios.</p>';
        }
    }
</script>

</body>
</html>
