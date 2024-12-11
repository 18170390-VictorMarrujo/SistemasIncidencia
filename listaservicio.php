<?php
include 'config.php';

// Obtener incidencia y tipo de equipo
$id_incidencia = $_GET['id_incidencia']; // ID de la incidencia
$query = "
    SELECT i.id_incidencia, i.titulo, e.tipo AS tipo_equipo
    FROM incidencias i
    INNER JOIN equipos e ON i.id_equipo = e.id_equipo
    WHERE i.id_incidencia = $id_incidencia
";
$result = mysqli_query($conn, $query);
$incidencia = mysqli_fetch_assoc($result);

// Obtener lista de servicios disponibles para el tipo de equipo
$tipo_equipo = $incidencia['tipo_equipo'];
$query_servicios = "SELECT * FROM servicios WHERE tipo_equipo = '$tipo_equipo'";
$servicios = mysqli_query($conn, $query_servicios);

// Guardar los servicios seleccionados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicios_seleccionados = $_POST['servicios']; // Array de IDs de servicios seleccionados

    foreach ($servicios_seleccionados as $id_servicio) {
        $query_insert = "INSERT INTO incidencia_servicio (id_incidencia, id_servicio) VALUES ($id_incidencia, $id_servicio)";
        mysqli_query($conn, $query_insert);
    }

    echo "<div class='alert alert-success'>Servicios asignados correctamente.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Servicios a la Incidencia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Servicios para la Incidencia: <?php echo $incidencia['titulo']; ?></h2>
    <p><strong>Tipo de Equipo:</strong> <?php echo ucfirst($tipo_equipo); ?></p>

    <form method="POST">
        <h3>Servicios Disponibles</h3>
        <?php while ($servicio = mysqli_fetch_assoc($servicios)): ?>
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="servicios[]" 
                    value="<?php echo $servicio['id_servicio']; ?>" 
                    id="servicio_<?php echo $servicio['id_servicio']; ?>"
                >
                <label class="form-check-label" for="servicio_<?php echo $servicio['id_servicio']; ?>">
                    <?php echo $servicio['nombre_servicio']; ?> 
                    (Complejidad: <?php echo ucfirst($servicio['complejidad']); ?>, 
                    Tiempo Estimado: <?php echo $servicio['tiempo_estimado']; ?> minutos)
                </label>
            </div>
        <?php endwhile; ?>

        <button type="submit" class="btn btn-primary mt-3">Asignar Servicios</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
