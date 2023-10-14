<?php 

   require_once 'conexion.php';

   $db = conectar();

   if(isset($_POST['email'])) {
      
      $email = $_POST['email'];
      
      // Validar email 
      
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         
         echo "Email inválido";
         
         exit; 
         
      } 
      // Primera consulta
      
      $stmt = $db->prepare("SELECT u.id, u.email, ur.id_rol FROM usuarios u INNER JOIN usuarios_roles ur ON u.id = ur.id_usuario WHERE u.email = ?");
      
      $stmt->bind_param("s", $email); if($stmt->execute()) {
         
         $usuario = $stmt->get_result()->fetch_assoc(); 
      } else {
         echo "Error en la primera consulta: " . $stmt->error; exit; } 
   } 
   // Extraer id_rol

   $rol_id = $usuario['id_rol'];

   // Segunda consulta

   $stmt = $db->prepare("SELECT r.nombre AS rol FROM roles r WHERE r.id = ?");

   $stmt->bind_param("i", $rol_id); if($stmt->execute()) {
      
      $row = $stmt->get_result()->fetch_assoc();
      
      $rol = $row['rol']; 
   } else {echo "Error en la segunda consulta: " . $stmt->error; exit;}

   // Validar rol 
   if($rol == "Autoridad") {
      
      require_once('login.php'); 
   } 
   if($rol == "Personal") {
      require_once('personal.php');
   } else { echo "Usuario o contraseña incorrectos"; } 
      
?>