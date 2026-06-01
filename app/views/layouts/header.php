<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Barber Hub | Directorio y Software SaaS' ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animations CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #0a0a0c;
            --bg-card: rgba(26, 26, 30, 0.7);
            --primary-gold: #e2c044;
            --hover-gold: #c2a133;
            --text-light: #f8f9fa;
            --text-muted: #888c96;
            --glass-border: rgba(226, 192, 68, 0.15);
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            overflow-x: hidden;
        }
        h1, h2, h3, h4, h5, .navbar-brand {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Glassmorphism Navbar */
        .navbar {
            background-color: rgba(10, 10, 12, 0.85) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s ease;
        }
        .navbar-brand {
            color: var(--primary-gold) !important;
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            position: relative;
            padding-bottom: 5px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-gold);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Buttons with glow effects */
        .btn-gold {
            background: linear-gradient(135deg, #e2c044 0%, #c2a133 100%);
            color: #000;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(226, 192, 68, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-gold:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(226, 192, 68, 0.5);
            color: #000;
        }
        .btn-outline-gold {
            border: 2px solid var(--primary-gold);
            color: var(--primary-gold);
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-outline-gold:hover {
            background-color: var(--primary-gold);
            color: #000;
            box-shadow: 0 4px 15px rgba(226, 192, 68, 0.3);
            transform: translateY(-3px);
        }
        
        /* Dynamic Cards */
        .card-dark {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            color: var(--text-light);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .card-dark::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.05) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            transition: all 0.7s ease;
        }
        .card-dark:hover {
            transform: translateY(-10px);
            border-color: var(--primary-gold);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 15px rgba(226, 192, 68, 0.2);
        }
        .card-dark:hover::before {
            left: 200%;
        }
        
        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(to right, #e2c044, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

<!-- Navegación -->
<nav class="navbar navbar-expand-lg fixed-top py-3">
    <div class="container">
        <a class="navbar-brand" href="/">BARBER HUB <i class="fas fa-crown ms-1 fs-6"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border:none;">
            <i class="fas fa-bars text-light fs-3"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link px-3" href="#beneficios">Beneficios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="#directorio">Directorio Nacional</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="#planes">Planes SaaS</a>
                </li>
                <li class="nav-item ms-lg-4 mt-3 mt-lg-0">
                    <a class="btn btn-outline-gold px-4 rounded-pill" href="/auth/login"><i class="fas fa-user-circle me-2"></i> Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
