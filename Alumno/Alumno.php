<a href="../index.php">Cerrar Sesion</a>
<?php
session_start();
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();

// Obtener id del alumno (por ej. de la URL)
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del alumnos de la variable de sesión
    $id_alumno = $_SESSION['user_id'];
  
    // Obtener el nombre del alumnos de la base de datos
    $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
    $query = "SELECT nombre FROM alumnos WHERE id = $id_alumno";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $nombrealumnos = $row['nombre'];
  
    // Imprimir el mensaje de bienvenida
    echo "Hola $nombrealumnos, bienvenido al Área del alumno.";
  } else {
    // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
    header('Location: ../index.php');
    exit();
  }
// Consulta JOIN para obtener datos
$sql = "SELECT DISTINCT c.curso, h.dia, h.hora_inicio, h.hora_fin, c.aula
        FROM alumnos a
        INNER JOIN horario_curso hc ON a.id = hc.curso_id
        INNER JOIN cursos c ON hc.curso_id = c.id
        INNER JOIN horario h ON hc.horario_id = h.id
        WHERE a.id = $id_alumno ";

$result = $conn->query($sql);
?>

<h1>Cursos matriculados</h1>

<table>
    <thead>
        <tr>
            <th>Curso</th>
            <th>Día</th>
            <th>Hora inicio</th>
            <th>Hora fin</th>
            <th>Aula</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["curso"]; ?></td>
            <td><?php echo $row["dia"]; ?></td>  
            <td><?php echo $row["hora_inicio"]; ?></td>
            <td><?php echo $row["hora_fin"]; ?></td>
            <td><?php echo $row["aula"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php $conn->close(); ?>

<a href="boletin.php">Boletin</a>