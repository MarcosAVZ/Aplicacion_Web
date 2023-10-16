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
<a href="Docente.php">Volver</a>

<!-- Selector de cursos -->
<form method="POST" action="">
  <label for="curso">Selecciona un curso:</label>
  <select name="curso" id="curso" onchange="this.form.submit()">
    <option value="">Seleccione un curso</option>
    <?php while($row = mysqli_fetch_array($resultCursos)) { ?>
      <option value="<?php echo $row['id']; ?>" <?php if ($cursoSeleccionado == $row['id']) echo 'selected'; ?>><?php echo $row['curso']; ?></option>
    <?php } ?>
  </select>
  <noscript><input type="submit" value="Submit"></noscript>
</form>

<table>
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
    while($row = mysqli_fetch_array($resultAlumnos)) { ?>
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