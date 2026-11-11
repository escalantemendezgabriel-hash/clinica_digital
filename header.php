<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Clínica Dental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Función AJAX común: envía datos a api.php y recibe JSON
        async function api(d) {
            const r = await fetch('api.php', { method: 'POST', body: new URLSearchParams(d) });
            return r.json();
        }

        function esc(t) {
            const e = document.createElement('div');
            e.textContent = t ?? '';
            return e.innerHTML;
        }
    </script>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">🦷 Clínica Dental</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#m">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="m">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Panel</a></li>
                <li class="nav-item"><a class="nav-link" href="pacientes.php">Pacientes</a></li>
                <li class="nav-item"><a class="nav-link" href="procedimientos.php">Procedimientos</a></li>
            </ul>
            <span class="navbar-text me-3"><?= htmlspecialchars($_SESSION['u']) ?></span>
            <a class="btn btn-outline-light btn-sm" href="logout.php">Salir</a>
        </div>
    </div>
</nav>

<div class="container">
