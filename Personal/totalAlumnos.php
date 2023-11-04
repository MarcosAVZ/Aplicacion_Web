<a href="personal.php">Volver</a>
<?php

// Conexión a la base de datos
require '../conexion.php';

$conexion = conectar();

// Función para buscar todos los alumnos
function buscarTodosAlumnos($conexion) {

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
function buscarAlumnos($conexion, $legajo) {

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

<!-- Formulario de búsqueda -->
<form method="POST">

  <label>Buscar por legajo:</label>

  <input type="text" name="legajo">

  <button type="submit">Buscar</button>

</form>

<!-- Botón "Mostrar Todos" -->
<form method="POST">
  <button type="submit" name="mostrarTodos">Mostrar Todos</button>
</form>

<?php

// Verificar si se envió un legajo
if(isset($_POST['legajo'])) {
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
if(mysqli_num_rows($resultadoAlumnos) > 0) {
?>

<!-- Tabla de resultados -->
<table border="1">

  <tr>

    <th>Legajo</th>
    <th>Correo</th>
    <th>Nombre</th>
    <th>Nombre Padre</th>
    <th>Correo Padre</th>
    <th>Cursos</th>

  </tr>

  <?php

  // Recorrer resultados
  while($filaAlumno = mysqli_fetch_array($resultadoAlumnos)) {

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

      while($filaCurso = mysqli_fetch_array($resultadoCursos)) {
        echo $filaCurso['nombre'].", "; 
      }

      ?>

      </td>
  
    </tr>
  
    <?php } ?>
  
  </table>
  
  <?php } ?>