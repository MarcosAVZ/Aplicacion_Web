<?php
        //credenciales de acceso a la base datos
        function conectar() {

            $server = "localhost";
            $user = "root"; 
            $password = "";
            $database = "db_connect";
          
            $conn = mysqli_connect($server, $user, $password, $database);
        
            if(!$conn) {
              echo "Error: No se pudo conectar a MySQL.";
              exit;
            }
          
            return $conn;
          
          }
          
?>  