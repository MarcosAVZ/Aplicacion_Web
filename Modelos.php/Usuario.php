<?php
 function ConnectToDatabase() {
   $db = mysqli_connect("localhost", "root", "", "database");
    if(!$db) {
       die("Error connecting to database");
    } 
    return $db; 
  }

class Usuario {

public $id;
public $nombre;
public $email; 
public $password;
public $rol_id;


  // Método para listar
  public function listar() { 
    $db = ConnectToDatabase();
    $query = "SELECT * FROM Usuarios";
    $resultado = $db->query($query);
    return $resultado->fetch_all(MYSQLI_ASSOC); 
  }

  // Método para obtener por ID
  public function obtenerPorId($id) {
    $db = ConnectToDatabase();
    $query = "SELECT * FROM Usuarios WHERE id = ?";
    $sentencia = $db->prepare($query);
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    return $sentencia->get_result()->fetch_assoc();
  }

  public function crear($datos) {
    $db = ConnectToDatabase(); 
    $nombre = $datos['nombre'];
    $email = $datos['email'];
    $password = $datos['password'];
    $query = "INSERT INTO Usuarios VALUES (NULL, '$nombre', '$email', '$password')";
    $resultado = $db->query($query); return $db->insert_id;
  }
  
// Actualizar usuario
  public function actualizar($datos) { 
    $db = ConnectToDatabase(); 
    $id = $datos['id']; 
    $nombre = $datos['nombre']; 
    $email = $datos['email']; 
    $query = "UPDATE Usuarios SET nombre='$nombre', email='$email' WHERE id='$id'"; 
    $resultado = $db->query($query); return $resultado; 
  } 
  
  public function eliminar($id) {
    $db = ConnectToDatabase();
    $query = "DELETE FROM Usuarios WHERE id='$id'";
    $resultado = $db->query($query);
    return $resultado; 
  }

}

?>