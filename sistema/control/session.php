<?php
    class session{
        public $id;
        public $usuario;
        public $nombre;
        public $password;
        public $estado;
        public $logeado;
        public $id_tipo_usuario;
        public $access;
        public $ci_empleado;
        private $signed_in = false;
        public $id_sucursal;
        public $mensaje; 
        
        public function __construct()
        {
            session_start();
            $this->validar_login();
            $this->verificar_mensaje();
        }
        public function login($usuario){
            $this->id = $_SESSION['id'] = $usuario->id;
            $this->access = $_SESSION['access'] = $usuario->id_tipo_usuario;
            $this->access = $_SESSION['usuario'] = $usuario->usuario;
            $this->access = $_SESSION['nombre'] = $usuario->nombre;
            $this->ci_empleado = $_SESSION['ci_empleado'] = $usuario->ci;
            $this->id_sucursal = $_SESSION['id_sucursal'] = $usuario->id_sucursal;
            $this->logeado = $_SESSION['logeado'] = 1;
            $this->signed_in = true;
            $_SESSION ['last_login_timestamp'] = time();
        }
        public function logout(){
            unset($_SESSION['id']);
            unset($this->id);
            unset($_SESSION['access']);
            unset($this->access);
            unset($_SESSION['nombre']);
            unset($this->nombre);
            unset($_SESSION['usuario']);
            unset($this->usuario);
            unset($_SESSION['logeado']);
            unset($this->logeado);   
            unset($_SESSION['ci_empleado']);
            unset($this->ci_empleado);
            unset($_SESSION['id_sucursal']);
            unset($this->id_sucursal);            
            $this->signed_in = false;
        }
        public function is_signed_in(){
            return $this->signed_in;
        }
        public function validar_login(){
            if(isset($_SESSION['id'])){
                $this->id = $_SESSION['id'];
                $this->access = $_SESSION['access'];
                $this->signed_in=true;
            }else{
                unset($this->id);
                unset($this->access);
                unset($this->nombre);
                unset($this->usuario);
                unset($this->logeado);
                unset($this->ci_empleado);
                unset($this->id_sucursal);
                $this->signed_in=false;
            }
        }
        public function mensaje($msj=""){
            if(!empty($msj)){
                $_SESSION['mensaje'] = $msj;
            }else{
                return $this->mensaje;
            }
        }
        private function verificar_mensaje(){
            if(isset($_SESSION['persona_id']) && $this->mensaje != null){
                $this->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }else{
                $this->mensaje = "";
            }
        }
    }
    $session = new session();
?>