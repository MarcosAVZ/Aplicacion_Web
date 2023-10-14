<?php
class Rol {

public $id;
public $nombre;


  public function crear($datos) {

    $db = ConnectToDatabase();

    $query = "
      INSERT INTO roles 
      (nombre)
      VALUES 
      (:nombre)  
    ";

    $sentencia = $db->prepare($query);

    $sentencia->bindParam(':nombre', $datos['nombre']);

    if($sentencia->execute()) {
      return true;
    } else {
      return false;
    }

  }

  public function listar() { 
    $db = ConnectToDatabase(); 
    $query = "SELECT * FROM roles";
    $statement = $db->query($query);
    return $statement->fetchAll(); 
  } 
    
  public function obtenerPorId($id) { 
    $db = ConnectToDatabase();
    $query = "SELECT * FROM roles WHERE id = ?";
    $statement = $db->prepare($query);
    $statement->execute([$id]);
    return $statement->fetchObject('Rol');
  }


  public function actualizar($datos) {

    $db = ConnectToDatabase();

    $query = "
      UPDATE roles
      SET nombre = :nombre  
      WHERE id = :id
    ";

    $sentencia = $db->prepare($query);

    $sentencia->bindParam(':nombre', $datos['nombre']);
    $sentencia->bindParam(':id', $datos['id']);

    if($sentencia->execute()) {
      return true;
    } else {
      return false;
    }

  }

  public function eliminar($id) {

    $db = ConnectToDatabase();

    $query = "DELETE FROM roles WHERE id = ?";

    $sentencia = $db->prepare($query);
    $sentencia->execute([$id]);

    if($sentencia->execute()) {
      return true;
    } else {
      return false;
    }

  }

}
?>