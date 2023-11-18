<?php
require '../Conexion.php'; // Asegúrate de que este archivo tenga la función conectar() para conectarte a la base de datos
$conexion = conectar();

$correoError = $legajoError = $mensajeExito = ""; // Inicializar variables de error y mensaje de éxito

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST["correo"];
    $password = $_POST["correo"]; // No está claro si esto debería ser diferente de correo
    $legajo = $_POST["legajo"];
    $nombre = $_POST["nombre"];

    // Validar el correo electrónico
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $correoError = "Ingrese un correo electrónico válido.";
    }

    // Validar el legajo (debe ser un número)
    if (!is_numeric($legajo)) {
        $legajoError = "Ingrese un valor numérico para el legajo.";
    }

    // Si no hay errores, realizar la inserción en la base de datos
    if (empty($correoError) && empty($legajoError)) {
        // Consulta SQL para insertar el nuevo padre
        $consulta = "INSERT INTO padre (correo, password, legajo, nombre) VALUES ('$correo', '$password', $legajo, '$nombre')";

        if ($conexion->query($consulta) === TRUE) {
            $mensajeExito = "Padre matriculado con éxito.";
        } else {
            $mensajeExito = "Error al matricular al padre: " . $conexion->error;
        }
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Crear Nuevo Padre</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Matricular Padres</h1>
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
                <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action " aria-current="true">Página Principal</a>
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
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="asignarDocente.php">Asignar Docente</a></li>
                    <li><a class="dropdown-item" href="relacionarCursoHorario.php">Asignar Curso</a></li>
                    <li><a class="dropdown-item" href="cargarCursos.php">Agregar Curso</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    <!-- Termina el bloque de código del sidebar -->

    <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
        <form action="MatricularPadre.php" method="post">
            <div class="form-row">
                <label class="h5" for="correo">Correo:</label>
                <input class="form-control max-width-input" type="text" name="correo" id="correo" required><br>
                <span class="error"><?php echo $correoError; ?></span>
            </div>
            <div class="form-row">
                <label class="h5" for="legajo">Legajo:</label>
                <input class="form-control max-width-input" type="text" name="legajo" id="legajo" required><br>
                <span class="error"><?php echo $legajoError; ?></span>
            </div>
            <div class="form-row">
                <label class="h5" for="nombre">Nombre Completo:</label>
                <input class="form-control max-width-input" type="text" name="nombre" id="nombre" required><br>
            </div>
            <input class="btn btn-primary mt-2" type="submit" value="Crear Padre">
        </form>
    </div>

    <div class="mx-auto mt-3" style="width: 500px">
        <?php
        if (!empty($mensajeExito)) {
            echo "<div class=\"alert-success\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    $mensajeExito
                </div>";
        }
        ?>
    </div>

    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>
