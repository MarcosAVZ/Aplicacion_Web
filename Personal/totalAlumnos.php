<!DOCTYPE html>
<html>
<head>
  <title>Listado de Alumnos</title>
</head>
<body>
<?php
// Conexión a la base de datos
require '../conexion.php';
$conn = conectar();

// Consulta para obtener todos los alumnos
$query = "SELECT nombre, DNI, correo, legajo FROM alumnos";

// Filtrar por legajo si existe el parámetro
if (isset($_GET['legajo'])) {
  $legajo = $_GET['legajo'];
  $query .= " WHERE legajo LIKE '%$legajo%'";
}

$result = $conn->query($query);
?>


<a href="personal.php">volver</a>


<h1>Listado de Alumnos</h1>

<form method="get">
  <label>Filtrar por legajo:</label>
  <input type="text" name="legajo">
  <button type="submit">Filtrar</button>
</form>

<table>
  <thead>
    <tr>
      <th>Nombre</th>
      <th>DNI</th>
      <th>Correo</th>
      <th>Legajo</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Mostrar contenido de la tabla
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row['nombre'] . "</td>";
      echo "<td>" . $row['DNI'] . "</td>";
      echo "<td>" . $row['correo'] . "</td>";
      echo "<td>" . $row['legajo'] . "</td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>
</html>