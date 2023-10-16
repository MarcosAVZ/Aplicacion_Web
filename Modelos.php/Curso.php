<?php 
  class Curso {
    
    public $id;
    public $nombre; 
    public $docente_id; 
    
    public function listar() { 
      $db = ConnectToDatabase(); 
      $query = "SELECT * FROM cursos"; 
      $resultado = $db->query($query); 
      return $resultado->fetchAll(); 
    }

    public function obtenerPorId($id) { 
      $db = ConnectToDatabase();
      $query = "SELECT * FROM cursos WHERE id = ?";
      $sentencia = $db->prepare($query);
      $sentencia->execute([$id]);
      return $sentencia->fetchObject('Curso'); 
    }
    
    public function crear($datos) {
      $db = ConnectToDatabase();
      $query = "INSERT INTO cursos VALUES(NULL, ?, ?)";
      $sentencia = $db->prepare($query);
      $sentencia->execute([ $datos['nombre'], $datos['docente_id'] ]);
      return $db->lastInsertId(); 
    } 
    
    public function actualizar($datos) {
      $db = ConnectToDatabase();
      $query = "UPDATE cursos SET nombre=?, docente_id=? WHERE id=?";
      $sentencia = $db->prepare($query);
      $sentencia->execute([ $datos['nombre'], $datos['docente_id'], $datos['id'] ]);
      return true; 
    }
    
    public function eliminar($id) {
      $db = ConnectToDatabase();
      $query = "DELETE FROM cursos WHERE id=?"; 
      $sentencia = $db->prepare($query); 
      $sentencia->execute([$id]); return true;
    }

    public function validarDatos($datos) {

      // Validar nombre
      if(!isset($datos['nombre']) || empty($datos['nombre'])) {
        throw new Exception("El nombre es requerido");
      }
    
      // Validar docente
      if(!isset($datos['docente_id']) || empty($datos['docente_id'])) {
        throw new Exception("El docente es requerido"); 
      }
    
      // Validar otros campos
      
      // Si pasa todas las validaciones
      return true;
    
    }
  }
?>