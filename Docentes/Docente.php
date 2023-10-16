<!DOCTYPE html> 
<html>
<head>
  <a href="../index.php">Cerrar Sesion</a >
  <title>Área del Docente</title>
</head>
<body>
<?php
include '../Conexion.php';

session_start();

if(!isset($_SESSION['user_id'])){
  header('Location: index.php');
  exit;
}

$docente_id = $_SESSION['user_id'];
?>


  <h1>Bienvenido Docente</h1>
  <a href="Docente.php">Volver</a>
  <a href="listaAlumnos.php">Alumnos</a>
  //Módulos de pago de cuotas, alumnos, horarios y aulas
  
</body>
</html>