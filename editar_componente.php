<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_componente = $_GET['id'];
    
    // Obtener los detalles del componente
    $componente = $conn->query("SELECT * FROM componentes WHERE id_componente = $id_componente")->fetch_assoc();
    $equipos = $conn->query("SELECT id_equipo, modelo FROM equipos");

    if (!$componente) {
        die("Componente no encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $id_equipo = $_POST['id_equipo'];
    $id_componente = $_POST['id_componente'];

    // Actualizar los datos del componente
    $stmt = $conn->prepare("UPDATE componentes SET nombre = ?, tipo = ?, estado = ?, id_equipo = ? WHERE id_componente = ?");
    $stmt->bind_param("sssii", $nombre, $tipo, $estado, $id_equipo, $id_componente);
    $stmt->execute();
    $stmt->close();

    echo "Componente actualizado con éxito.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Componente</title>
</head>
<body>
    <h1>Editar Componente</h1>

    <form method="POST">
        <input type="hidden" name="id_componente" value="<?= $componente['id_componente'] ?>">

        <label>Nombre del Componente:</label>
        <input type="text" name="nombre" value="<?= $componente['nombre'] ?>" required><br><br>

        <label>Tipo de Componente:</label>
        <input type="text" name="tipo" value="<?= $componente['tipo'] ?>" required><br><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Nuevo" <?= $componente['estado'] == 'Nuevo' ? 'selected' : '' ?>>Nuevo</option>
            <option value="Usado" <?= $componente['estado'] == 'Usado' ? 'selected' : '' ?>>Usado</option>
            <option value="En Reparación" <?= $componente['estado'] == 'En Reparación' ? 'selected' : '' ?>>En Reparación</option>
        </select><br><br>

        <label>Seleccionar Equipo:</label>
        <select name="id_equipo" required>
            <option value="">Seleccione un equipo</option>
            <?php while ($row = $equipos->fetch_assoc()): ?>
                <option value="<?= $row['id_equipo'] ?>" <?= $componente['id_equipo'] == $row['id_equipo'] ? 'selected' : '' ?>><?= $row['modelo'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Actualizar Componente</button>
    </form>
</body>
</html>
