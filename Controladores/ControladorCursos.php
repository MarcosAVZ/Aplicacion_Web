<?php 
    require_once 'Curso.php';
    
    class ControladorCursos {
        
        protected $curso;
          
        public function __construct() {
            $this->curso = new Curso(); 
        }
        
        public function listaCursos() {
            $cursos = $this->curso->listar();
            return include('views/cursos/index.php'); 
        }
        
        public function crearCurso() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($this->curso->crear($_POST)) {
                     header('Location: /cursos'); exit; 
                } 
            }
            return include('views/cursos/crear.php'); 
        } 
        
        public function obtenerCurso($id) {
            $curso = $this->curso->obtenerPorId($id);
            return include('views/cursos/ver.php');
        }
         
        public function eliminarCurso($id) {
            $this->curso->eliminar($id);
            header('Location: /cursos');
        } 
    } 
?>