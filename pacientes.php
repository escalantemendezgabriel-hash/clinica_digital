<?php require 'config.php'; auth(); include 'header.php'; ?>

<div class="d-flex justify-content-between mb-3">
    <h3>Pacientes</h3>
    <button class="btn btn-primary" onclick="nuevo()">+ Nuevo paciente</button>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Paciente</th>
                <th>Teléfono</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tb"></tbody>
    </table>
</div>

<div class="modal fade" id="mdl">
    <div class="modal-dialog">
        <form class="modal-content" id="f">
            <div class="modal-header">
                <h5>Paciente</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="paciente_guardar">
                <input class="form-control mb-2" name="cedula" placeholder="Cédula" required>
                <input class="form-control mb-2" name="nombre" placeholder="Nombres" required>
                <input class="form-control mb-2" name="apellido" placeholder="Apellidos" required>
                <label class="small">Fecha de nacimiento</label>
                <input class="form-control mb-2" type="date" name="fecha_nacimiento" required>
                <input class="form-control mb-2" name="telefono" placeholder="Teléfono">
                <input class="form-control" name="alergias" placeholder="Alergias / antecedentes">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
let datos = [];
const m = new bootstrap.Modal('#mdl'), f = document.getElementById('f');

async function cargar() {
    datos = await api({ action: 'pacientes' });
    tb.innerHTML = datos.map(p => `
        <tr>
            <td>${esc(p.cedula)}</td>
            <td>${esc(p.nombre + ' ' + p.apellido)}</td>
            <td>${esc(p.telefono)}</td>
            <td class="text-end">
                <a class="btn btn-sm btn-success" href="historia.php?id=${p.id}">Historia</a>
                <button class="btn btn-sm btn-warning" onclick="editar(${p.id})">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="borrar(${p.id})">Eliminar</button>
            </td>
        </tr>
    `).join('');
}

function nuevo() {
    f.reset();
    f.id.value = '';
    m.show();
}

function editar(id) {
    const p = datos.find(x => x.id == id);
    for (const k in p) if (f[k]) f[k].value = p[k] ?? '';
    m.show();
}

async function borrar(id) {
    if (confirm('¿Eliminar paciente y su historia?')) {
        await api({ action: 'paciente_eliminar', id });
        cargar();
    }
}

f.onsubmit = async e => {
    e.preventDefault();
    await api(Object.fromEntries(new FormData(f)));
    m.hide();
    cargar();
};

cargar();
</script>
</body>
</html>
