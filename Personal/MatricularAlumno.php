<!DOCTYPE html>
<html>
<head>
    <title>Crear Nuevo Alumno</title>
</head>
<body>
    <h1>Crear Nuevo Alumno</h1>
    <form action="MatricularAlumno.php" method="post">
        <label for="correo">Correo:</label>
        <input type="text" name="correo" id="correo" required><br>

        <label for="idPadre">Padre:</label>
        <select name="idPadre" id="idPadre" required>
            <?php
            // Conexión a la base de datos
            require_once '../Conexion.php';
            $conexion = conectar();

            // Consulta para obtener la lista de padres
            $consultaPadres = "SELECT id, nombre FROM padre";
            $resultadoPadres = $conexion->query($consultaPadres);

            if ($resultadoPadres->num_rows > 0) {
                while ($fila = $resultadoPadres->fetch_assoc()) {
                    echo '<option value="' . $fila['id'] . '">' . $fila['nombre'] . '</option>';
                }
            }

            // Cerrar la conexión a la base de datos
            $conexion->close();
            ?>
        </select><br>

        <label for="legajo">Legajo:</label>
        <input type="text" name="legajo" id="legajo" required><br>

        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <input type="submit" value="Crear Alumno">
    </form>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST["correo"];
    $password = $_POST["correo"];
    $idPadre = $_POST["idPadre"];
    $legajo = $_POST["legajo"];
    $nombre = $_POST["nombre"];

    // Consulta SQL para insertar el nuevo alumno
    $consulta = "INSERT INTO alumno (correo, password, idPadre, legajo, nombre) VALUES ('$correo', '$password', $idPadre, $legajo, '$nombre')";

    if ($conexion->query($consulta) === TRUE) {
        echo "Nuevo alumno creado con éxito.";
    } else {
        echo "Error al crear el alumno: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>