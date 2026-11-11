<?php
require 'config.php';
auth();
include 'header.php';
$id = (int)($_GET['id'] ?? 0);
$s  = $db->prepare("SELECT * FROM pacientes WHERE id=?");
$s->bind_param('i', $id);
$s->execute();
$p = $s->get_result()->fetch_assoc();
if (!$p) {
    echo "<div class='alert alert-danger'>Paciente no encontrado</div>";
    exit;
}
$procs = $db->query("SELECT id,nombre FROM procedimientos ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between mb-3">
    <h3>Historia clínica</h3>
    <a class="btn btn-danger" href="historia_pdf.php?id=<?= $id ?>" target="_blank">📄 Generar PDF</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <b><?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?></b> — C.I. <?= htmlspecialchars($p['cedula']) ?><br>
        Nacimiento: <?= $p['fecha_nacimiento'] ?> | Tel: <?= htmlspecialchars($p['telefono']) ?><br>
        Alergias/antecedentes: <?= htmlspecialchars($p['alergias'] ?: 'Ninguno') ?>
    </div>
</div>

<form id="f" class="row g-2 mb-4">
    <input type="hidden" name="action" value="historia_guardar">
    <input type="hidden" name="paciente_id" value="<?= $id ?>">
    <div class="col-md-3">
        <select class="form-select" name="procedimiento_id" required>
            <option value="">Procedimiento...</option>
            <?php foreach ($procs as $r) echo "<option value='{$r['id']}'>" . htmlspecialchars($r['nombre']) . "</option>"; ?>
        </select>
    </div>
    <div class="col-md-2">
        <input class="form-control" type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>
    </div>
    <div class="col-md-2">
        <input class="form-control" name="diente" placeholder="Diente / pieza">
    </div>
    <div class="col-md-3">
        <input class="form-control" name="observaciones" placeholder="Observaciones">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Agregar</button>
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Procedimiento</th>
            <th>Diente</th>
            <th>Observaciones</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tb"></tbody>
</table>

<?php include 'footer.php'; ?>

<script>
const pid = <?= $id ?>, f = document.getElementById('f');

async function cargar() {
    const d = await api({ action: 'historia', paciente_id: pid });
    tb.innerHTML = d.map(h => `
        <tr>
            <td>${h.fecha}</td>
            <td>${esc(h.proc)}</td>
            <td>${esc(h.diente)}</td>
            <td>${esc(h.observaciones)}</td>
            <td><button class="btn btn-sm btn-danger" onclick="borrar(${h.id})">X</button></td>
        </tr>
    `).join('') || '<tr><td colspan=5 class="text-center">Sin atenciones registradas</td></tr>';
}

async function borrar(id) {
    if (confirm('¿Eliminar registro?')) {
        await api({ action: 'historia_eliminar', id });
        cargar();
    }
}

f.onsubmit = async e => {
    e.preventDefault();
    await api(Object.fromEntries(new FormData(f)));
    f.reset();
    f.fecha.value = new Date().toISOString().slice(0, 10);
    cargar();
};

cargar();
</script>
</body>
</html>
