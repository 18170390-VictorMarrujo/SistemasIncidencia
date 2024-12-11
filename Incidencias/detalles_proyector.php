<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $resolucion = $_POST['resolucion'];
    $brillo = $_POST['brillo'];
    $tipo_lampara = $_POST['tipo_lampara'];
    $conectividad = $_POST['conectividad'];

    $query = "INSERT INTO detalles_proyector (id_equipo, resolucion, brillo, tipo_lampara, conectividad)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issss', $id_equipo, $resolucion, $brillo, $tipo_lampara, $conectividad);

    if ($stmt->execute()) {
        header('Location: listar_equipos.php');
    } else {
        $error = "Error al guardar los detalles.";
    }
}

$equipos = $conn->query("SELECT id_equipo, modelo FROM equipos WHERE tipo = 'Proyector'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Proyector</title>
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
        <label>Resolución</label><input name="resolucion" required>
        <label>Brillo (lumens)</label><input name="brillo" required>
        <label>Tipo de Lámpara</label><input name="tipo_lampara">
        <label>Conectividad</label><input name="conectividad">
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
