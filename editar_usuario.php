<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']);

    // Preparar la consulta para obtener el usuario
    $stmt = $conn->prepare("SELECT nombre, correo, tipo_usuario FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($nombre, $correo, $tipo_usuario);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "ID de usuario no especificado.";
    exit;
}

// Manejar la actualización del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, tipo_usuario = ? WHERE id_usuario = ?");
    $stmt->bind_param("sssi", $nombre, $correo, $tipo_usuario, $id_usuario);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario actualizado correctamente.'); window.location.href='listar_usuarios.php';</script>";
    } else {
        echo "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/fondo.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Usuario</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" id="correo" name="correo" class="form-control" value="<?= htmlspecialchars($correo) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select id="tipo_usuario" name="tipo_usuario" class="form-select" required>
                    <option value="administrador" <?= $tipo_usuario === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                    <option value="tecnico" <?= $tipo_usuario === 'tecnico' ? 'selected' : '' ?>>Técnico</option>
                    <option value="jefe_departamento" <?= $tipo_usuario === 'jefe_departamento' ? 'selected' : '' ?>>Jefe de Departamento</option>
                    <option value="usuario_final" <?= $tipo_usuario === 'usuario_final' ? 'selected' : '' ?>>Usuario Final</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="listar_usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
