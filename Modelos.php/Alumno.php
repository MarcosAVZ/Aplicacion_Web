<?php

require_once 'conexion.php';
class Alumno {

public $id;
public $nombre;
public $apellido;
public $curso_id;

  
    
    public function listar() {

        $db = conectar();

        $query = "SELECT * FROM alumnos";

        $resultado = $db->query($query);

        $datos = [];

        while($fila = $resultado->fetch_assoc()) {

            $id = $fila['id'];
            $nombre = $fila['nombre'];  
            $email = $fila['email'];

            $alumno = new Alumno($id, $nombre, $email);

            $datos[] = $alumno;

        }

    return $datos;

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