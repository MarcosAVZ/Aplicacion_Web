<!DOCTYPE html> 
<html>
<head>
  <a href="../index2.php">Cerrar Sesion</a >
  <title>Área del Docente</title>
</head>
<body>
<?php
include '../Conexion.php';

// Comenzar la sesión
session_start();

// Verificar si el usuario está autenticado como docente
if (isset($_SESSION['user_id'])) {
  // Obtener el ID del docente de la variable de sesión
  $docenteId = $_SESSION['user_id'];

  // Obtener el nombre del docente de la base de datos
  $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
  $query = "SELECT nombre FROM docente WHERE id = $docenteId";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  $nombreDocente = $row['nombre'];

  // Imprimir el mensaje de bienvenida
  echo "Hola $nombreDocente, bienvenido al Área del Docente.";
} else {
  // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
  header('Location: index.php');
  exit();
}
?>


  <h1>Bienvenido Docente</h1>
  
  <a href="listaAlumnos.php">Alumnos</a>
  <a href="AulasDesig.php">Aula Designada</a>
  <a href="Examen.php">Examenes</a>
  
</body>
</html>