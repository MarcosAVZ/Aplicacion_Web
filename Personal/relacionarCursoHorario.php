<a href="CuHo.php">Volver</a>
<?php
// Datos de conexión a la base de datos
include '../Conexion.php';

// Conectarse a la base de datos
$conn = conectar();
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los cursos existentes
$cursosQuery = "SELECT id, nombre FROM curso";
$cursosResult = $conn->query($cursosQuery);

// Obtener los horarios existentes
$horariosQuery = "SELECT id, dia, horaInicio, horaFin FROM horario";
$horariosResult = $conn->query($horariosQuery);

// Comprobar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los IDs del formulario
    $idCurso = $_POST["curso"];
    $idHorario = $_POST["horario"];

    // Insertar los IDs en la tabla cursoHorario
    $insertQuery = "INSERT INTO cursohorario (idCurso, idHorario) VALUES ('$idCurso', '$idHorario')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Horario Cargado Exitosamente.";
    } else {
        echo "Error al insertar los IDs en la tabla cursoHorario: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Curso y Horario</title>
</head>
<body>
    <h2>Seleccionar Curso y Horario</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="curso">Curso:</label>
        <select name="curso" id="curso">
            <?php
            // Mostrar los cursos existentes en el formulario
            if ($cursosResult->num_rows > 0) {
                while ($row = $cursosResult->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                }
            }
            ?>
        </select>
        <br><br>
        <label for="horario">Horario:</label>
        <select name="horario" id="horario">
            <?php
            // Mostrar los horarios existentes en el formulario
            if ($horariosResult->num_rows > 0) {
                while ($row = $horariosResult->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["dia"] . " - " . $row["horaInicio"] . " a " . $row["horaFin"] . "</option>";
                }
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>