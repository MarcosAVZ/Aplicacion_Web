<!DOCTYPE html>
<html>
<head>
    <title>Selección de Curso</title>
</head>
<body>
    <h1>Selección de Curso</h1>

    <?php
    include '../Conexion.php';

    // Conectarse a la base de datos
    $conexion = conectar();

    // Obtener el id del docente
    $id_docente = 1;

    // Consulta para obtener los cursos del docente
    $cursos_docente = "SELECT c.id, c.nombre FROM cursodocente cd INNER JOIN curso c ON c.id = cd.idCurso WHERE cd.idDocente = $id_docente";
    $resultado_cursos_docente = mysqli_query($conexion, $cursos_docente);

    // Mostrar formulario para seleccionar el curso
    echo "<form action='' method='GET'>";
    echo "<select name='curso'>";
    while ($row = mysqli_fetch_array($resultado_cursos_docente)) {
        $id_curso = $row['id'];
        $nombre_curso = $row['nombre'];
        echo "<option value='$id_curso'>$nombre_curso</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Ver Alumnos'>";
    echo "</form>";

    // Verificar si se ha seleccionado un curso
    if (isset($_GET['curso'])) {
        $id_curso_seleccionado = $_GET['curso'];

        // Consulta para obtener el nombre del curso seleccionado
        $consulta_curso = "SELECT nombre FROM curso WHERE id = $id_curso_seleccionado";
        $resultado_consulta_curso = mysqli_query($conexion, $consulta_curso);

        if (mysqli_num_rows($resultado_consulta_curso) > 0) {
            $row_curso = mysqli_fetch_assoc($resultado_consulta_curso);
            $nombre_curso_seleccionado = $row_curso['nombre'];

            // Consulta para verificar si el docente está relacionado con el curso seleccionado
            $consulta_relacion = "SELECT * FROM cursodocente WHERE idCurso = $id_curso_seleccionado AND idDocente = $id_docente";
            $resultado_consulta_relacion = mysqli_query($conexion, $consulta_relacion);

            if (mysqli_num_rows($resultado_consulta_relacion) > 0) {
                // Consulta para obtener los alumnos del curso seleccionado
                $alumnos_curso = "SELECT a.legajo, a.nombre, a.correo FROM alumnocurso ac INNER JOIN alumno a ON a.id = ac.idAlumno WHERE ac.idCurso = $id_curso_seleccionado";
                $resultado_alumnos_curso = mysqli_query($conexion, $alumnos_curso);

                // Mostrar el nombre del curso seleccionado
                echo "<h2>Curso seleccionado: $nombre_curso_seleccionado</h2>";

                // Mostrar los alumnos del curso seleccionado en una tabla
                echo "<table>";
                echo "<tr><th>Legajo</th><th>Nombre</th><th>Correo</th></tr>";
                while ($fila = mysqli_fetch_array($resultado_alumnos_curso)) {
                    echo "<tr>";
                    echo "<td>{$fila['legajo']}</td>";
                    echo "<td>{$fila['nombre']}</td>";
                    echo "<td>{$fila['correo']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>El docente no está relacionado con el curso seleccionado</p>";
            }
        } else {
            echo "<p>Curso no encontrado</p>";
        }
    }

    // Cerrar la conexión
    mysqli_close($conexion);
    ?>

    <br>
    <a href="Docente.php">Volver</a>
</body>
</html>