<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Listado de Alumnos</title>
  <style>
    body {
      background-color: #f5f5f5;
    }

    .header {
      background-color: #3dfdb0;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header h1 {
      text-align: center;
      margin: 0;
    }

    .max-width-input {
      max-width: 300px;
      width: 100%;
    }

    #footer {
      position: fixed;
      right: 0;
      bottom: 0;
      margin: 0;
      padding: 0;
    }

    #footer img {
      width: 200px;
      opacity: 0.2;
    }

    @media print {
      .no-print,
      .no-print * {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <!-- Código para la barra lateral -->
  <header class="header no-print">
    <!-- Cambiar título para que corresponda a la página -->
    <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <img src="..\hamburguesa.png" width="50px">
    </a>
    <h1 style="text-align: center; color: #05429f">Listado de Alumnos</h1>
  </header>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div>
        <img src="..\Logotipo200x200.png" class="rounded mx-auto d-block">
      </div>
      <div class="list-group">
        <a href="Docente.php" class="list-group-item list-group-item-action">Página Principal</a>
        <a href="listaAlumnos.php" class="list-group-item list-group-item-action active" aria-current="true">Lista de alumnos</a>
        <a href="AulasDesig.php" class="list-group-item list-group-item-action">Aulas designadas</a>
        <a href="calificar.php" class="list-group-item list-group-item-action">Calificar alumnos</a>
      </div>
      <a href="..\index.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
    </div>
  </div>
  <!-- Termina el bloque de código del sidebar -->

  <?php
  // Obtener el ID del docente que ha iniciado sesión (puedes obtenerlo de la sesión o de otro método de autenticación)

  // Conexión a la base de datos
  require_once '../conexion.php';

  $conn = conectar();
  // Verificar la conexión
  session_start();

  // Verificar si el usuario está autenticado como docente
  if (isset($_SESSION['user_id'])) {
    // Obtener el ID del docente de la variable de sesión
    $docenteId = $_SESSION['user_id'];

    // Ejecutar la consulta para obtener los cursos del docente
    $queryCursos = "
    SELECT DISTINCT c.id, c.curso, c.aula
    FROM cursos c
    JOIN docentes_cursos dc ON c.id = dc.id_curso
    JOIN docentes d ON dc.id_docente = " . $docenteId;

    $resultCursos = mysqli_query($conn, $queryCursos);
  }

  // Obtener el ID del curso seleccionado (si se ha enviado el formulario)
  $cursoSeleccionado = isset($_POST['curso']) ? $_POST['curso'] : null;

  // Ejecutar la consulta para obtener los alumnos del curso seleccionado
  if ($cursoSeleccionado) {
    $queryAlumnos = "
    SELECT DISTINCT a.nombre, a.legajo, a.correo, a.DNI  
    FROM alumnos a
    JOIN alumnoscursos ac ON a.id = ac.alumno_id
    JOIN cursos c ON ac.curso_id = c.id    
    WHERE c.id = " . $cursoSeleccionado;

    $resultAlumnos = mysqli_query($conn, $queryAlumnos);
  }

  ?>
  <!-- Selector de cursos -->
  <br>
  <div class="mb-3">
    <form method="POST" action="">
      <!-- <label for="curso">Selecciona un curso:</label> -->
      <p class="h5">Selecciona un curso:
        <select name="curso" id="curso" onchange="this.form.submit()">
          <option value="">Seleccione un curso</option>
          <?php while ($row = mysqli_fetch_array($resultCursos)) { ?>
            <option value="<?php echo $row['id']; ?>" <?php if ($cursoSeleccionado == $row['id']) echo 'selected'; ?>><?php echo $row['curso']; ?></option>
          <?php } ?>
        </select>
        <noscript><input type="submit" value="Submit"></noscript>
      </p>
    </form>
  </div>

    <table class="table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Legajo</th>
          <th>Correo</th>
          <th>DNI</th>
        </tr>
      </thead>

      <tbody>
        <?php if ($cursoSeleccionado && $resultAlumnos->num_rows > 0) {
          while ($row = mysqli_fetch_array($resultAlumnos)) { ?>
            <tr>
              <td><?php echo $row["nombre"]; ?></td>
              <td><?php echo $row["legajo"]; ?></td>
              <td><?php echo $row["correo"]; ?></td>
              <td><?php echo $row["DNI"]; ?></td>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td colspan="4">No hay alumnos disponibles para el curso seleccionado.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

  <a class='no-print' type='button' onclick='imprimirTabla()'><img src='..\print.png' width='50px'></a>

  <div id="footer">
    <img src="..\Logotipo200x200.png">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- Script para imprimir la tabla sin los demás elementos de la página. -->
  <script>
    function imprimirTabla() {
      window.print();
    }
  </script>
</body>

</html>