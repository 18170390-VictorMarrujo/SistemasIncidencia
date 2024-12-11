<?php
session_start();
require 'config.php'; // Archivo con la conexión a la base de datos

$_SESSION['id_usuario'] = $usuario['id_usuario']; // Supongamos que $usuario contiene los datos del usuario autenticado
$_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
$id_jefe = $_SESSION['id_usuario']; // ID del jefe de departamento

// Obtener los equipos del departamento del jefe
$sql_equipos = "
    SELECT equipos.id_equipo, equipos.descripcion, aulas.nombre AS aula, edificios.nombre AS edificio
    FROM equipos
    JOIN aulas ON equipos.id_aula = aulas.id_aula
    JOIN edificios ON aulas.id_edificio = edificios.id_edificio
    JOIN departamentos ON edificios.id_departamento = departamentos.id_departamento
    WHERE departamentos.jefe_departamento = ?;
";
$stmt = $conn->prepare($sql_equipos);
$stmt->bind_param('i', $id_jefe);
$stmt->execute();
$result_equipos = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Incidencias</title>
</head>
<body>
    <h1>Reporte de Incidencias</h1>
    <form action="guardar_incidencia.php" method="POST">
        <label for="equipo">Equipo afectado:</label>
        <select name="id_equipo" id="equipo" required>
            <option value="">Seleccione un equipo</option>
            <?php while ($equipo = $result_equipos->fetch_assoc()): ?>
                <option value="<?= $equipo['id_equipo'] ?>">
                    <?= $equipo['descripcion'] ?> (Aula: <?= $equipo['aula'] ?>, Edificio: <?= $equipo['edificio'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <label for="titulo">Título de la incidencia:</label>
        <input type="text" id="titulo" name="titulo" maxlength="150" required>
        <br><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
        <br><br>
        <label for="prioridad">Prioridad:</label>
        <select name="prioridad" id="prioridad" required>
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
            <option value="critica">Crítica</option>
        </select>
        <br><br>
        <button type="submit">Reportar incidencia</button>
    </form>
</body>
</html>
