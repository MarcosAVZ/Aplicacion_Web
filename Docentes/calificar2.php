<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Css/styles.css">
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
  </style>
  <title>Formulario de Examen y Alumno</title>
</head>

<body>
  <!-- Código para la barra lateral -->
  <header class="header">
    <!-- Cambiar título para que corresponda a la página -->
    <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <img src="../Css/hamburguesa.png" width="50px">
    </a>
    <h1 style="text-align: center; color: #05429f">Formulario de Examen y Alumno</h1>
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
          <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
        <?php
        } else {
        ?>
          <a href="Docente.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
        <?php
        }
        ?>
        <a href="listaAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
        <a href="AulasDesig.php" class="list-group-item list-group-item-action">Aula Designada</a>
        <a class="dropdown-toggle list-group-item list-group-item-action  active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Exámenes
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="calificar.php">Crear Instancia Examen</a></li>
          <li><a class="dropdown-item" href="calificar2.php">Cargar Notas</a></li>
        </ul>
      </div>
      <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
    </div>
  </div>
  <!-- Termina el bloque de código del sidebar -->

  <?php
  // Conexión a la base de datos

  $docenteId = 1;

  include '../conexion.php';

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

    $sqlAlumnos = "SELECT a.id, a.nombre
               FROM alumno a
               INNER JOIN alumnocurso ac ON a.id = ac.idAlumno
               WHERE ac.idCurso = $cursoId";

    $resultAlumnos = $conn->query($sqlAlumnos);
  }

  // Obtener alumnos vinculados al curso seleccionado
  if (isset($_POST['submit_examenalumno'])) {
    $alumnoId = $_POST['alumno'];
    $examenId = $_POST['examen'];
    $nota = $_POST['nota'];

    // Verificar si ya existe una calificación para este alumno y examen
    $sqlVerificar = "SELECT * FROM examenalumno WHERE idAlumno = $alumnoId AND idExamen = $examenId";
    $resultVerificar = $conn->query($sqlVerificar);

    if ($resultVerificar->num_rows > 0) {
      echo "Error: Este alumno ya fue calificado en este examen.";
    } else {
      // Si no hay duplicados, proceder con la inserción
      $insertQuery = "INSERT INTO examenalumno (idAlumno, idExamen, nota) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($insertQuery);

      if ($stmt) {
        $stmt->bind_param("iii", $alumnoId, $examenId, $nota);

        if ($stmt->execute()) {
          echo "<div class=\"alert-success mx-auto card-width\">
              <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
              Los datos se guardaron correctamente en la tabla examenalumno.
            </div>";
        } else {
          echo "<div class=\"alert mx-auto card-width\">
              <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
              Error al actualizar los datos: " . $conn->error . "
            </div>";
        }

        $stmt->close();
      } else {
        echo "<div class=\"alert mx-auto card-width\">
          <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
          Error al preparar la consulta: " . $conn->error . "
        </div>";
      }
    }
  }
  ?>

  <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
    <?php if (!isset($_POST['submit_curso'])) { ?>
      <h3>Selección del curso</h3>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h5 for="curso">Curso:</h5>
        <select class="form-select" name="curso" id="curso">
          <?php
          // Mostrar opciones de cursos
          if ($resultCursos->num_rows > 0) {
            while ($row = $resultCursos->fetch_assoc()) {
              echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
            }
          }
          ?>
        </select>
        <br>
        <input type="submit" class="btn btn-primary" name="submit_curso" value="Siguiente">
      </form>
    <?php } ?>

    <?php if (isset($_POST['submit_curso']) && isset($resultAlumnos)) { ?>
      <h3>Selección del examen y alumno</h3>
      <form class="mt-3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-inline">
          <h5 for="examen">Examen:</h5>
          <select class="form-select ms-3" name="examen" id="examen">
            <?php
            // Mostrar opciones de exámenes
            if ($resultExamenes->num_rows > 0) {
              while ($row = $resultExamenes->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <br>
        <div class="form-inline">
          <h5 for="alumno">Alumno:</h5>
          <select class="form-select ms-3" name="alumno" id="alumno">
            <?php
            // Mostrar opciones de alumnos
            if ($resultAlumnos->num_rows > 0) {
              while ($row = $resultAlumnos->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <br>
        <h5 for="nota">Nota:</h5>
        <input class="form-control max-width-input mx-auto p-2" style="padding-left: 50px;" type="number" name="nota" id="nota" placeholder="Ingrese la nota numérica">
        <br><br>
        <input type="submit" class="btn btn-primary" name="submit_examenalumno" value="Guardar">

      </form>
    <?php } ?>

    <div id="footer">
      <img src="../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
  function mostrarParte2() {
    document.getElementById("parte1").style.display = "none";
    document.getElementById("parte2").style.display = "block";
  }
</script>

</html>