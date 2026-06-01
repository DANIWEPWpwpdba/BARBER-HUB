<?php
// Cargar config global para tener BASE_URL disponible en la vista
// (ya se carga en index.php, pero lo garantizamos aquí también)
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config/app.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? APP_NAME . ' | Acceso' ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --gold: #E2B04A; --gold2: #F5D78E; --dark: #0D0D0F;
            --card: #141418; --border: rgba(255,255,255,0.08);
            --white: #FFFFFF; --muted: #7A7A8C;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: grid;
            place-items: center;
            overflow: hidden;
            color: var(--white);
        }
        /* Fondo */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(226,176,74,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(226,176,74,0.04) 1px, transparent 1px);
            background-size: 55px 55px;
        }
        .glow-bg {
            position: fixed; top: -150px; left: -150px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(226,176,74,0.12) 0%, transparent 70%);
            z-index: 0; animation: glowFloat 12s ease-in-out infinite alternate;
        }
        @keyframes glowFloat { 0%{transform:translate(0,0);}100%{transform:translate(40px,40px);} }

        /* Card */
        .login-card {
            position: relative; z-index: 1;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px 44px;
            width: 100%; max-width: 440px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
            animation: slideUp 0.6s cubic-bezier(0.175,0.885,0.32,1.275) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .login-logo {
            font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.7rem;
            color: var(--gold); text-align: center; display: flex;
            align-items: center; justify-content: center; gap: 10px; margin-bottom: 6px;
        }
        .login-sub { text-align: center; color: var(--muted); font-size: 0.9rem; margin-bottom: 36px; }
        
        /* Form */
        .form-group { margin-bottom: 20px; }
        label {
            display: block; font-size: 0.85rem; font-weight: 600;
            color: #C0C0D0; margin-bottom: 8px; letter-spacing: 0.3px;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: var(--muted); font-size: 0.9rem;
        }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 14px 16px 14px 42px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; color: var(--white);
            font-size: 0.95rem; font-family: 'Inter', sans-serif;
            outline: none; transition: border-color 0.3s, box-shadow 0.3s;
        }
        input:focus {
            border-color: rgba(226,176,74,0.5);
            box-shadow: 0 0 0 3px rgba(226,176,74,0.1);
            background: rgba(255,255,255,0.06);
        }
        input::placeholder { color: var(--muted); }

        /* Alert */
        .alert-error {
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
            color: #FCA5A5; padding: 12px 16px; border-radius: 12px;
            font-size: 0.88rem; margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Submit */
        .btn-submit {
            width: 100%; padding: 16px;
            background: linear-gradient(135deg, var(--gold), #b8892d);
            color: #000; font-weight: 700; font-size: 1rem;
            border: none; border-radius: 14px; cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(226,176,74,0.35);
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(226,176,74,0.5);
        }

        /* Back link */
        .back-link {
            display: flex; align-items: center; justify-content: center;
            gap: 6px; margin-top: 24px; color: var(--muted);
            text-decoration: none; font-size: 0.88rem; transition: color 0.2s;
        }
        .back-link:hover { color: var(--white); }

        @media (max-width: 480px) {
            .login-card { padding: 36px 24px; margin: 20px; }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="glow-bg"></div>

<div class="login-card">
    <div class="login-logo">
        <i class="fas fa-crown"></i> Barber Hub
    </div>
    <p class="login-sub">Acceso al Sistema de Gestión Empresarial</p>

    <?php if (!empty($error)): ?>
    <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/auth/login" method="POST">
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" id="correo" name="correo" placeholder="tu@correo.com" required autocomplete="email">
            </div>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
        </div>
        <button type="submit" class="btn-submit" id="btn-login">
            <i class="fas fa-sign-in-alt"></i> Ingresar al Sistema
        </button>
    </form>

    <div style="text-align:center; margin-top:20px; font-size:0.9rem;">
        <span style="color:var(--muted);">¿No tienes cuenta?</span> 
        <a href="<?= BASE_URL ?>/auth/register" style="color:var(--gold); text-decoration:none; font-weight:600;">Regístrate como Cliente</a>
    </div>

    <a href="<?= BASE_URL ?>/" class="back-link">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>
</div>

</body>
</html>
