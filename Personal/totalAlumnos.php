<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Css/styles.css">
  <title>Listado de Alumnos</title>
</head>

<body>
  <!-- Código para la barra lateral -->
  <header class="header no-print">
    <!-- Cambiar título para que corresponda a la página -->
    <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <img src="../Css/hamburguesa.png" width="50px">
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
                <a href="totalAlumnos.php" class="list-group-item list-group-item-action active">Alumnos</a>
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

  <?php

  // Conexión a la base de datos
  require '../conexion.php';

  $conexion = conectar();

  // Función para buscar todos los alumnos
  function buscarTodosAlumnos($conexion)
  {

    // Query para buscar todos los alumnos
    $queryAlumnos = "
  SELECT  
    a.id,
    a.legajo,
    a.correo AS correo_alumno,  
    a.nombre,
    p.nombre AS nombre_padre,
    p.correo AS correo_padre
  FROM
    alumno a
  INNER JOIN  
    padre p ON a.idPadre = p.id
";

    // Ejecutar query
    $resultado = mysqli_query($conexion, $queryAlumnos);

    // Retornar resultado
    return $resultado;
  }

  // Función para buscar alumnos por legajo
  function buscarAlumnos($conexion, $legajo)
  {

    // Query para buscar alumnos por legajo
    $queryAlumnos = "
  SELECT  
    a.id,
    a.legajo,
    a.correo AS correo_alumno,  
    a.nombre,
    p.nombre AS nombre_padre,
    p.correo AS correo_padre
  FROM
    alumno a
  INNER JOIN  
    padre p ON a.idPadre = p.id
  WHERE
    a.legajo = '$legajo'  
";

    // Ejecutar query
    $resultado = mysqli_query($conexion, $queryAlumnos);

    // Retornar resultado
    return $resultado;
  }

  ?>
  <div>
    <!-- Formulario de búsqueda -->
    <form method="POST" class="no-print ms-3">
      <div class="mb-2">
        <h5 class="formlabel">Buscar por legajo:</h5>
        <div class="form-inline">
          <input class="form-control max-width-input" type="text" name="legajo">
          <button class="btn btn-secondary" type="submit">Buscar</button>
        </div>
      </div>
    </form>

    <!-- Botón "Mostrar Todos" -->
    <form method="POST" class="no-print ms-3">
      <button class="mb-2 btn btn-primary" type="submit" name="mostrarTodos">Mostrar Todos</button>
    </form>

    <?php

    // Verificar si se envió un legajo
    if (isset($_POST['legajo'])) {
      // Obtener legajo enviado por POST
      $legajo = $_POST['legajo'];

      // Llamar función de búsqueda con filtro por legajo
      $resultadoAlumnos = buscarAlumnos($conexion, $legajo);
    } elseif (isset($_POST['mostrarTodos'])) {
      // Llamar función de búsqueda sin filtro por legajo
      $resultadoAlumnos = buscarTodosAlumnos($conexion);
    } else {
      // No se envió ningún formulario, mostrar todos los alumnos por defecto
      $resultadoAlumnos = buscarTodosAlumnos($conexion);
    }

    // Verificar si hay resultados
    if (mysqli_num_rows($resultadoAlumnos) > 0) {
    ?>

      <!-- Tabla de resultados -->
      <div class="mx-auto p-2" style="width: 90vw">
        <table class="table table-striped table-bordered">

          <tr class="table-info">

            <th>Legajo</th>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Nombre Padre</th>
            <th>Correo Padre</th>
            <th>Cursos</th>

          </tr>
          <?php
          // Recorrer resultados
          while ($filaAlumno = mysqli_fetch_array($resultadoAlumnos)) {
          ?>
            <tr>

              <td><?php echo $filaAlumno['legajo']; ?></td>
              <td><?php echo $filaAlumno['correo_alumno']; ?></td>
              <td><?php echo $filaAlumno['nombre']; ?></td>
              <td><?php echo $filaAlumno['nombre_padre']; ?></td>
              <td><?php echo $filaAlumno['correo_padre']; ?></td>

              <td>
                <?php
                // Consulta cursos
                $idAlumno = $filaAlumno['id'];

                $queryCursos = "
                  SELECT c.nombre
                  FROM alumnocurso ac
                  INNER JOIN curso c ON ac.idCurso = c.id
                  WHERE ac.idAlumno = '$idAlumno'
                ";
                $resultadoCursos = mysqli_query($conexion, $queryCursos);

                $firstRow = true;
                while ($filaCurso = mysqli_fetch_array($resultadoCursos)) {
                  if ($firstRow) {
                    echo $filaCurso['nombre'];
                    $firstRow = false;
                  } else {
                    echo ", " . $filaCurso['nombre'];
                  }
                }
                ?>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    <?php } ?>
    <!-- Botón para imprimir tabla -->
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../Css/print.png' width='50px'></a>
  </div>
  <div id="footer">
    <img src="../Css/Logotipo200x200.png">
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Script para imprimir la tabla -->
<script>
  function imprimirTabla() {
    window.print();
  }
</script>

</html>