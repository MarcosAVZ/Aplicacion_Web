<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Crear Nuevo Alumno</title>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-row label {
            text-align: left;
            flex-basis: 30%;
            margin-right: 10px;
        }

        .form-row input {
            flex-basis: 70%;
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Matricular Alumnos</h1>
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
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotas/Pagos.php">Lista Pagos</a></li>
                    <li><a class="dropdown-item" href="Cuotas/cuotas.php">Estado Pagos</a></li>
                    <li><a class="dropdown-item" href="Cuotas/montoCuota.php">Estado Pagos</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="relacionarCursoHorario.php">Asignar Curso</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        <form action="MatricularAlumno.php" method="post">
            <div class="form-row">
                <label class="h5" for="correo">Correo:</label>
                <input class="form-control max-width-input" type="text" name="correo" id="correo" required><br>
            </div>
            <div class="form-row">
                <label class="h5" for="idPadre">Padre:</label>
                <select class="form-select max-width-input me-3" name="idPadre" id="idPadre" required>
                    <?php
                    // Conexión a la base de datos
                    require_once '../Conexion.php';
                    $conexion = conectar();

                    // Consulta para obtener la lista de padres
                    $consultaPadres = "SELECT id, nombre FROM padre";
                    $resultadoPadres = $conexion->query($consultaPadres);

                    if ($resultadoPadres->num_rows > 0) {
                        while ($fila = $resultadoPadres->fetch_assoc()) {
                            echo '<option value="' . $fila['id'] . '">' . $fila['nombre'] . '</option>';
                        }
                    }
                    // Cerrar la conexión a la base de datos
                    $conexion->close();
                    ?>
                </select>
            </div>
            <div class="form-row">
                <label class="h5" for="legajo">Legajo:</label>
                <input class="form-control max-width-input" type="text" name="legajo" id="legajo" required><br>
            </div>
            <div class="form-row">
                <label class="h5" for="nombre">Nombre Completo:</label>
                <input class="form-control max-width-input" type="text" name="nombre" id="nombre" required><br>
            </div>
                <input class="btn btn-primary mt-2" type="submit" value="Crear Alumno">
        </form>
    </div>

    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST["correo"];
    $password = $_POST["correo"];
    $idPadre = $_POST["idPadre"];
    $legajo = $_POST["legajo"];
    $nombre = $_POST["nombre"];

    // Consulta SQL para insertar el nuevo alumno
    $consulta = "INSERT INTO alumno (correo, password, idPadre, legajo, nombre) VALUES ('$correo', '$password', $idPadre, $legajo, '$nombre')";

    if ($conexion->query($consulta) === TRUE) {
        echo "<div class=\"alert-success mx-auto\" style=\"width: 500px\">
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                El alumno se ha creado con éxito.
            </div>";
    } else {
        echo "<div class=\"alert mx-auto\" style=\"width: 500px\">
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                Error al crear el alumno: ". $conexion->error. "
            </div>";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>