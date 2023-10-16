<?php
// Obtener el ID del docente que ha iniciado sesión (puedes obtenerlo de la sesión o de otro método de autenticación)
$docenteId = 1; // Ejemplo: ID del docente es 1

// Conexión a la base de datos
require_once '../conexion.php';

$conn = conectar();
// Verificar la conexión
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Realizar la consulta para obtener los alumnos del curso del docente
$sql = "SELECT a.* 
        FROM alumnos a
        INNER JOIN docentes_cursos dc ON a.id = dc.id_alumno
        INNER JOIN cursos c ON dc.id_curso = c.id
        WHERE dc.id_docente = ".$docenteId;

// Ejecutar la consulta y obtener los resultado

// Ejecutar la consulta
$query = "
  SELECT a.nombre, a.legajo, a.correo, a.DNI  
  FROM alumnos a
  JOIN alumnoscursos ac ON a.id = ac.alumno_id
  JOIN docentes_cursos dc ON ac.curso_id = dc.id_curso
  JOIN cursos c ON ac.curso_id = c.id    
  JOIN docentes d ON dc.id_docente = d.id
  WHERE d.id = 1 AND c.id = 1
";

$result = mysqli_query($conn, $query);

?>

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
  <?php while($row = mysqli_fetch_array($result)) { ?>
    <tr>
      <td><?php echo $row["nombre"]; ?></td>
      <td><?php echo $row["legajo"]; ?></td>  
      <td><?php echo $row["correo"]; ?></td>
      <td><?php echo $row["DNI"]; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>