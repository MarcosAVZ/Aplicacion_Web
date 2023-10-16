<?php
require_once 'conexion.php';

$db = conectar();

if (isset($_POST['email'])) {
   $email = $_POST['email'];

   // Validar email
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Email inválido";
      exit;
   }

   // Primera consulta
   $stmt = $db->prepare("SELECT u.id, u.email, ur.id_rol FROM usuarios u INNER JOIN usuarios_roles ur ON u.id = ur.id_usuario WHERE u.email = ?");
   $stmt->bind_param("s", $email);

   if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
         $usuario = $result->fetch_assoc();
         $rol_id = $usuario['id_rol'];

         // Segunda consulta
         $stmt = $db->prepare("SELECT r.nombre AS rol FROM roles r WHERE r.id = ?");
         $stmt->bind_param("i", $rol_id);

         if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
               $row = $result->fetch_assoc();
               $rol = $row['rol'];

               // Redireccionar según el rol del usuario utilizando JavaScript
               switch ($rol) {
                  case "Autoridad":
                     $redirectUrl = "login.php";
                     break;
                  case "Personal":
                     $redirectUrl = "Personal/personal.php";
                     break;
                  case "Docente":
                     $redirectUrl = "Docentes/Docente.php";
                     break;
                  case "Padre":
                     $redirectUrl = "padres.php";
                     break;
                  case "Alumno":
                     $redirectUrl = "personal.php";
                     break;
                  default:
                     echo "Rol inválido";
                     exit;
               }

               echo '<script>window.location.href = "' . $redirectUrl . '";</script>';
               exit;
            } else {
               echo "No se encontró el rol";
            }
         } else {
            echo "Error en la segunda consulta: " . $stmt->error;
         }
      } else {
         echo "No se encontró el usuario";
      }
   } else {
      echo "Error en la primera consulta: " . $stmt->error;
   }
}
?>
