<?php
require 'config.php';
$err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s = $db->prepare("SELECT id,nombre FROM usuarios WHERE email=? AND password=?");
    $h = hash('sha256', $_POST['password']);
    $s->bind_param('ss', $_POST['email'], $h);
    $s->execute();
    if ($u = $s->get_result()->fetch_assoc()) {
        $_SESSION['u'] = $u['nombre'];
        header('Location: dashboard.php');
        exit;
    }
    $err = 'Correo o contraseña incorrectos';
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Ingreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh">
    <div class="container" style="max-width:380px">
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="text-center mb-3">🦷 Clínica Dental</h4>
                <?php if ($err) echo "<div class='alert alert-danger'>$err</div>"; ?>
                <form method="post">
                    <input class="form-control mb-2" type="email" name="email" placeholder="Correo" required>
                    <input class="form-control mb-3" type="password" name="password" placeholder="Contraseña" required>
                    <button class="btn btn-primary w-100">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
