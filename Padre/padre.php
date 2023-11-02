<!DOCTYPE html> 
<html>
<head>
  <a href="../index2.php">Cerrar Sesion</a >
  <title>Área del Padre</title>
</head>
<body>
<?php
include '../Conexion.php';

// Comenzar la sesión
session_start();

// Verificar si el usuario está autenticado como docente
if (isset($_SESSION['user_id'])) {
  // Obtener el ID del docente de la variable de sesión
  $padreId = $_SESSION['user_id'];

  // Obtener el nombre del docente de la base de datos
  $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
  $query = "SELECT nombre FROM padre WHERE id = $padreId";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  $nombrePadre = $row['nombre'];

  // Imprimir el mensaje de bienvenida
  echo "Hola $nombrePadre, bienvenido al Área del Padre.";
} else {
  // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
  header('Location: index.php');
  exit();
}
?>


  <h1>Bienvenido</h1>
  
  <a href="boletinHijo.php">Boletin</a>
  <a href="horarioHijo.php">Horarios</a>
  
</body>
</html>