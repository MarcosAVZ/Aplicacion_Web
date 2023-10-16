<!DOCTYPE html>
<html>
<head>
    <title>Aulas Designadas</title>
</head>
<body>
    <h1>Aulas Designadas</h1>
    <a href="Docente.php">Volver</a>
    <?php
    // Obtener el ID del docente actual (puedes reemplazar esto con tu lógica de autenticación)
    require_once '../conexion.php';

    $conn = conectar();
    // Verificar la conexión
    session_start();

    // Verificar si el usuario está autenticado como docente
    if (isset($_SESSION['user_id'])) {
        // Obtener el ID del docente de la variable de sesión
        $docente_Id = $_SESSION['user_id'];
    } else {
        // Manejar el caso en el que el docente no esté autenticado
        // Puedes redirigirlo a una página de inicio de sesión o mostrar un mensaje de error
        die("Docente no autenticado");
    }

    // Obtener los cursos vinculados al docente
    $sql = "SELECT DISTINCT cursos.id, cursos.curso, cursos.aula
            FROM cursos
            INNER JOIN docentes_cursos ON cursos.id = docentes_cursos.id_curso
            WHERE docentes_cursos.id_docente = $docente_Id";

    $result = $conn->query($sql);

    // Crear el selector de cursos
    echo "<form method='POST' action='AulasDesig.php'>";
    echo "<label for='curso'>Selecciona un curso:</label>";
    echo "<select name='curso' id='curso'>";
    while ($row = $result->fetch_assoc()) {
        $curso_id = $row['id'];
        $curso_nombre = $row['curso'];
        $curso_aula = $row['aula'];
        echo "<option value='$curso_id'>$curso_nombre</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Mostrar horarios'>";
    echo "</form>";

    // Mostrar la tabla con los horarios y aulas del curso seleccionado
    echo "<br><br>";

    if (isset($_POST['curso'])) {
        $curso_seleccionado = $_POST['curso'];

        $sql = "SELECT DISTINCT horario.dia, horario.hora_inicio, horario.hora_fin, cursos.aula
                FROM horario
                INNER JOIN horario_curso ON horario.id = horario_curso.horario_id
                INNER JOIN cursos ON horario_curso.curso_id = cursos.id
                WHERE cursos.id = $curso_seleccionado";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Día</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                        <th>Aula</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                $dia = $row['dia'];
                $hora_inicio = $row['hora_inicio'];
                $hora_fin = $row['hora_fin'];
                $aula = $row['aula'];

                echo "<tr>
                        <td>$dia</td>
                        <td>$hora_inicio</td>
                        <td>$hora_fin</td>
                        <td>$aula</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "No hay horarios disponibles para este curso.";
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>

</body>
</html>