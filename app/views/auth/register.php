<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Registro | Barber Hub' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --gold: #E2B04A; --gold2: #F5D78E; --dark: #0D0D0F; --card: #141418; --border: rgba(255,255,255,0.07); --white: #FFFFFF; --muted: #7A7A8C; }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--white); min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow-x: hidden; }
        h1,h2 { font-family: 'Outfit', sans-serif; }

        .bg-grid { position: fixed; inset: 0; z-index: 0; background-image: linear-gradient(rgba(226,176,74,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(226,176,74,0.03) 1px, transparent 1px); background-size: 60px 60px; pointer-events: none; }
        .glow { position: fixed; border-radius: 50%; z-index: 0; pointer-events: none; background: radial-gradient(circle, rgba(226,176,74,0.08) 0%, transparent 70%); }
        .glow-1 { top: -200px; left: -200px; width: 600px; height: 600px; }

        .auth-container { position: relative; z-index: 1; width: 100%; max-width: 480px; padding: 20px; }
        .auth-card { background: rgba(20,20,24,0.95); backdrop-filter: blur(20px); border: 1px solid var(--border); border-radius: 24px; padding: 48px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6); }

        .brand { text-align: center; margin-bottom: 32px; }
        .brand-icon { font-size: 2.2rem; color: var(--gold); margin-bottom: 12px; display: inline-block; }
        .brand h1 { font-size: 1.8rem; font-weight: 800; color: var(--white); letter-spacing: -0.5px; }

        .error-msg, .success-msg { padding: 14px 18px; border-radius: 12px; font-size: 0.88rem; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-weight: 500; line-height: 1.4; }
        .error-msg { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #FCA5A5; }
        .success-msg { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #6EE7B7; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #B0B0C0; margin-bottom: 8px; letter-spacing: 0.3px; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 1.1rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px 14px 44px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: var(--white); font-size: 0.95rem; font-family: 'Inter', sans-serif; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: rgba(226,176,74,0.4); background: rgba(255,255,255,0.05); box-shadow: 0 0 0 4px rgba(226,176,74,0.1); }
        .input-wrapper input::placeholder { color: #555566; }

        .btn-submit { width: 100%; background: linear-gradient(135deg, var(--gold), #b8892d); color: #000; border: none; padding: 16px; border-radius: 12px; font-size: 1rem; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.3s; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 20px rgba(226,176,74,0.25); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(226,176,74,0.4); }

        .auth-footer { text-align: center; margin-top: 28px; font-size: 0.88rem; color: var(--muted); }
        .auth-footer a { color: var(--gold); text-decoration: none; font-weight: 600; transition: color 0.2s; }
        .auth-footer a:hover { color: var(--gold2); text-decoration: underline; }

        @media (max-width: 480px) {
            .auth-card { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="glow glow-1"></div>

<div class="auth-container">
    <div class="auth-card">
        <div class="brand">
            <i class="fas fa-crown brand-icon"></i>
            <h1>Crear Cuenta</h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success-msg">
                <i class="fas fa-check-circle"></i> 
                <div>
                    <strong>Registro completado.</strong><br>
                    <?= htmlspecialchars($success) ?>
                </div>
            </div>
            <div style="text-align:center; margin-top:20px;">
                <a href="<?= BASE_URL ?>/auth/login" class="btn-submit">Ir al Inicio de Sesión</a>
            </div>
        <?php else: ?>
            <form action="<?= BASE_URL ?>/auth/register" method="POST">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nombre" placeholder="Ej. Juan Pérez" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" placeholder="tu@correo.com" required value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Teléfono (Opcional)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="telefono" placeholder="10 dígitos" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" placeholder="Repite tu contraseña" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Crear Cuenta <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        <?php endif; ?>

        <?php if (empty($success)): ?>
        <div class="auth-footer">
            ¿Ya tienes una cuenta? <a href="<?= BASE_URL ?>/auth/login">Inicia sesión</a><br><br>
            <a href="<?= BASE_URL ?>/" style="color:var(--muted); font-size:0.8rem; font-weight:400;"><i class="fas fa-home"></i> Volver al inicio</a>
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
