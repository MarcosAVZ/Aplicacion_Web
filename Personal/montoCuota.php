<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Css/styles.css">
    <title>Actualizar Precios</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <img src="../../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Actualizar Precios</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
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
                <a href="../Autoridad/autoridad.php"
                    class="list-group-item list-group-item-action "
                    aria-current="true">Página Principal</a>
                <?php  
                    } else {
                    ?>
                <a href="personal.php"
                    class="list-group-item list-group-item-action"
                    aria-current="true">Página Principal</a>
                <?php 
                    }
                ?>
                <a href="totalAlumnos.php"
                    class="list-group-item list-group-item-action">Alumnos</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="Cuotas/Pagos.php">Lista Pagos</a></li>
                    <li><a class="dropdown-item" href="Cuotas/cuotas.php">Estado Pagos</a></li>
                    <li><a class="dropdown-item" href="montoCuota.php">Actualizar precios</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="asignarDocente.php">Asignar Docente</a></li>
                    <li><a class="dropdown-item" href="relacionarCursoHorario.php">Asignar Curso</a></li>
                    <li><a class="dropdown-item" href="cargarCursos.php">Agregar Curso</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Matriculación
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="MatricularAlumno.php">Matricular Alumno</a></li>
                    <li><a class="dropdown-item" href="MatricularPadre.php">Matricular Padre</a></li>
                </ul>
            </div>
            <a href="..\index2.php" class="btn btn-danger"
                style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <?php
    include '../conexion.php';

    $conn = conectar();

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar el nuevo monto del formulario
        $nuevoMonto = $_POST["nuevo_monto"];

        // Actualizar el monto en la tabla montos_cuota
        $sqlUpdate = "UPDATE montos_cuota SET monto = $nuevoMonto WHERE id = 1";

        if ($conn->query($sqlUpdate) === TRUE) {
            echo "Monto actualizado exitosamente.";
        } else {
            echo "Error al actualizar el monto: " . $conn->error;
        }
    }

    // Obtener el monto actual de la tabla montos_cuota
    $sqlSelect = "SELECT monto FROM montos_cuota WHERE id = 1";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $montoActual = $row["monto"];
    } else {
        $montoActual = 0.00; // Valor predeterminado si no se encuentra un monto
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>

    <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
        <form class="ms-3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label class="h5" for="nuevo_monto">Nuevo Monto de Cuota:</label>
            <input class="form-control max-width-input" type="number" step="0.01" name="nuevo_monto" value="<?php echo $montoActual; ?>" required>
            <input class="btn btn-primary mt-3" type="submit" value="Actualizar Monto">
        </form>
    </div>
    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>