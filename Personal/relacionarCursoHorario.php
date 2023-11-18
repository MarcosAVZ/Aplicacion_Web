<?php
include '../Conexion.php';

$conn = conectar();

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$cursosQuery = "SELECT id, nombre FROM curso";
$cursosResult = $conn->query($cursosQuery);

$horariosQuery = "SELECT id, dia, horaInicio, horaFin FROM horario WHERE id NOT IN (SELECT idHorario FROM cursohorario)";
$horariosResult = $conn->query($horariosQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCurso = $_POST["curso"];
    $idHorario = $_POST["horario"];

    $insertQuery = "INSERT INTO cursohorario (idCurso, idHorario) VALUES ('$idCurso', '$idHorario')";

    if ($conn->query($insertQuery) === TRUE) {
        session_start();
        $_SESSION['mensaje'] = "Horario Cargado Exitosamente.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error al insertar los IDs en la tabla cursoHorario: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Seleccionar Curso y Horario</title>
</head>

<body>
    <header class="header no-print">
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Formulario de Horarios</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <img src="../Css/Logotipo200x200.png" class="rounded mx-auto d-block">
            </div>
            <div class="list-group">
                <?php
                session_start();
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                    <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php
                } else {
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
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>

    <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
        <h2>Seleccionar Curso y Horario</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h5 class="formlabel" for="curso">Curso:</h5>
            <select class="form-select" name="curso" id="curso">
                <?php
                if ($cursosResult->num_rows > 0) {
                    while ($row = $cursosResult->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                    }
                }
                ?>
            </select>
            <br>
            <h5 class="formlabel" for="horario">Horario:</h5>
            <select class="form-select" name="horario" id="horario">
                <?php
                if ($horariosResult->num_rows > 0) {
                    while ($row = $horariosResult->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["dia"] . " - " . $row["horaInicio"] . " a " . $row["horaFin"] . "</option>";
                    }
                }
                ?>
            </select>
            <br>
            <input class="btn btn-primary" type="submit" value="Guardar">
        </form>

        <div class="alert-container mt-3">
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ' . $_SESSION['mensaje'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                unset($_SESSION['mensaje']);
            }
            ?>
        </div>
    </div>
    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>
