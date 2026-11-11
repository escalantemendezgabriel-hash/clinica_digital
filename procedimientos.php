<?php require 'config.php'; auth(); include 'header.php'; ?>

<div class="d-flex justify-content-between mb-3">
    <h3>Procedimientos odontológicos</h3>
    <button class="btn btn-primary" onclick="nuevo()">+ Nuevo</button>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Procedimiento</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tb"></tbody>
</table>

<div class="modal fade" id="mdl">
    <div class="modal-dialog">
        <form class="modal-content" id="f">
            <div class="modal-header">
                <h5>Procedimiento</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="proc_guardar">
                <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
                <input class="form-control mb-2" name="descripcion" placeholder="Descripción">
                <input class="form-control" type="number" step="0.01" name="precio" placeholder="Precio" required>
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
    datos = await api({ action: 'procs' });
    tb.innerHTML = datos.map(p => `
        <tr>
            <td>${esc(p.nombre)}</td>
            <td>${esc(p.descripcion)}</td>
            <td>$${esc(p.precio)}</td>
            <td class="text-end">
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
    if (!confirm('¿Eliminar?')) return;
    const r = await api({ action: 'proc_eliminar', id });
    if (!r.ok) alert(r.msg);
    cargar();
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
