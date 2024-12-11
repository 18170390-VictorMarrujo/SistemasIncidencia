<?php
include 'config.php';

// Obtener los componentes asociados a los equipos
$componentes = $conn->query("SELECT c.id_componente, c.nombre, c.tipo, c.estado, e.modelo AS equipo
                             FROM componentes c
                             JOIN equipos e ON c.id_equipo = e.id_equipo");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Componentes del Equipo</title>
</head>
<body>
    <h1>Componentes del Equipo</h1>

    <table>
        <tr>
            <th>Componente</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Equipo</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $componentes->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nombre'] ?></td>
                <td><?= $row['tipo'] ?></td>
                <td><?= $row['estado'] ?></td>
                <td><?= $row['equipo'] ?></td>
                <td>
                    <a href="editar_componente.php?id=<?= $row['id_componente'] ?>">Editar</a> |
                    <a href="eliminar_componente.php?id=<?= $row['id_componente'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="agregar_componente.php">Agregar nuevo componente</a>
</body>
</html>
