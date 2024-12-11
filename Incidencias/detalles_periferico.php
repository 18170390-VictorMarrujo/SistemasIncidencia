<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $tipo = $_POST['tipo'];
    $conexion = $_POST['conexion'];
    $marca = $_POST['marca'];

    $query = "INSERT INTO detalles_periferico (id_equipo, tipo, conexion, marca)
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $id_equipo, $tipo, $conexion, $marca);

    if ($stmt->execute()) {
        header('Location: listar_equipos.php');
    } else {
        $error = "Error al guardar los detalles.";
    }
}

$equipos = $conn->query("SELECT id_equipo, modelo FROM equipos WHERE tipo = 'Periférico'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Periférico</title>
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
        <label>Tipo</label><input name="tipo" required>
        <label>Conexión</label><input name="conexion" required>
        <label>Marca</label><input name="marca" required>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
