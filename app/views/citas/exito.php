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
        body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--white); min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; padding: 20px; text-align:center; }
        .card { max-width:500px; background:var(--card); border:1px solid var(--border); border-radius:16px; padding:40px; }
        .icon { width:80px; height:80px; background:rgba(52,211,153,0.1); color:#34D399; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 20px auto; }
        h1 { font-family:'Outfit',sans-serif; margin-bottom:10px; }
        .codigo { font-family:'Courier New', monospace; font-size:2rem; font-weight:800; color:var(--gold); margin:20px 0; letter-spacing:2px; background:rgba(226,176,74,0.1); padding:10px 20px; border-radius:8px; display:inline-block; }
        p { color:var(--muted); line-height:1.6; margin-bottom:20px; }
        .btn { display:inline-block; padding:12px 30px; border-radius:8px; background:var(--gold); color:#000; font-weight:700; text-decoration:none; }
    </style>
</head>
<body>

<div class="card">
    <div class="icon"><i class="fas fa-check"></i></div>
    <h1>¡Cita Confirmada!</h1>
    <p>Tu reservación ha sido registrada exitosamente. Guarda este código, lo necesitarás al llegar a la sucursal.</p>
    <div class="codigo"><?= htmlspecialchars($codigo) ?></div>
    <p style="font-size:0.85rem; margin-top:0;">Tu barbero ya ha sido notificado.</p>
    <a href="<?= BASE_URL ?>/" class="btn">Volver al Inicio</a>
</div>

</body>
</html>
