<!DOCTYPE html> 
<html>
<head>
  <a href="../index2.php">Cerrar Sesion</a >
  <title>Área del Alumno</title>
</head>
<body>
<?php
include '../Conexion.php';

// Comenzar la sesión
session_start();

// Verificar si el usuario está autenticado como docente
if (isset($_SESSION['user_id'])) {
  // Obtener el ID del docente de la variable de sesión
  $alumnoId = $_SESSION['user_id'];

  // Obtener el nombre del docente de la base de datos
  $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
  $query = "SELECT nombre FROM alumno WHERE id = $alumnoId";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  $nombreAlumno = $row['nombre'];

  // Imprimir el mensaje de bienvenida
  echo "Hola $nombreAlumno, bienvenido.";
} else {
  // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
  header('Location: index2.php');
  exit();
}
?>


  <h1>Bienvenido</h1>
  
  <a href="horarios.php">Horarios</a>
  <a href="boletin.php">Boletin</a>
  
</body>
</html>