<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Css/styles.css">
  <title>Formulario de Horarios</title>
  <style>
    body {
      background-color: #f8f9fa;
    }

    .form-container {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 50px;
    }

    .btn-green {
      background-color: #28a745;
      color: #ffffff;
    }

    .btn-green:hover {
      background-color: #218838;
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
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
  </div>
  <!-- Termina el bloque de código del sidebar -->

  <div class="container mt-3">
    <div class="card form-container mx-auto p-4 card-width">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h5 class="form-label" for="nombre">Nombre del curso:</h5>
        <input class="form-control mb-3" type="text" id="nombre" name="nombre" required>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      </form>
    </div>
    <?php
    include '../Conexion.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $conn = conectar();

        if (!$conn) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        $query = "INSERT INTO curso (nombre) VALUES ('$nombre')";

        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success mt-3' role='alert'>El curso se ha insertado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3' role='alert'>Error al insertar el curso: " . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    }
    ?>
  </div>

  <div id="footer" class="text-center mt-3">
    <img src="../Css/Logotipo200x200.png">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>
