<!DOCTYPE html>
<html>
<head>
    <title>Crear Nuevo Padre</title>
</head>
<body>
    <h1>Crear Nuevo Padre</h1>
    <form action="MatricularPadre.php" method="post">
        <label for="correo">Correo:</label>
        <input type="text" name="correo" id="correo" required><br>

        <label for="legajo">Legajo:</label>
        <input type="text" name="legajo" id="legajo" required><br>

        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <input type="submit" value="Crear Padre">
    </form>
</body>
</html>

<?php
    require '../Conexion.php'; // Asegúrate de que este archivo tenga la función conectar() para conectarte a la base de datos
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $correo = $_POST["correo"];
        $password = $_POST["correo"];
        $legajo = $_POST["legajo"];
        $nombre = $_POST["nombre"];
    
        // Consulta SQL para insertar el nuevo alumno
        $consulta = "INSERT INTO padre (correo, password, legajo, nombre) VALUES ('$correo', '$password', $legajo, '$nombre')";
    
        if ($conexion->query($consulta) === TRUE) {
            echo "Nuevo alumno creado con éxito.";
        } else {
            echo "Error al crear el alumno: " . $conexion->error;
        }
    
        // Cerrar la conexión a la base de datos
        $conexion->close();
    }
    ?>
