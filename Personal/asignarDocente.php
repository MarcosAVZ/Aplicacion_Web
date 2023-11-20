<?php
session_start();
include '../Conexion.php';
$conn = conectar();

// Obtener la lista de docentes
$query_docentes = "SELECT id, nombre FROM docente";
$result_docentes = $conn->query($query_docentes);

$mensaje = ""; // Variable para almacenar mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $docente_id = $_POST["docente"];
    $curso_id = $_POST["curso"];

    // Insertar la relación docente-curso en la base de datos
    $query = "INSERT INTO cursodocente (idDocente, idCurso) VALUES ('$docente_id', '$curso_id')";

    if ($conn->query($query) === TRUE) {
        $mensaje = "Docente matriculado en el curso correctamente.";
    } else {
        $mensaje = "Error al matricular al docente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Matricular Docente en Cursos</title>
</head>

<body>
    <!-- Barra lateral -->
    <header class="header no-print">
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Matricular Docente en Cursos</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
             <?php  
                session_start();
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="personal.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
                <a href="totalAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="Cuotas/Pagos.php">Lista Pagos</a></li>
                    <li><a class="dropdown-item" href="Cuotas/cuotas.php">Estado Pagos</a></li>
                    <li><a class="dropdown-item" href="montoCuota.php">Actualizar precios</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="asignarDocente.php">Asignar Docente</a></li>
                    <li><a class="dropdown-item" href="relacionarCursoHorario.php">Asignar Curso</a></li>
                    <li><a class="dropdown-item" href="cargarCursos.php">Agregar Curso</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Matriculación
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="MatricularAlumno.php">Matricular Alumno</a></li>
                    <li><a class="dropdown-item" href="MatricularPadre.php">Matricular Padre</a></li>
                </ul>
            </div>
            <a href="../index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Fin de la barra lateral -->

    <!-- Contenido principal -->
    <div class="card form-container mx-auto p-2 mt-3 card-width">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Matricular Docente en Cursos</h2>

            <div class="form-row">
                <label class="h5" for="docente">Seleccionar Docente:</label>
                <select class="form-select" name="docente" id="docente" required>
                    <?php
                    // Mostrar la lista de docentes
                    while ($row_docente = $result_docentes->fetch_assoc()) {
                        echo "<option value='" . $row_docente["id"] . "'>" . $row_docente["nombre"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-row">
                <label class="h5" for="curso">Seleccionar Curso:</label>
                <select class="form-select" name="curso" id="curso" required>
                    <?php
                    // Obtener cursos no matriculados por el docente
                    // (Necesitarás adaptar la consulta según tu esquema de base de datos)
                    $query_cursos = "SELECT id, nombre FROM curso WHERE id NOT IN (SELECT idCurso FROM cursodocente)";
                    $result_cursos = $conn->query($query_cursos);

                    if ($result_cursos->num_rows > 0) {
                        while ($row_curso = $result_cursos->fetch_assoc()) {
                            echo "<option value='" . $row_curso["id"] . "'>" . $row_curso["nombre"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <input class="btn btn-primary mt-2" type="submit" value="Matricular en Curso">
        </form>


        
    </div>
            <!-- Mostrar mensaje de éxito o error -->
    <?php
        if (!empty($mensaje)) {
            echo '<div class="alert ' . (strpos($mensaje, "Error") !== false ? 'alert-danger' : 'alert-success') . ' mt-3 card-width" role="alert">' . $mensaje . '</div>';
        }
        ?>
    <!-- Fin del contenido principal -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
