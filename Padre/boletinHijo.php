<a href="padre.php">Volver</a>

<?php
// Conexión a la base de datos
require '../conexion.php';

$conn = conectar();


// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener los alumnos vinculados al padre
$idPadre = 1; // ID del padre (debes reemplazarlo por el valor correspondiente)
$sql = "SELECT alumno.nombre AS nombre_alumno, curso.nombre AS nombre_curso, examen.nombre AS nombre_examen, examenalumno.nota
        FROM alumno
        INNER JOIN alumnocurso ON alumno.id = alumnocurso.idAlumno
        INNER JOIN examen ON alumnocurso.idCurso = examen.idCurso
        INNER JOIN examenalumno ON alumno.id = examenalumno.idAlumno AND examen.id = examenalumno.idExamen
        INNER JOIN curso ON examen.idCurso = curso.id
        WHERE alumno.idPadre = $idPadre";

$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Mostrar la tabla con los datos de los alumnos y sus notas
    echo "<table>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Examen</th>
                <th>Nota</th>
            </tr>";

    // Recorrer los resultados y mostrar los datos en filas de la tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["nombre_alumno"] . "</td>
                <td>" . $row["nombre_curso"] . "</td>
                <td>" . $row["nombre_examen"] . "</td>
                <td>" . $row["nota"] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron alumnos vinculados al padre.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>