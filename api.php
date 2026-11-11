<?php
require 'config.php';
auth();
header('Content-Type: application/json');

function q($sql, $t = '', ...$p) {
    global $db;
    $s = $db->prepare($sql);
    if ($t) $s->bind_param($t, ...$p);
    $s->execute();
    return $s;
}

function rows($s) {
    return $s->get_result()->fetch_all(MYSQLI_ASSOC);
}

$P  = $_POST;
$id = (int)($P['id'] ?? 0);

switch ($P['action'] ?? '') {
    case 'pacientes':
        echo json_encode(rows(q("SELECT * FROM pacientes ORDER BY apellido")));
        break;

    case 'paciente_guardar':
        if ($id) {
            q(
                "UPDATE pacientes SET cedula=?,nombre=?,apellido=?,fecha_nacimiento=?,telefono=?,alergias=? WHERE id=?",
                'ssssssi',
                $P['cedula'], $P['nombre'], $P['apellido'],
                $P['fecha_nacimiento'], $P['telefono'], $P['alergias'], $id
            );
        } else {
            q(
                "INSERT INTO pacientes(cedula,nombre,apellido,fecha_nacimiento,telefono,alergias) VALUES(?,?,?,?,?,?)",
                'ssssss',
                $P['cedula'], $P['nombre'], $P['apellido'],
                $P['fecha_nacimiento'], $P['telefono'], $P['alergias']
            );
        }
        echo json_encode(['ok' => true]);
        break;

    case 'paciente_eliminar':
        q("DELETE FROM pacientes WHERE id=?", 'i', $id);
        echo json_encode(['ok' => true]);
        break;

    case 'procs':
        echo json_encode(rows(q("SELECT * FROM procedimientos ORDER BY nombre")));
        break;

    case 'proc_guardar':
        if ($id) {
            q(
                "UPDATE procedimientos SET nombre=?,descripcion=?,precio=? WHERE id=?",
                'ssdi',
                $P['nombre'], $P['descripcion'], $P['precio'], $id
            );
        } else {
            q(
                "INSERT INTO procedimientos(nombre,descripcion,precio) VALUES(?,?,?)",
                'ssd',
                $P['nombre'], $P['descripcion'], $P['precio']
            );
        }
        echo json_encode(['ok' => true]);
        break;

    case 'proc_eliminar':
        try {
            q("DELETE FROM procedimientos WHERE id=?", 'i', $id);
            echo json_encode(['ok' => true]);
        } catch (Exception $e) {
            echo json_encode(['ok' => false, 'msg' => 'Está usado en historias clínicas']);
        }
        break;

    case 'historia':
        echo json_encode(rows(q(
            "SELECT h.*,p.nombre proc FROM historia h JOIN procedimientos p ON p.id=h.procedimiento_id WHERE paciente_id=? ORDER BY fecha DESC",
            'i',
            (int)$P['paciente_id']
        )));
        break;

    case 'historia_guardar':
        q(
            "INSERT INTO historia(paciente_id,procedimiento_id,fecha,diente,observaciones) VALUES(?,?,?,?,?)",
            'iisss',
            (int)$P['paciente_id'], (int)$P['procedimiento_id'],
            $P['fecha'], $P['diente'], $P['observaciones']
        );
        echo json_encode(['ok' => true]);
        break;

    case 'historia_eliminar':
        q("DELETE FROM historia WHERE id=?", 'i', $id);
        echo json_encode(['ok' => true]);
        break;

    default:
        echo json_encode(['ok' => false]);
}
