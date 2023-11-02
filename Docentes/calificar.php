<?php
/*session_start();

// Verificar si el docente ha iniciado sesión
if (!isset($_SESSION['docente_id'])) {
    // El docente no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: iniciar_sesion.php");
    exit();
}
*/
// Obtener el ID del docente de la sesión
$docenteId = 1;

// Obtener las materias vinculadas al docente desde la base de datos
include '../Conexion.php';

// Conectarse a la base de datos
$conn = conectar();

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Obtener las materias vinculadas al docente
$sql = "SELECT c.id, c.nombre AS nombre
        FROM curso AS c
        JOIN cursodocente AS cd ON c.id = cd.idCurso
        JOIN docente AS d ON cd.idDocente = d.id
        WHERE d.id = '$docenteId'";
$result = $conn->query($sql);

// Verificar si se encontraron materias
if ($result->num_rows > 0) {
    // Materias encontradas, generar opciones para el elemento select
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $idMateria = $row['id'];
        $nombreMateria = $row['nombre'];
        $options .= "<option value='$idMateria'>$nombreMateria</option>";
    }
} else {
    // No se encontraron materias vinculadas al docente
    $options = "<option value='' disabled selected>No hay materias disponibles</option>";
}

// Cerrar la conexión a la base de datos
$conn->close();

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreExamen = $_POST["nombre_examen"];
    $idMateria = $_POST["id_materia"];
    
    // Conectarse a la base de datos nuevamente
    $conn = conectar();

    // Verificar si hay errores en la conexión
    if ($conn->connect_error) {
        die("Error en la conexión a la base de datos: " . $conn->connect_error);
    }

    // Insertar el nuevo examen en la tabla "examen"
    $sql = "INSERT INTO examen (nombre, idCurso, idDocente) VALUES ('$nombreExamen', '$idMateria', '$docenteId')";

    if ($conn->query($sql) === true) {
        echo "El examen se ha guardado correctamente.";
    } else {
        echo "Error al guardar el examen: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

<!-- Formulario HTML -->
<form method="POST" action="">
    <label for="nombre_examen">Nombre del examen:</label>
    <input type="text" name="nombre_examen" required><br>

    <label for="id_materia">Materia:</label>
    <select name="id_materia" required>
        <?php echo $options; ?>
    </select><br>

    <input type="submit" value="Guardar">
</form>

<a href="Examen.php">Volver</a>