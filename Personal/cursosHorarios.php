<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Cursos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <a href="personal.php">Volver</a>
</head>
<body>
    <h1>Tabla de Cursos</h1>
    <?php
    // Conexión a la base de datos. Aquí debes agregar tus propios detalles de conexión.
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "phpmyadmin";


    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta para obtener los cursos con sus aulas y horarios
    $sql = "SELECT c.curso, c.aula, h.dia, h.hora_inicio, h.hora_fin
            FROM cursos c
            INNER JOIN horario_curso hc ON c.id = hc.curso_id
            INNER JOIN horario h ON hc.horario_id = h.id";

    $result = $conn->query($sql);

    // Verificar si se encontraron registros
    if ($result->num_rows > 0) {
        // Imprimir la tabla
        echo "<table>
                <tr>
                    <th>Curso</th>
                    <th>Aula</th>
                    <th>Día</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                </tr>";
        // Recorrer los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["curso"]."</td>
                    <td>".$row["aula"]."</td>
                    <td>".$row["dia"]."</td>
                    <td>".$row["hora_inicio"]."</td>
                    <td>".$row["hora_fin"]."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron cursos.";
    }

    // Cerrar conexión
    $conn->close();
    ?>
</body>
</html>