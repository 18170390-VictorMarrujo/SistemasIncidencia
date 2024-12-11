<?php
// Conexión a la base de datos
include 'config.php';

// Si se envió el formulario, procesar el componente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_componente = $_POST['tipo_componente'];
    $id_equipo = $_POST['id_equipo']; // ID del equipo relacionado

    // Verificar el tipo de detalle y procesar los datos
    switch ($tipo_componente) {
        case 'computadora':
            $procesador = $_POST['procesador'];
            $ram = $_POST['ram'];
            $almacenamiento = $_POST['almacenamiento'];
            $tarjeta_grafica = $_POST['tarjeta_grafica'];
            $sistema_operativo = $_POST['sistema_operativo'];

            $sql = "INSERT INTO detalles_computadora (id_equipo, procesador, ram, almacenamiento, tarjeta_grafica, sistema_operativo)
                    VALUES ('$id_equipo', '$procesador', '$ram', '$almacenamiento', '$tarjeta_grafica', '$sistema_operativo')";
            break;

        case 'proyector':
            $resolucion = $_POST['resolucion'];
            $brillo = $_POST['brillo'];
            $tipo_lampara = $_POST['tipo_lampara'];
            $vida_util_lampara = $_POST['vida_util_lampara'];
            $conectividad = $_POST['conectividad'];

            $sql = "INSERT INTO detalles_proyector (id_equipo, resolucion, brillo, tipo_lampara, vida_util_lampara, conectividad)
                    VALUES ('$id_equipo', '$resolucion', '$brillo', '$tipo_lampara', '$vida_util_lampara', '$conectividad')";
            break;

        case 'monitor':
            $tamano = $_POST['tamano'];
            $resolucion = $_POST['resolucion'];
            $tipo_panel = $_POST['tipo_panel'];
            $frecuencia_refresco = $_POST['frecuencia_refresco'];
            $puertos = $_POST['puertos'];

            $sql = "INSERT INTO detalles_monitor (id_equipo, tamano, resolucion, tipo_panel, frecuencia_refresco, puertos)
                    VALUES ('$id_equipo', '$tamano', '$resolucion', '$tipo_panel', '$frecuencia_refresco', '$puertos')";
            break;

        case 'periferico':
            $tipo_periferico = $_POST['tipo_periferico'];
            $conexion = $_POST['conexion'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $especificaciones = $_POST['especificaciones'];

            $sql = "INSERT INTO detalles_periferico (id_equipo, tipo_periferico, conexion, marca, modelo, especificaciones)
                    VALUES ('$id_equipo', '$tipo_periferico', '$conexion', '$marca', '$modelo', '$especificaciones')";
            break;

        case 'red':
            $tipo_dispositivo = $_POST['tipo_dispositivo'];
            $puertos = $_POST['puertos'];
            $velocidad = $_POST['velocidad'];
            $soporte_protocolos = $_POST['soporte_protocolos'];

            $sql = "INSERT INTO detalles_red (id_equipo, tipo_dispositivo, puertos, velocidad, soporte_protocolos)
                    VALUES ('$id_equipo', '$tipo_dispositivo', '$puertos', '$velocidad', '$soporte_protocolos')";
            break;
    }

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Componente agregado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Componentes</title>
    <link rel="stylesheet" href="css/fondo.css">
</head>
<body>
<div class="container mt-5">
    <h2>Gestión de Componentes</h2>
    <form method="POST" id="formComponentes">
        <!-- Selección del tipo de detalle -->
        <div class="mb-3">
            <label for="tipo_componente" class="form-label">Tipo de Componente</label>
            <select id="tipo_componente" name="tipo_componente" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="computadora">Computadora</option>
                <option value="proyector">Proyector</option>
                <option value="monitor">Monitor</option>
                <option value="periferico">Periférico</option>
                <option value="red">Red</option>
            </select>
        </div>

        <!-- Campos dinámicos -->
        <div id="form_dinamico"></div>

        <!-- ID del equipo -->
        <div class="mb-3">
            <label for="id_equipo" class="form-label">ID del Equipo</label>
            <input type="number" id="id_equipo" name="id_equipo" class="form-control" required>
        </div>

        <!-- Botón para enviar -->
        <button type="submit" class="btn btn-primary">Agregar Componente</button>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Regresar al Dashboard</a>
    </form>
</div>

<script>
    const formDinamico = document.getElementById("form_dinamico");
    const tipoComponente = document.getElementById("tipo_componente");

    tipoComponente.addEventListener("change", () => {
        const tipo = tipoComponente.value;
        formDinamico.innerHTML = ""; // Limpiar formulario dinámico

        switch (tipo) {
            case "computadora":
                formDinamico.innerHTML = `
                    <div class="mb-3"><label>Procesador</label><input name="procesador" class="form-control" required></div>
                    <div class="mb-3"><label>RAM</label><input name="ram" class="form-control" required></div>
                    <div class="mb-3"><label>Almacenamiento</label><input name="almacenamiento" class="form-control" required></div>
                    <div class="mb-3"><label>Tarjeta Gráfica</label><input name="tarjeta_grafica" class="form-control"></div>
                    <div class="mb-3"><label>Sistema Operativo</label><input name="sistema_operativo" class="form-control"></div>
                `;
                break;
            case "proyector":
                formDinamico.innerHTML = `
                    <div class="mb-3"><label>Resolución</label><input name="resolucion" class="form-control" required></div>
                    <div class="mb-3"><label>Brillo</label><input name="brillo" class="form-control" required></div>
                    <div class="mb-3"><label>Tipo de Lámpara</label><input name="tipo_lampara" class="form-control"></div>
                    <div class="mb-3"><label>Vida Útil de Lámpara</label><input name="vida_util_lampara" class="form-control"></div>
                    <div class="mb-3"><label>Conectividad</label><input name="conectividad" class="form-control"></div>
                `;
                break;
            case "monitor":
                formDinamico.innerHTML = `
                    <div class="mb-3"><label>Tamaño</label><input name="tamano" class="form-control" required></div>
                    <div class="mb-3"><label>Resolución</label><input name="resolucion" class="form-control" required></div>
                    <div class="mb-3"><label>Tipo de Panel</label><input name="tipo_panel" class="form-control"></div>
                    <div class="mb-3"><label>Frecuencia de Refresco</label><input name="frecuencia_refresco" class="form-control"></div>
                    <div class="mb-3"><label>Puertos</label><input name="puertos" class="form-control"></div>
                `;
                break;
            case "periferico":
                formDinamico.innerHTML = `
                    <div class="mb-3"><label>Tipo</label><input name="tipo_periferico" class="form-control" required></div>
                    <div class="mb-3"><label>Conexión</label><input name="conexion" class="form-control" required></div>
                    <div class="mb-3"><label>Marca</label><input name="marca" class="form-control"></div>
                    <div class="mb-3"><label>Modelo</label><input name="modelo" class="form-control"></div>
                    <div class="mb-3"><label>Especificaciones</label><textarea name="especificaciones" class="form-control"></textarea></div>
                `;
                break;
            case "red":
                formDinamico.innerHTML = `
                    <div class="mb-3"><label>Tipo de Dispositivo</label><input name="tipo_dispositivo" class="form-control" required></div>
                    <div class="mb-3"><label>Puertos</label><input name="puertos" class="form-control" required></div>
                    <div class="mb-3"><label>Velocidad</label><input name="velocidad" class="form-control"></div>
                    <div class="mb-3"><label>Soporte de Protocolos</label><input name="soporte_protocolos" class="form-control"></div>
                `;
                break;
        }
    });
</script>
</body>
</html>
