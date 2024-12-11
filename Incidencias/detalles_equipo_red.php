<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $tipo = $_POST['tipo'];
    $puertos = $_POST['puertos'];
    $velocidad = $_POST['velocidad'];

    $query = "INSERT INTO detalles_equipo_red (id_equipo, tipo, puertos, velocidad)
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $id_equipo, $tipo, $puertos, $velocidad);

    if ($stmt->execute()) {
        header('Location: listar_equipos.php');
    } else {
        $error = "Error al guardar los detalles.";
    }
}

$equipos = $conn->query("SELECT id_equipo, modelo FROM equipos WHERE tipo = 'Equipo de Red'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Equipo de Red</title>
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
        <label>Puertos</label><input name="puertos" required>
        <label>Velocidad</label><input name="velocidad" required>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
