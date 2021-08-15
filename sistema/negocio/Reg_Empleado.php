<?php
include "../../init.php";
$mensaje = "aaaaaaaaaaaaaaa";
if(isset($_POST['ci'],$_POST['nombre'],$_POST['apPaterno'],$_POST['apMaterno'],$_POST['telefono'],$_POST['direccion'])){
	$persona = new persona();
	$persona->ci = trim($_POST['ci']);
	$cis = Persona::traer_ci();
	foreach($cis as  $key=>$datos2){
			if(trim($_POST['ci']) == $datos2->ci){
					$mensaje = "El usuario ya existe";
			}
	}
	if($mensaje != "El usuario ya existe"){
			//Nombre
			$nombre = ucwords(strtolower($_POST['nombre']));
			$nombre = preg_replace('/\s+/', ' ', $nombre);
			$nombre = ltrim(rtrim($nombre));
			//ApellidoP
			$apPaterno = ucwords(strtolower($_POST['apPaterno']));
			$apPaterno = preg_replace('/\s+/', ' ', $apPaterno);
			$apPaterno = ltrim(rtrim($apPaterno));
			//ApellidoM
			$apMaterno = ucwords(strtolower($_POST['apMaterno']));
			$apMaterno = preg_replace('/\s+/', ' ', $apMaterno);
			$apMaterno = ltrim(rtrim($apMaterno));
			//Insertando
			$persona->ci = trim($_POST['ci']);
			$persona->nombre = $nombre;
			$persona->apPaterno = $apPaterno;
			$persona->apMaterno = $apMaterno;
			$persona->telefono = trim($_POST['telefono']);
			$persona->direccion = trim($_POST['direccion']);
			//$mensaje = "";
			if( trim($_POST['ci']) == ""        || trim($_POST['nombre']) == ""     ||
					trim($_POST['apPaterno']) == "" || trim($_POST['apMaterno'])== ""   ||
					trim($_POST['telefono']) == ""  || trim($_POST['direccion']) == ""  ||
					trim($_POST['password']) == ""  || trim($_POST['confpass']) == ""   ||
					trim($_POST['sueldo']) == ""){
					$mensaje = "No deje espacios en blanco.";
			}else{
				if(strlen($_POST['telefono']) == 8){
					if(trim($_POST['password']) == trim($_POST['confpass'])){
						//PERSONA
						$persona->create();
						$per_id = persona::devolver_ultimoID();
						//EMPLEADO
						$worker = new empleado();
						$worker->sueldo = trim($_POST['sueldo']);
													$worker->idPersona = $per_id;
						$worker->id_sucursal = trim($_POST['nsucursal']);
													$worker->create();
						$worker_id = empleado::devolver_ultimoID();
						//USUARIO
						$usuario = new usuario();
						$passhash = password_hash($_POST['password'], PASSWORD_BCRYPT);
						$usuario->usuario = $_POST['ci'];
						$usuario->password = $passhash;
						$usuario->estado = 0;
						$usuario->idEmpleado = $worker_id;
						$usuario->id_tipo_usuario = $_POST['rol'];
						$usuario->create_user();
						$mensaje = "Se registro correctamente";
					}else{
							$mensaje = "Las contraseñas no coinciden";
					}
					unset($_POST);
				}else{
					$mensaje = "Porfavor escriba un número valido";
				}
			}
	}else{
			$mensaje = "El usuario ya existe";
	}
}
echo $mensaje;
?>