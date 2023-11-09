<!DOCTYPE html>
<html>
<head>
    <title>Agregar Examen</title>
</head>
<body>
    <a href="examenes.php">volver</a>
    <h1>Agregar Examen</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $materia = $_POST["materia"];
        $nombreExamen = $_POST["nombreExamen"];

        // Realizar la conexión a la base de datos
        require_once '../../conexion.php';

        $conn = conectar();

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        // Insertar el examen en la tabla "examen"
        $sql = "INSERT INTO examen (nombre, materia_id) VALUES ('$nombreExamen', '$materia')";

        if ($conn->query($sql) === TRUE) {
            echo "El examen se ha agregado correctamente.";
        } else {
            echo "Error al agregar el examen: " . $conn->error;
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    }
    ?>
</body>
</html>