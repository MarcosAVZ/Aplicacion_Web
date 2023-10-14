<?php

require_once 'Alumno.php';

class AlumnoController {

  protected $alumno;

  public function __construct() {
    $this->alumno = new Alumno();
  }

  public function listaAlumnos() {

    $alumnos = $this->alumno->listar();

    require 'views/alumnos/index.php';

    $data = ['alumnos' => $alumnos]; 

    extract($data);

  }

  public function crearAlumno() {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      if($this->alumno->crear($_POST)) {
        header('Location: /alumnos');
        exit;  
      }

    }

    return include('views/alumnos/crear.php');

  }

  public function obtenerAlumno($id) {

    $alumno = $this->alumno->obtenerPorId($id);

    require 'views/alumnos/ver.php';

    $data = ['alumno' => $alumno];

    extract($data);

  }

  public function editarAlumno($id) {

    $alumno = $this->alumno->obtenerPorId($id);
  
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
  
      if($this->alumno->actualizar($_POST)) {
        header('Location: /alumnos'); 
        exit;
      }
  
    }
  
    require 'views/alumnos/editar.php';

    $data = ['alumno' => $alumno];

    extract($data);
  
  }
  
  public function eliminarAlumno($id) {
  
    $this->alumno->eliminar($id);
  
    header('Location: /alumnos');
    exit;
  
  }
  
  public function verAlumno($id) {
  
    $alumno = $this->alumno->obtenerPorId($id);
  
    
  require 'views/alumnos/ver.php';

  $data = ['alumno' => $alumno];

  extract($data);
  
  }

}

?>