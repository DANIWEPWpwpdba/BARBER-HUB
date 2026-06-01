<?php
// Layout base si fuera necesario, o HTML directo. Por ahora usaremos HTML directo similar al layout dashboard pero más limpio para cliente.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #0f0f15;
            --card: #16161e;
            --gold: #E2B04A;
            --white: #ffffff;
            --muted: #8E8E9F;
            --border: #2a2a35;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-dark); color: var(--white); line-height: 1.6; }
        .container { max-width: 1000px; margin: 50px auto; padding: 0 20px; }
        
        .profile-header { background: linear-gradient(135deg, var(--card), #1a1a24); padding: 40px; border-radius: 20px; border: 1px solid var(--border); margin-bottom: 30px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap; }
        .profile-avatar { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold); }
        .profile-info h2 { margin: 0 0 5px 0; font-size: 2rem; color: var(--white); font-family: 'Outfit', sans-serif; }
        .profile-info p { color: var(--muted); margin: 0; font-size: 1.1rem; }
        .btn-upload { background: rgba(226,176,74,0.1); color: var(--gold); border: 1px solid var(--gold); padding: 8px 16px; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; margin-top: 15px; display: inline-block; }
        .btn-upload:hover { background: var(--gold); color: #000; }
        
        .loyalty-card { background: linear-gradient(135deg, #2a2a35, #111); border: 1px solid var(--gold); border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 30px; position: relative; overflow: hidden; }
        .loyalty-card::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(226,176,74,0.1) 0%, transparent 50%); z-index: 0; }
        .loyalty-content { position: relative; z-index: 1; }
        .loyalty-level { font-size: 1.5rem; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 2px; }
        .loyalty-points { font-size: 3rem; font-weight: 800; color: var(--white); margin: 10px 0; font-family: 'Outfit', sans-serif; }

        .citas-grid { display: grid; gap: 20px; }
        .cita-card { background: var(--card); border: 1px solid var(--border); padding: 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap:15px; }
        .cita-date { text-align: center; background: rgba(255,255,255,0.03); padding: 10px 15px; border-radius: 8px; border: 1px solid var(--border); min-width:80px; }
        .cita-date .day { font-size: 1.5rem; font-weight: 800; color: var(--gold); }
        .cita-date .month { font-size: 0.8rem; text-transform: uppercase; color: var(--muted); }
        .cita-details h4 { margin: 0 0 5px 0; color: var(--white); font-size: 1.1rem; }
        .cita-details p { margin: 0; color: var(--muted); font-size: 0.9rem; }
        
        /* Modal Reseñas */
        .modal-resena { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center; padding:20px; }
        .modal-resena.active { display: flex; }
        .modal-content { background: var(--card); padding: 30px; border-radius: 16px; border: 1px solid var(--border); width: 100%; max-width: 500px; text-align: center; }
        .star-rating { font-size: 2.5rem; color: #444; direction: rtl; display: inline-flex; flex-direction: row-reverse; justify-content: center; }
        .star-rating input { display: none; }
        .star-rating label { cursor: pointer; transition: color 0.2s; padding: 0 5px; }
        .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: var(--gold); }
        textarea.resena-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 8px; color: var(--white); padding: 12px; margin-top: 15px; min-height: 100px; font-family: inherit; }
        
        .btn-primary { background: var(--gold); color: #000; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
        .nav-back { position:absolute; top:20px; left:20px; color:var(--muted); text-decoration:none; font-weight:600; }
        .nav-back:hover { color:var(--white); }
    </style>
</head>
<body>

    <a href="<?= BASE_URL ?>/" class="nav-back"><i class="fas fa-arrow-left"></i> Volver a Barber Hub</a>

    <div class="container">
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'foto_actualizada'): ?>
        <div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#34D399; padding:12px; border-radius:8px; margin-bottom:20px;">
            <i class="fas fa-check-circle"></i> Tu foto de perfil ha sido actualizada correctamente.
        </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'resena_guardada'): ?>
        <div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#34D399; padding:12px; border-radius:8px; margin-bottom:20px;">
            <i class="fas fa-star"></i> ¡Gracias por tu reseña! Hemos guardado tu calificación.
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5; padding:12px; border-radius:8px; margin-bottom:20px;">
            <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
        </div>
        <?php endif; ?>

        <div class="profile-header">
            <div>
                <?php $foto = $cliente['fotografia'] ? $cliente['fotografia'] : BASE_URL . '/assets/images/default-avatar.png'; ?>
                <img src="<?= $foto ?>" alt="Perfil" class="profile-avatar">
            </div>
            <div class="profile-info">
                <h2><?= htmlspecialchars($cliente['nombre']) ?></h2>
                <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($cliente['correo']) ?></p>
                
                <form action="<?= BASE_URL ?>/perfil/subir_foto" method="POST" enctype="multipart/form-data" id="form-foto" style="margin-top:10px;">
                    <label for="foto-input" class="btn-upload">
                        <i class="fas fa-camera"></i> Cambiar Foto
                    </label>
                    <input type="file" id="foto-input" name="foto" style="display:none;" accept="image/*" onchange="document.getElementById('form-foto').submit();">
                </form>
            </div>
        </div>

        <div class="loyalty-card">
            <div class="loyalty-content">
                <div class="loyalty-level"><i class="fas fa-crown"></i> Nivel <?= htmlspecialchars($cliente['nivel']) ?></div>
                <div class="loyalty-points"><?= $cliente['puntos_acumulados'] ?> pts</div>
                <p style="color:var(--muted); margin:0;">Acumulas 1 punto por cada $10.00 en tus cortes.</p>
            </div>
        </div>

        <h3 style="margin-bottom:20px; font-family:'Outfit',sans-serif;"><i class="fas fa-calendar-alt" style="color:var(--gold);"></i> Mis Próximas Citas</h3>
        <div class="citas-grid" style="margin-bottom: 40px;">
            <?php if(empty($citas_futuras)): ?>
                <div class="cita-card" style="justify-content:center; padding:40px;">
                    <p style="color:var(--muted); text-align:center;">No tienes citas próximas programadas.<br><br>
                    <a href="<?= BASE_URL ?>/" class="btn-primary" style="display:inline-block; text-decoration:none; margin-top:15px;">Agendar una cita</a></p>
                </div>
            <?php else: ?>
                <?php foreach($citas_futuras as $c): ?>
                <div class="cita-card">
                    <div style="display:flex; gap:20px; align-items:center;">
                        <div class="cita-date">
                            <div class="day"><?= date('d', strtotime($c['fecha'])) ?></div>
                            <div class="month"><?= date('M', strtotime($c['fecha'])) ?></div>
                        </div>
                        <div class="cita-details">
                            <h4><?= htmlspecialchars($c['servicio']) ?></h4>
                            <p><i class="fas fa-store"></i> <?= htmlspecialchars($c['barberia']) ?> &nbsp;|&nbsp; <i class="fas fa-cut"></i> <?= htmlspecialchars($c['barbero']) ?></p>
                            <p style="margin-top:5px; color:var(--gold);"><i class="fas fa-clock"></i> <?= date('H:i', strtotime($c['hora'])) ?> hrs</p>
                        </div>
                    </div>
                    <div>
                        <span style="background:rgba(255,255,255,0.05); padding:6px 12px; border-radius:8px; font-size:0.85rem; border:1px solid var(--border);"><?= $c['estado'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h3 style="margin-bottom:20px; font-family:'Outfit',sans-serif;"><i class="fas fa-history" style="color:var(--gold);"></i> Historial y Reseñas</h3>
        <div class="citas-grid">
            <?php if(empty($citas_pasadas)): ?>
                <div class="cita-card" style="justify-content:center; padding:30px;">
                    <p style="color:var(--muted); margin:0;">Aún no tienes un historial de citas finalizadas.</p>
                </div>
            <?php else: ?>
                <?php foreach($citas_pasadas as $c): ?>
                <div class="cita-card" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.05);">
                    <div style="display:flex; gap:20px; align-items:center;">
                        <div class="cita-date" style="opacity:0.7;">
                            <div class="day"><?= date('d', strtotime($c['fecha'])) ?></div>
                            <div class="month"><?= date('M', strtotime($c['fecha'])) ?></div>
                        </div>
                        <div class="cita-details">
                            <h4><?= htmlspecialchars($c['servicio']) ?></h4>
                            <p><i class="fas fa-cut"></i> <?= htmlspecialchars($c['barbero']) ?></p>
                        </div>
                    </div>
                    <div>
                        <?php if(!$c['resena_id']): ?>
                            <button onclick="abrirResena(<?= $c['id'] ?>, '<?= htmlspecialchars($c['barbero']) ?>')" class="btn-primary" style="padding:6px 12px; font-size:0.85rem;"><i class="fas fa-star"></i> Calificar</button>
                        <?php else: ?>
                            <span style="color:#34D399; font-size:0.9rem; font-weight:600;"><i class="fas fa-check"></i> Calificado</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Reseñas -->
    <div class="modal-resena" id="modalResena">
        <div class="modal-content">
            <h3 style="margin-bottom:10px; font-family:'Outfit',sans-serif;">Califica tu experiencia</h3>
            <p style="color:var(--muted); margin-bottom:20px;">¿Qué te pareció el servicio con <strong id="resenaBarbero" style="color:var(--white);"></strong>?</p>
            
            <form action="<?= BASE_URL ?>/perfil/guardar_resena" method="POST">
                <input type="hidden" name="cita_id" id="resenaCitaId">
                
                <div class="star-rating">
                    <input type="radio" id="star5" name="calificacion" value="5" required/><label for="star5" title="5 estrellas"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star4" name="calificacion" value="4"/><label for="star4" title="4 estrellas"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star3" name="calificacion" value="3"/><label for="star3" title="3 estrellas"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star2" name="calificacion" value="2"/><label for="star2" title="2 estrellas"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star1" name="calificacion" value="1"/><label for="star1" title="1 estrella"><i class="fas fa-star"></i></label>
                </div>
                
                <textarea class="resena-input" name="comentario" placeholder="Escribe un breve comentario (opcional)..."></textarea>
                
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" onclick="cerrarResena()" style="flex:1; padding:12px; background:transparent; border:1px solid var(--border); color:var(--white); border-radius:8px; cursor:pointer;">Cancelar</button>
                    <button type="submit" style="flex:1; padding:12px; background:var(--gold); border:none; color:#000; font-weight:700; border-radius:8px; cursor:pointer;">Enviar Reseña</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirResena(cita_id, barbero) {
            document.getElementById('resenaCitaId').value = cita_id;
            document.getElementById('resenaBarbero').innerText = barbero;
            document.getElementById('modalResena').classList.add('active');
        }
        function cerrarResena() {
            document.getElementById('modalResena').classList.remove('active');
        }
    </script>
</body>
</html>
