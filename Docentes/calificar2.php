<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Examen y Alumno</title>
</head>
<body>
    <a href="Examen.php">Volver</a>
    <?php
    // Conexión a la base de datos

    $docenteId = 1;

    include '../Conexion.php';

    // Conectarse a la base de datos
    $conn = conectar();
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Obtener cursos vinculados al docente
    $sqlCursos = "SELECT c.id, c.nombre
    FROM curso AS c
    JOIN cursodocente AS cd ON c.id = cd.idCurso
    WHERE cd.idDocente = $docenteId";
    $resultCursos = $conn->query($sqlCursos);
    
    if (isset($_POST['curso'])) {
        $cursoId = $_POST['curso'];
    
        // Consulta SQL para obtener los exámenes vinculados al curso seleccionado
        $sqlExamenes = "SELECT id, nombre
                        FROM examen
                        WHERE idCurso = $cursoId";
                    
        $resultExamenes = $conn->query($sqlExamenes);
    }
    
    // Obtener alumnos vinculados al curso seleccionado
    if (isset($_POST['curso'])) {
        $cursoId = $_POST['curso'];
        $sqlAlumnos = "SELECT a.id, a.nombre
                       FROM alumno AS a
                       JOIN alumnocurso AS ac ON a.id = ac.idAlumno
                       WHERE ac.idCurso = $cursoId";
        $resultAlumnos = $conn->query($sqlAlumnos);
    }
    
    // Guardar los datos en la tabla examenalumno
    if (isset($_POST['submit_examenalumno'])) {
        $alumnoId = $_POST['alumno'];
        $examenId = $_POST['examen'];
        $nota = $_POST['nota'];

        // Consulta SQL para insertar los datos en la tabla examenalumno
        $insertQuery = "INSERT INTO examenalumno (idAlumno, idExamen, nota) VALUES ($alumnoId, $examenId, $nota)";

        if ($conn->query($insertQuery) === TRUE) {
            echo "Los datos se guardaron correctamente en la tabla examenalumno.";
        } else {
            echo "Error al guardar los datos: " . $conn->error;
        }
    }
    ?>
    
    <h2>Primera parte: Selección del curso</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="curso">Curso:</label>
        <select name="curso" id="curso">
            <?php
            // Mostrar opciones de cursos
            if ($resultCursos->num_rows > 0) {
                while ($row = $resultCursos->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
            }
            ?>
        </select>
        <br><br>
        <input type="submit" name="submit_curso" value="Siguiente">
    </form>

    <?php if (isset($_POST['submit_curso']) && isset($resultAlumnos)) { ?>
        <h2>Segunda parte: Selección del examen y alumno</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="examen">Examen:</label>
            <select name="examen" id="examen">
                <?php
                // Mostrar opciones de exámenes
                if ($resultExamenes->num_rows > 0) {
                    while ($row = $resultExamenes->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>
            <label for="alumno">Alumno:</label>
            <select name="alumno" id="alumno">
                <?php
                // Mostrar opciones de alumnos
                if ($resultAlumnos->num_rows > 0) {
                    while ($row = $resultAlumnos->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>
            <label for="nota">Nota:</label>
<input type="text" name="nota" id="nota">
            <br><br>
            <input type="submit" name="submit_examenalumno" value="Guardar">
        </form>
    <?php } ?>

    <?php
    $conn->close();
    ?>
</body>
</html>