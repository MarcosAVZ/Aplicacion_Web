<a href="Alumno.php">Volver</a>
<?php
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();
$idAlumno = 1; // Ejemplo: ID del alumno actualmente logueado

// Consulta para obtener los cursos vinculados al alumno
$sqlCursos = "SELECT c.id, c.nombre
              FROM curso c
              INNER JOIN alumnocurso ac ON c.id = ac.idCurso
              WHERE ac.idAlumno = $idAlumno";

$resultCursos = $conn->query($sqlCursos);

?>

<!-- Formulario para seleccionar un curso -->
<form method="POST" action="">
    <label for="curso">Selecciona un curso:</label>
    <select name="curso" id="curso">
        <option value="mostrar_todo">Mostrar todo</option>
        <?php while ($row = $resultCursos->fetch_assoc()) : ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Mostrar exámenes y notas</button>
</form>

<?php
// Verificar si se seleccionó un curso
if (isset($_POST['curso'])) {
    $idCursoSeleccionado = $_POST['curso'];

    if ($idCursoSeleccionado == 'mostrar_todo') {
        // Consulta para obtener todas las notas del alumno
        $sqlNotas = "SELECT e.nombre, ea.nota, c.nombre AS nombre_curso
                     FROM examen e
                     INNER JOIN examenAlumno ea ON e.id = ea.idExamen
                     INNER JOIN curso c ON e.idCurso = c.id
                     WHERE ea.idAlumno = $idAlumno";

        $resultNotas = $conn->query($sqlNotas);

        // Mostrar todas las notas en forma de tabla
        if ($resultNotas->num_rows > 0) {
            echo "<h2>Todas las notas del alumno:</h2>";
            echo "<table>
                    <tr>
                        <th>Examen</th>
                        <th>Nota</th>
                        <th>Curso</th>
                    </tr>";

            while ($row = $resultNotas->fetch_assoc()) {
                $nombreExamen = $row["nombre"];
                $notaExamen = $row["nota"];
                $nombreCurso = $row["nombre_curso"];

                echo "<tr>
                        <td>$nombreExamen</td>
                        <td>$notaExamen</td>
                        <td>$nombreCurso</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron notas para el alumno.";
        }
    } else {
        // Consulta para obtener los exámenes y notas del alumno en el curso seleccionado
        $sqlExamenes = "SELECT e.nombre, ea.nota, c.nombre AS nombre_curso
                        FROM examen e
                        INNER JOIN examenAlumno ea ON e.id = ea.idExamen
                        INNER JOIN curso c ON e.idCurso = c.id
                        WHERE ea.idAlumno = $idAlumno AND e.idCurso = $idCursoSeleccionado";

        $resultExamenes = $conn->query($sqlExamenes);

        // Mostrar los resultados en forma de tabla
        if ($resultExamenes->num_rows > 0) {
            echo "<h2>Notas del alumno en el curso seleccionado:</h2>";
            echo "<table>
                    <tr>
                        <th>Examen</th>
                        <th>Nota</th>
                        <th>Curso</th>
                    </tr>";

            while ($row = $resultExamenes->fetch_assoc()) {
                $nombreExamen = $row["nombre"];
                $notaExamen = $row["nota"];
                $nombreCurso = $row["nombre_curso"];

                echo "<tr>
                        <td>$nombreExamen</td>
                        <td>$notaExamen</td>
                        <td>$nombreCurso</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron exámenes para el curso seleccionado.";
        }
    }
}

?>



<?php
    $conn->close();
?>