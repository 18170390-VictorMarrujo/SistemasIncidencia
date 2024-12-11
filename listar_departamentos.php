<?php
session_start();
if ($_SESSION['tipo_usuario'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

include 'config.php';

$query = "SELECT d.id_departamento, d.nombre AS departamento, u.nombre AS jefe 
          FROM departamentos d 
          LEFT JOIN usuarios u ON d.id_jefe = u.id_usuario";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Departamentos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Departamentos</h3>
    <a href="crear_departamento.php" class="btn btn-primary mb-3">Crear Departamento</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Jefe</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['departamento']; ?></td>
                    <td><?php echo $row['jefe'] ?? 'Sin jefe asignado'; ?></td>
                    <td>
                        <a href="editar_departamento.php?id=<?php echo $row['id_departamento']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar_departamento.php?id=<?php echo $row['id_departamento']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este departamento?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
