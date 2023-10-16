<?php 
    require_once 'Usuario.php';
     
    class ControladorUsuarios {

        protected $usuario;
        
        public function __construct() { 
            $this->usuario = new Usuario(); 
        } 
        
        public function listaUsuarios() {
            return $this->usuario->listar();
        }
              
        public function crearUsuario() {
             if(!empty($_POST)) { 
                if($this->usuario->crear($_POST)) {
                     header('Location: /usuarios'); exit;
                    }
                } 
            return 'Error al crear usuario'; 
        }

        public function obtenerUsuario($id) {
            return $this->usuario->obtenerPorId($id); 
        }
                
        public function actualizarUsuario() {
            if(!empty($_POST)) {
                if($this->usuario->actualizar($_POST)) {
                     header('Location: /usuarios'); exit; 
                    } 
            } 
            return 'Error al actualizar usuario'; 
        }
                    
        public function eliminarUsuario($id) {
            if($this->usuario->eliminar($id)) {
               header('Location: /usuarios'); exit; 
            }
            return 'Error al eliminar usuario'; 
        } 
    } 
?>