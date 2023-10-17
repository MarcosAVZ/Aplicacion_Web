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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Login</title>

  <style>
    body {
      background-color: #f5f5f5;
    }

    .login-form {
      margin-top: 100px;
      margin-bottom: 100px;
    }

    #footer {
      position: fixed;
      right: 0;
      bottom: 0;
      margin: 0;
      padding: 0;
    }

    #footer img {
      width: 200px;
      opacity: 0.2;
    }
  </style>
</head>

<body>

  <?php if (isset($error)) : ?>
    <p><?php echo $error; ?></p>
  <?php endif; ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 login-form">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>
        <form method="POST" action="">
          <div class="form-group">
            <input type="text" class="form-control" name="correo" placeholder="Correo electrónico" required><br>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required><br>
          </div>
          <input type="submit" class="btn btn-primary btn-block" value="Iniciar sesión">
        </form>
      </div>
    </div>
  </div>

  <div id="footer">
    <img src="..\Logotipo200x200.png">
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>