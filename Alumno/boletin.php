<?php
session_start();
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();

// Obtener id del alumno (por ej. de la URL)
// Obtener id del alumno (por ej. de la URL)
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del alumno de la variable de sesión
    $id_alumno = $_SESSION['user_id'];
} else {
    // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
    header('Location: Alumno.php');
    exit();
}

// Consulta JOIN para obtener datos del boletín
$sql = "SELECT DISTINCT alumnos.nombre AS alumno_nombre, cursos.curso, examen.nombre AS examen_nombre, nota.valor AS nota
FROM alumnos
INNER JOIN alumnoscursos ON alumnos.id = alumnoscursos.alumno_id
INNER JOIN cursos ON alumnoscursos.curso_id = cursos.id
INNER JOIN examen ON cursos.id = examen.materia_id
INNER JOIN nota ON examen.id = nota.examen_id
WHERE alumnos.id = " . $id_alumno;

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error executing the query: ' . mysqli_error($conn));
}
?>

<h1>Boletín de notas</h1>

<table>
    <thead>
        <tr>
            <th>Curso</th>
            <th>Examen</th>
            <th>Nota</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["curso"]; ?></td>
                <td><?php echo $row["examen_nombre"]; ?></td>  
                <td><?php echo $row["nota"]; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $conn->close(); ?>