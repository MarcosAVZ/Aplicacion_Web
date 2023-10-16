<?php 
    require_once 'Rol.php'; 
    
    class RolController {
        protected $rol;
        
        public function __construct() {
            $this->rol = new Rol(); 
        }
        
        public function listaRoles() {
            $roles = $this->rol->listar();
            return include('views/roles/index.php');
        }
        
        public function crearRol() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($this->rol->crear($_POST)) {
                    header('Location: /roles'); exit; 
                } 
            } 
            return include('views/roles/crear.php');
        }
        
        public function obtenerRol($id) {
            $rol = $this->rol->obtenerPorId($id);
            return include('views/roles/ver.php');
        }
            
        public function editarRol($id) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($this->rol->actualizar($_POST)) { 
                    header('Location: /roles'); exit; 
                }
            }
            $rol = $this->rol->obtenerPorId($id);
            return include('views/roles/editar.php');
        }
        
        public function eliminarRol($id) {
            $this->rol->eliminar($id); header('Location: /roles'); 
        }
    } 
?>