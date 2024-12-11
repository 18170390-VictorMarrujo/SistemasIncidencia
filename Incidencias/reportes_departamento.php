<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_departamento = $_POST['id_departamento'];

    // Incidencias por equipo en el departamento seleccionado
    $incidencias_equipo = $conn->query("SELECT equipos.modelo, COUNT(*) AS total
                                       FROM incidencias
                                       JOIN equipos ON incidencias.id_equipo = equipos.id_equipo
                                       WHERE equipos.id_departamento = ?
                                       GROUP BY equipos.modelo", array($id_departamento));
    
    // Incidencias por aula en el departamento seleccionado
    $incidencias_aula = $conn->query("SELECT aulas.nombre, COUNT(*) AS total
                                      FROM incidencias
                                      JOIN equipos ON incidencias.id_equipo = equipos.id_equipo
                                      JOIN aulas ON equipos.id_aula = aulas.id_aula
                                      WHERE aulas.id_departamento = ?
                                      GROUP BY aulas.nombre", array($id_departamento));
}

$departamentos = $conn->query("SELECT id_departamento, nombre FROM departamentos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes por Departamento</title>
</head>
<body>
    <h1>Reportes por Departamento</h1>

    <form method="POST">
        <label>Seleccione Departamento</label>
        <select name="id_departamento" required>
            <option value="">Seleccione un departamento</option>
            <?php while ($row = $departamentos->fetch_assoc()): ?>
                <option value="<?= $row['id_departamento'] ?>"><?= $row['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Generar Reporte</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2>Incidencias por Equipo</h2>
        <table>
            <tr>
                <th>Equipo</th>
                <th>Total Incidencias</th>
            </tr>
            <?php while ($row = $incidencias_equipo->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['modelo'] ?></td>
                    <td><?= $row['total'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Incidencias por Aula</h2>
        <table>
            <tr>
                <th>Aula</th>
                <th>Total Incidencias</th>
            </tr>
            <?php while ($row = $incidencias_aula->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['total'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>
