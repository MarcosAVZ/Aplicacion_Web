<a href="Alumno.php">Volver</a>
<?php
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();

// Obtener el ID del alumno (puedes obtenerlo de la sesión o de alguna otra manera)
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
    <button type="submit">Mostrar horarios</button>
</form>

<?php
// Verificar si se seleccionó un curso
if (isset($_POST['curso'])) {
    $idCursoSeleccionado = $_POST['curso'];

    if ($idCursoSeleccionado == 'mostrar_todo') {
        // Consulta para obtener todos los horarios de todos los cursos vinculados al alumno
        $sqlHorarios = "SELECT h.id, h.dia, h.horaInicio, h.horaFin, h.Aula, c.nombre AS nombre_curso
                        FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        INNER JOIN curso c ON ch.idCurso = c.id
                        WHERE ch.idCurso IN (
                            SELECT ac.idCurso
                            FROM alumnocurso ac
                            WHERE ac.idAlumno = $idAlumno
                        )";

        $resultHorarios = $conn->query($sqlHorarios);

        // Mostrar los resultados en forma de tabla
        if ($resultHorarios->num_rows > 0) {
            echo "<h2>Horarios de todos los cursos:</h2>";
            echo "<table>
                    <tr>
                        <th>Curso</th>
                        <th>Aula</th>
                        <th>Día</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                    </tr>";

            while ($row = $resultHorarios->fetch_assoc()) {
                $nombreCurso = $row["nombre_curso"];
                $aula = $row["Aula"];
                $dia = $row["dia"];
                $horaInicio = $row["horaInicio"];
                $horaFin = $row["horaFin"];

                echo "<tr>
                        <td>$nombreCurso</td>
                        <td>$aula</td>
                        <td>$dia</td>
                        <td>$horaInicio</td>
                        <td>$horaFin</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron horarios para los cursos vinculados al alumno.";
        }
    } else {
        // Consulta para obtener los horarios del curso seleccionado
        $sqlHorarios = "SELECT h.id, h.dia, h.horaInicio, h.horaFin, h.Aula, c.nombre AS nombre_curso
                        FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        INNER JOIN curso c ON ch.idCurso = c.id
                        WHERE ch.idCurso = $idCursoSeleccionado";

        $resultHorarios = $conn->query($sqlHorarios);

        // Mostrar los resultados en forma de tabla
        if ($resultHorarios->num_rows > 0) {
            echo "<h2>Horarios del curso seleccionado:</h2>";
            echo "<table>
                    <tr>
                        <th>Curso</th>
                        <th>Aula</th>
                        <th>Día</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                    </tr>";

            while ($row = $resultHorarios->fetch_assoc()) {
                $nombreCurso = $row["nombre_curso"];
                $aula = $row["Aula"];
                $dia = $row["dia"];
                $horaInicio = $row["horaInicio"];
                $horaFin = $row["horaFin"];

                echo "<tr>
                        <td>$nombreCurso</td>
                        <td>$aula</td>
                        <td>$dia</td>
                        <td>$horaInicio</td>
                        <td>$horaFin</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron horarios para el curso seleccionado.";
        }
    }
}

?>


<?php
    $conn->close();
?>