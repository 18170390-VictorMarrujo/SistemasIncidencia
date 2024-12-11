<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_incidencia = $_POST['id_incidencia'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];

    $query = "INSERT INTO cotizaciones (id_incidencia, descripcion, costo, estado)
              VALUES (?, ?, ?, 'Pendiente')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issd', $id_incidencia, $descripcion, $costo);

    if ($stmt->execute()) {
        $mensaje = "Cotización creada con éxito.";
    } else {
        $mensaje = "Error al crear la cotización.";
    }
}

$incidencias = $conn->query("SELECT id_incidencia, descripcion FROM incidencias WHERE estado = 'En progreso'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cotización</title>
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
        <label>Descripción</label><textarea name="descripcion" required></textarea>
        <label>Costo</label><input name="costo" type="number" step="0.01" required>
        <button type="submit">Crear Cotización</button>
    </form>
    <?php if (isset($mensaje)): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>
</body>
</html>
