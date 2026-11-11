<?php
require 'config.php';
auth();
include 'header.php';
$n = fn($t) => $db->query("SELECT COUNT(*) c FROM $t")->fetch_assoc()['c'];
?>

<h3 class="mb-4">Panel principal</h3>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h2><?= $n('pacientes') ?></h2>
                Pacientes
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success">
            <div class="card-body">
                <h2><?= $n('procedimientos') ?></h2>
                Procedimientos
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-info">
            <div class="card-body">
                <h2><?= $n('historia') ?></h2>
                Atenciones registradas
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a class="btn btn-primary" href="pacientes.php">Ir a pacientes</a>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
