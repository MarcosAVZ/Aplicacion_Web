
<?php
require_once 'conexion.php'; 
$db  = conectar();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h1>Iniciar Sesión</h1>

  <form action="login_check.php" method="post">
    <label>Email: </label>
    <input type="email" name="email"><br><br>
  
    <label>Contraseña: </label> 
    <input type="password" name="password"><br><br>
  
    <input type="submit" name="submit" value="Iniciar Sesión">
  </form>

</body>
</html>