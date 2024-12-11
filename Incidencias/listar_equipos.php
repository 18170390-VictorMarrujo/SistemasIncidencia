<?php
include 'config.php'; // Incluir archivo de configuración para la conexión a la base de datos

// Consulta SQL para obtener los equipos con los datos asociados de aula, edificio y departamento
$sql = "SELECT 
            e.id_equipo, 
            e.tipo AS tipo_equipo, 
            e.descripcion, 
            e.modelo, 
            e.estado, 
            a.nombre AS aula, 
            ed.nombre AS edificio, 
            d.nombre AS departamento
        FROM equipos e
        INNER JOIN aulas a ON e.id_aula = a.id_aula
        INNER JOIN edificios ed ON a.id_edificio = ed.id_edificio
        INNER JOIN departamentos d ON ed.id_departamento = d.id_departamento";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Equipos</title>
    <link rel="stylesheet" href="css/fondo.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Equipos</h1>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Regresar al Dashboard</a>
        <a href="crear_equipo.php" class="btn btn-primary mb-3">Crear Nuevo Equipo</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                    <th>Aula</th>
                    <th>Edificio</th>
                    <th>Departamento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($equipo = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $equipo['id_equipo'] ?></td>
                            <td><?= $equipo['tipo_equipo'] ?></td>
                            <td><?= $equipo['descripcion'] ?></td>
                            <td><?= $equipo['modelo'] ?></td>
                            <td><?= $equipo['estado'] ?></td>
                            <td><?= $equipo['aula'] ?></td>
                            <td><?= $equipo['edificio'] ?></td>
                            <td><?= $equipo['departamento'] ?></td>
                            <td>
                                <a href="editar_equipo.php?id=<?= $equipo['id_equipo'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_equipo.php?id=<?= $equipo['id_equipo'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este equipo?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No hay equipos registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
