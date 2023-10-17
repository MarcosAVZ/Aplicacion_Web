
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Exámenes</title>
</head>
<body>
<a href="../Docente.php">volver</a>
<a href="calificar.php">Calificar</a>
<a href="cargarExamen.php">Cargar</a>
    <h1>Lista de Exámenes</h1>

    <table>
        <tr>
            <th>Examen</th>
            <th>Curso</th>
        </tr>

        <?php
        // Obtener los datos de los exámenes y cursos desde la base de datos
        require_once '../../conexion.php';

        $conn = conectar();

        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        $sql = "SELECT examen.nombre AS examen, cursos.curso AS curso FROM examen INNER JOIN cursos ON examen.materia_id = cursos.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["examen"] . "</td>";
                echo "<td>" . $row["curso"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No se encontraron exámenes.</td></tr>";
        }

        $conn->close();
        ?>

    </table>
</body>
</html>