<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $tamano = $_POST['tamano'];
    $resolucion = $_POST['resolucion'];
    $tipo_panel = $_POST['tipo_panel'];

    $query = "INSERT INTO detalles_monitor (id_equipo, tamano, resolucion, tipo_panel)
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $id_equipo, $tamano, $resolucion, $tipo_panel);

    if ($stmt->execute()) {
        header('Location: listar_equipos.php');
    } else {
        $error = "Error al guardar los detalles.";
    }
}

$equipos = $conn->query("SELECT id_equipo, modelo FROM equipos WHERE tipo = 'Monitor'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Monitor</title>
</head>
<body>
    <form method="POST">
        <label>Equipo</label>
        <select name="id_equipo">
            <option value="">Seleccione</option>
            <?php while ($equipo = $equipos->fetch_assoc()): ?>
                <option value="<?= $equipo['id_equipo'] ?>"><?= $equipo['modelo'] ?></option>
            <?php endwhile; ?>
        </select>
        <label>Tamaño (pulgadas)</label><input name="tamano" required>
        <label>Resolución</label><input name="resolucion" required>
        <label>Tipo de Panel</label><input name="tipo_panel" required>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
