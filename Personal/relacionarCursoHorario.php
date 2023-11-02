<?php
// Datos de conexión a la base de datos
include '../Conexion.php';

// Conectarse a la base de datos
$conn = conectar();
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los cursos existentes
$cursosQuery = "SELECT id, nombre FROM curso";
$cursosResult = $conn->query($cursosQuery);

// Obtener los horarios existentes
$horariosQuery = "SELECT id, dia, horaInicio, horaFin FROM horario";
$horariosResult = $conn->query($horariosQuery);

// Comprobar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los IDs del formulario
    $idCurso = $_POST["curso"];
    $idHorario = $_POST["horario"];

    // Insertar los IDs en la tabla cursoHorario
    $insertQuery = "INSERT INTO cursohorario (idCurso, idHorario) VALUES ('$idCurso', '$idHorario')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Horario Cargado Exitosamente.";
    } else {
        echo "Error al insertar los IDs en la tabla cursoHorario: " . $conn->error;
    }
}

// Cerrar la conexión
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
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
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
                <a href="personal.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="totalAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
                <a href="totalPagos.php" class="list-group-item list-group-item-action">Cuotas</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="relacionarCursoHorario.php">Asignar Curso</a></li>
                </ul>

            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
        <h2>Seleccionar Curso y Horario</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h5 class="formlabel" for="curso">Curso:</h5>
            <select class="form-select" name="curso" id="curso">
                <?php
                // Mostrar los cursos existentes en el formulario
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
                // Mostrar los horarios existentes en el formulario
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
    </div>
    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>