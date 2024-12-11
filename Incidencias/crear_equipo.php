<?php
include 'config.php'; // Incluir archivo de configuración para la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $modelo = $_POST['modelo'];
    $numero_serie = $_POST['numero_serie'];
    $fecha_adquisicion = $_POST['fecha_adquisicion'];
    $garantia = $_POST['garantia'];
    $estado = $_POST['estado'];
    $id_aula = $_POST['id_aula'];

    // Consulta SQL para insertar el nuevo equipo
    $sql = "INSERT INTO equipos (tipo, descripcion, modelo, numero_serie, fecha_adquisicion, garantia, estado, id_aula) 
            VALUES ('$tipo', '$descripcion', '$modelo', '$numero_serie', '$fecha_adquisicion', '$garantia', '$estado', '$id_aula')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo equipo creado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Equipo</title>
    <link rel="stylesheet" href="css/fondo.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Crear Nuevo Equipo</h1>
        <form action="crear_equipo.php" method="POST">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="computadora">Computadora</option>
                    <option value="proyector">Proyector</option>
                    <option value="monitor">Monitor</option>
                    <option value="periférico">Periférico</option>
                    <option value="red">Red</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" id="modelo" name="modelo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="numero_serie" class="form-label">Número de Serie</label>
                <input type="text" id="numero_serie" name="numero_serie" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="garantia" class="form-label">Garantía</label>
                <input type="date" id="garantia" name="garantia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-control" required>
                    <option value="funcional">Funcional</option>
                    <option value="en_reparacion">En reparación</option>
                    <option value="fuera_de_servicio">Fuera de servicio</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_aula" class="form-label">Aula</label>
                <select id="id_aula" name="id_aula" class="form-control" required>
                    <?php
                    // Obtener las aulas disponibles de la base de datos
                    $aulas_sql = "SELECT id_aula, nombre FROM aulas";
                    $aulas_result = $conn->query($aulas_sql);
                    while ($aula = $aulas_result->fetch_assoc()) {
                        echo "<option value='" . $aula['id_aula'] . "'>" . $aula['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Equipo</button>
            <a href="listar_equipos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
