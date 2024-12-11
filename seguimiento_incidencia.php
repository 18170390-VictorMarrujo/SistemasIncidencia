<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_incidencia = $_POST['id_incidencia'];
    $estado = $_POST['estado'];
    $solucion = $_POST['solucion'];
    $cambio_componente = $_POST['cambio_componente'];
    $tiempo_adicional = $_POST['tiempo_adicional'];

    $query = "UPDATE incidencias SET estado = ?, solucion = ?, cambio_componente = ?, tiempo_adicional = ?
              WHERE id_incidencia = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssii', $estado, $solucion, $cambio_componente, $tiempo_adicional, $id_incidencia);

    if ($stmt->execute()) {
        $mensaje = "Incidencia actualizada con éxito.";
    } else {
        $mensaje = "Error al actualizar la incidencia.";
    }
}

$incidencias = $conn->query("SELECT id_incidencia, descripcion FROM incidencias WHERE estado = 'Asignada'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguimiento de Incidencia</title>
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
        <label>Estado</label>
        <select name="estado" required>
            <option value="En progreso">En progreso</option>
            <option value="En taller">En taller</option>
            <option value="Cerrada">Cerrada</option>
        </select>
        <label>Solución</label>
        <textarea name="solucion" required></textarea>
        <label>Cambio de componente</label>
        <input type="text" name="cambio_componente">
        <label>Tiempo adicional</label>
        <input type="number" name="tiempo_adicional" step="0.1">
        <button type="submit">Actualizar</button>
    </form>
    <?php if (isset($mensaje)): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>
</body>
</html>
