<?php
// Archivo de configuración de la base de datos
require_once 'conexion.php';

// Comprobar si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los datos del formulario
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];

  // Conectar a la base de datos
  $db = conectar();

  // Consultar en la tabla 'alumnos'
  $query = "SELECT * FROM alumnos WHERE correo = '$correo' AND contrasena = '$contrasena'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  session_start();
   

  if ($row) {
    // Redirigir al enlace de alumnos
    $_SESSION['user_id'] = $row['id'];
    header('Location: enlace_alumnos.php');
    exit();
  }

  // Consultar en la tabla 'docentes'
  $query = "SELECT * FROM docentes WHERE email = '$correo' AND contrasena = '$contrasena'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  if ($row) {
    $_SESSION['user_id'] = $row['id'];
    // Redirigir al enlace de docentes
    header('Location: Docentes/Docente.php');
    exit();
  }

  // Consultar en la tabla 'administrador'
  $query = "SELECT * FROM administrador WHERE correo = '$correo' AND contrasena = '$contrasena'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  if ($row) {
    
    // Redirigir al enlace de administrador
    header('Location: enlace_administrador.php');
    exit();
  }

  // Consultar en la tabla 'padre'
  $query = "SELECT * FROM padre WHERE correo = '$correo' AND contrasena = '$contrasena'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  if ($row) {
    // Redirigir al enlace de padre
    header('Location: enlace_padre.php');
    exit();
  }

  // Consultar en la tabla 'personal'
  $query = "SELECT * FROM personal WHERE correo = '$correo' AND contrasena = '$contrasena'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  if ($row) {
    // Redirigir al enlace de personal
    header('Location: Personal/personal.php');
    exit();
  }

  // Si no se encuentra coincidencia en ninguna tabla, mostrar un mensaje de error
  $error = "Credenciales inválidas. Por favor, verifica tus datos.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h1>Iniciar Sesión</h1>

  <?php if (isset($error)) : ?>
    <p><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="text" name="correo" placeholder="Correo electrónico" required><br>
    <input type="password" name="contrasena" placeholder="Contraseña" required><br>
    <input type="submit" value="Iniciar sesión">
  </form>

</body>
</html>





