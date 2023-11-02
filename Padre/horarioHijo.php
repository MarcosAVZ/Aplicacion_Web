<a href="padre.php">Volver</a>
<?php
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();

// Obtener el ID del padre (puedes obtenerlo mediante un formulario o cualquier otro método)
$idPadre = 1; // ID del padre (debes reemplazarlo por el valor correspondiente)

// Consulta para obtener los alumnos relacionados con el padre
$sqlAlumnos = "SELECT id, nombre FROM alumno WHERE idPadre = $idPadre";

$resultAlumnos = $conn->query($sqlAlumnos);

// Verificar si se encontraron resultados
if ($resultAlumnos->num_rows > 0) {
    // Mostrar la tabla de horarios para los alumnos encontrados
    echo "
        <table>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Aula</th>
                <th>Día</th>
                <th>Hora de inicio</th>
                <th>Hora de fin</th>
            </tr>
    ";

    // Recorrer los resultados y mostrar los horarios para cada alumno
    while ($rowAlumno = $resultAlumnos->fetch_assoc()) {
        $idAlumno = $rowAlumno['id'];
        $nombreAlumno = $rowAlumno['nombre'];

        // Consulta para obtener los horarios del alumno actual
        $sqlHorarios = "SELECT h.id, h.dia, h.horaInicio, h.horaFin, h.Aula, c.nombre AS nombre_curso
                        FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        INNER JOIN curso c ON ch.idCurso = c.id
                        INNER JOIN alumnocurso ac ON c.id = ac.idCurso
                        WHERE ac.idAlumno = $idAlumno";

        $resultHorarios = $conn->query($sqlHorarios);

        // Mostrar los horarios del alumno actual en forma de filas de la tabla
        while ($rowHorario = $resultHorarios->fetch_assoc()) {
            $nombreCurso = $rowHorario["nombre_curso"];
            $aula = $rowHorario["Aula"];
            $dia = $rowHorario["dia"];
            $horaInicio = $rowHorario["horaInicio"];
            $horaFin = $rowHorario["horaFin"];

            echo "
                <tr>
                    <td>$nombreAlumno</td>
                    <td>$nombreCurso</td>
                    <td>$aula</td>
                    <td>$dia</td>
                    <td>$horaInicio</td>
                    <td>$horaFin</td>
                </tr>
            ";
        }
    }

    echo "</table>";
} else {
    echo "No se encontraron alumnos vinculados al padre.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>