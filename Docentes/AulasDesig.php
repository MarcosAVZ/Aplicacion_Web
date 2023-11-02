<a href="Docente.php">Volver</a>
<?php
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();

// ID del docente (conocido de antemano)
$docenteId = 1;

// Consulta para obtener los cursos vinculados al docente
$sql = "SELECT c.id, c.nombre FROM curso c
        INNER JOIN cursodocente cd ON c.id = cd.idCurso
        WHERE cd.idDocente = $docenteId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los cursos y sus horarios en forma de tabla
    echo "<table>
            <tr>
                <th>Curso</th>
                <th>Día</th>
                <th>Horario de inicio</th>
                <th>Horario de fin</th>
                <th>Aula</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $cursoId = $row["id"];
        $cursoNombre = $row["nombre"];

        // Consulta para obtener los horarios vinculados al curso
        $horariosSql = "SELECT h.dia, h.horaInicio, h.horaFin, h.Aula FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        WHERE ch.idCurso = $cursoId";

        $horariosResult = $conn->query($horariosSql);

        while ($horarioRow = $horariosResult->fetch_assoc()) {
            $horarioDia = $horarioRow["dia"];
            $horarioInicio = $horarioRow["horaInicio"];
            $horarioFin = $horarioRow["horaFin"];
            $Aulas = $horarioRow["Aula"];

            echo "<tr>
                    <td>$cursoNombre</td>
                    <td>$horarioDia</td>
                    <td>$horarioInicio</td>
                    <td>$horarioFin</td>
                    <td>$Aulas</td>
                </tr>";
        }
    }

    echo "</table>";
} else {
    echo "No se encontraron cursos vinculados al docente.";
}

$conn->close();
?>