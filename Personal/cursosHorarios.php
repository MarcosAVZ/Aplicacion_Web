<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Css/styles.css">
  <title>Formulario de Horarios</title>
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
  <!-- Termina el bloque de código del sidebar -->

  <div class="card form-container mx-auto p-2 mt-3 card-width">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <h5 class="formlabel" for="dia">Día:</h5>
      <select class="form-select mb-3" id="dia" name="dia">
        <option value="lunes">Lunes</option>
        <option value="martes">Martes</option>
        <option value="miercoles">Miércoles</option>
        <option value="jueves">Jueves</option>
        <option value="viernes">Viernes</option>
        <option value="sabado">Sábado</option>
      </select>
      <h5 class="formlabel" for="horaInicio">Hora de inicio:</h5>
      <input class="form-control timepicker" type="time" id="horaInicio" name="horaInicio"><br>

      <h5 class="formlabel" for="horaFin">Hora de fin:</h5>
      <input class="form-control" type="time" id="horaFin" name="horaFin"><br>

      <h5 class="formlabel" for="Aula">Aula:</h5>
      <input class="form-control" type="text" id="Aula" name="Aula"><br>

      <input class="btn btn-primary" type="submit" value="Guardar">
    </form>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dia = $_POST["dia"];
    $horaInicio = $_POST["horaInicio"];
    $horaFin = $_POST["horaFin"];
    $Aula = $_POST["Aula"];

    // Validar que los campos no estén vacíos
    if (empty($dia) || empty($horaInicio) || empty($horaFin) || empty($Aula)) {
      echo "<div class='alert alert-danger' role='alert'>Por favor, complete todos los campos.</div>";
    } else {
      // Conexión a la base de datos
      include '../Conexion.php';

      // Conectarse a la base de datos
      $conn = conectar();

      // Verificar la conexión
      if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
      }

      // Consulta para insertar los datos en la tabla de horarios
      $sql = "INSERT INTO horario (dia, horaInicio, horaFin, Aula) VALUES ('$dia', '$horaInicio', '$horaFin', '$Aula')";

      if ($conn->query($sql) === TRUE) {
        echo  "<div class=\"alert-success mx-auto card-width\">
            <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
            Horario guardado exitosamente.
            </div>";
      } else {
        echo "<div class=\"alert mx-auto card-width\">
          <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
          Error al guardar el horario: " . $conn->error . "
          </div>";
      }

      // Cerrar la conexión
      $conn->close();
    }
  }
  ?>
  <div id="footer">
    <img src="../Css/Logotipo200x200.png">
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>