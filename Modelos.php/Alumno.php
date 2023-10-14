<?php
class Alumno {

public $id;
public $nombre;
public $apellido;
public $curso_id;

    public function listar() { 
            $db = ConnectToDatabase(); 
            $query = "SELECT * FROM alumnos"; 
            $resultado = $db->query($query); 
            return $resultado->fetchAll(); 
    }
    
    public function obtenerPorId($id) {
        $db = ConnectToDatabase();
        $query = "SELECT * FROM alumnos WHERE id = ?";
        $sentencia = $db->prepare($query);
        $sentencia->execute([$id]);
        return $sentencia->fetchObject('Alumno'); 
    }

    public function insertar($datos) {
        $db = ConnectToDatabase(); 
        $campos = '`nombre`, `apellidos`, `email`';
        $valores = "'".$datos['nombre']."', '".$datos['apellidos']."', '".$datos['email']."'"; 
        $query = "INSERT INTO alumnos ($campos) VALUES ($valores)";
        $sentencia = $db->prepare($query);
        $resultado = $sentencia->execute();
        return $resultado; 
    }

    public function actualizar($datos) {
        $db = ConnectToDatabase();
        $camposValores = "";
        foreach($datos as $campo => $valor)
            { $camposValores .= "`$campo`='$valor', "; }
        $camposValores = rtrim($camposValores, ', ');
        $query = "UPDATE alumnos SET $camposValores WHERE id={$datos['id']}"; $sentencia = $db->prepare($query);
        $resultado = $sentencia->execute();
        return $resultado; 
    }

    public function eliminar($id) { 
        $db = ConnectToDatabase();
        $query = "DELETE FROM alumnos WHERE id=?";
        $sentencia = $db->prepare($query);
        $resultado = $sentencia->execute([$id]);
        return $resultado; 
    }

    public function crear($datos) {

        $db = ConnectToDatabase();
    
        $campos = '`nombre`, `apellidos`, `email`';
        $valores = "'".$datos['nombre']."', '".$datos['apellidos']."', '".$datos['email']."'";
    
        $query = "INSERT INTO alumnos ($campos) VALUES ($valores)";
    
        $sentencia = $db->prepare($query);
        $resultado = $sentencia->execute();
    
        return $resultado;
    
    }
}
?>