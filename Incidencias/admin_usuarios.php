<?php
session_start();
if ($_SESSION['tipo_usuario'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

include 'config.php';

$query = "SELECT id_usuario, nombre, correo, tipo_usuario FROM usuarios";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Gestión de Usuarios</h3>
    <a href="crear_usuario.php" class="btn btn-success mb-3">Crear Usuario</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_usuario']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row['tipo_usuario']; ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $row['id_usuario']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="eliminar_usuario.php?id=<?php echo $row['id_usuario']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
