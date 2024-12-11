<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_incidencia = $_POST['id_incidencia'];
    $id_tecnico = $_POST['id_tecnico'];

    $query = "UPDATE incidencias SET id_tecnico = ?, estado = 'Asignada' WHERE id_incidencia = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $id_tecnico, $id_incidencia);

    if ($stmt->execute()) {
        $mensaje = "Incidencia asignada con éxito.";
    } else {
        $mensaje = "Error al asignar la incidencia.";
    }
}

$incidencias = $conn->query("SELECT id_incidencia, descripcion FROM incidencias WHERE estado = 'Abierta'");
$tecnicos = $conn->query("SELECT id_usuario, nombre FROM usuarios WHERE rol = 'Técnico'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Incidencia</title>
</head>
<body>
    <form method="POST">
        <label>Incidencia</label>
        <select name="id_incidencia" required>
            <option value="">Seleccione una incidencia</option>
            <?php while ($incidencia = $incidencias->fetch_assoc()): ?>
                <option value="<?= $incidencia['id_incidencia'] ?>"><?= $incidencia['descripcion'] ?></option>
            <?php endwhile; ?>
        </select>
        <label>Técnico</label>
        <select name="id_tecnico" required>
            <option value="">Seleccione un técnico</option>
            <?php while ($tecnico = $tecnicos->fetch_assoc()): ?>
                <option value="<?= $tecnico['id_usuario'] ?>"><?= $tecnico['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Asignar</button>
    </form>
    <?php if (isset($mensaje)): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>
</body>
</html>
