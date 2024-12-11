<?php
// Incluir archivo de conexión
include 'config.php';

// Obtener las incidencias terminadas (estado 'cerrada') que no han sido evaluadas
$sql_incidencias = "SELECT i.id_incidencia, i.titulo 
                    FROM incidencias i
                    LEFT JOIN evaluaciones e ON i.id_incidencia = e.id_incidencia
                    WHERE i.estado = 'cerrada' AND e.id_incidencia IS NULL";

$result_incidencias = $conn->query($sql_incidencias);

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_incidencia = $_POST['id_incidencia'];
    $id_jefe = $_POST['id_jefe']; // En un sistema real, este ID debería obtenerse de la sesión
    $calificacion = $_POST['calificacion'];
    $comentarios = $_POST['comentarios'];

    // Comprobar si todos los campos están completos
    if (!empty($id_incidencia) && !empty($id_jefe) && !empty($calificacion)) {
        // Insertar evaluación en la base de datos
        $sql_insert = "INSERT INTO evaluaciones (id_incidencia, id_jefe, calificacion, comentarios) 
                       VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("iiis", $id_incidencia, $id_jefe, $calificacion, $comentarios);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>¡Evaluación registrada exitosamente!</p>";
        } else {
            echo "<p style='color: red;'>Error al registrar la evaluación: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Por favor, complete todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluar Incidencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        select, input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Evaluar Incidencia</h1>
    <form action="evaluar_incidencia.php" method="POST">
        <label for="id_incidencia">Incidencia a evaluar:</label>
        <select id="id_incidencia" name="id_incidencia" required>
            <option value="">Seleccione una incidencia</option>
            <?php
            if ($result_incidencias->num_rows > 0) {
                while ($row = $result_incidencias->fetch_assoc()) {
                    echo "<option value='" . $row['id_incidencia'] . "'>" . htmlspecialchars($row['titulo']) . "</option>";
                }
            } else {
                echo "<option value=''>No hay incidencias cerradas disponibles para evaluación</option>";
            }
            ?>
        </select>

        <label for="id_jefe">ID del jefe evaluador:</label>
        <input type="number" id="id_jefe" name="id_jefe" required placeholder="Ingresa tu ID">

        <label for="calificacion">Calificación (1-5):</label>
        <select id="calificacion" name="calificacion" required>
            <option value="">Seleccione una calificación</option>
            <option value="1">1 - Muy malo</option>
            <option value="2">2 - Malo</option>
            <option value="3">3 - Regular</option>
            <option value="4">4 - Bueno</option>
            <option value="5">5 - Excelente</option>
        </select>

        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios" rows="4" placeholder="Escribe tus comentarios aquí..."></textarea>

        <button type="submit">Registrar Evaluación</button>
        <a href="jefe_dashboard.php">Regresar</a>
    </form>
</body>
</html>
