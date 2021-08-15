<?php include_once "includes/header.php";
$mensaje = "";
if(isset($_POST['cambiar_pass'])){
    $usuario = new usuario();
    $vusuario = $_SESSION['usuario'];
    $vpassword = $_POST['password'];
    $pass = usuario::verificar_password($vusuario, $vpassword);
    if($pass != false){
        if(trim($_POST['password2']) == ""  || trim($_POST['confpass2']) == ""){
            $mensaje = "No deje espacios en blanco.";
        }else{
            if(trim($_POST['password2']) == trim($_POST['confpass2'])){
                //USUARIO
                $passhash = password_hash($_POST['password2'], PASSWORD_BCRYPT);
                $usuario->usuario = $vusuario;
                $usuario->password = $passhash;
                $usuario->update_password();
                $mensaje = "La contraseña fue cambiada";
            }else{
                $mensaje = "Las contraseñas no coinciden";
            }
            unset($_POST);
        }
    }else{
        $mensaje = "La contraseña actual es incorrecta";
    }
}
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 text-light">Configuración</h1>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Información Personal
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="text-light">Usuario: <strong><?php echo $_SESSION['usuario']; ?></strong></label>
                    </div>
                    <div class="form-group">
                        <label class="text-light">Nombre: <strong><?php echo $_SESSION['nombre']; ?></strong></label>
                    </div>
                    <div class="form-group">
                        <label class="text-light">Rol: 
                            <?php if($_SESSION['access'] == 1){?>	
                                <strong class="text-light"><?= "Administrador"; ?></strong>
                            <?php } ?>
                            <?php if($_SESSION['access'] == 2){?>	
                                <strong class="text-light"><?= "Vendedor"; ?></strong>
                            <?php } ?>
                            <?php if($_SESSION['access'] == 3){?>	
                                <strong class="text-light"><?= "Encargado de Almacen"; ?></strong>
                            <?php } ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="text-light">Sucursal: #<strong><?= $_SESSION['id_sucursal'];?></strong></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Cambiar Contraseña
                </div>
                <div class="card-body">
                    <label class="text-warning h3"><?php echo $mensaje; ?></label>            
                    <form action="" method="post" autocomplete="off" class="p-3">
                    <div class="form-group">
                        <label class="text-light">Contraseña Actual</label>
                        <input type="password" name="password" id="actual" placeholder="Clave Actual" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="text-light">Nueva Contraseña</label>
                        <input type="password" onkeypress="return /[a-z 0-9]/i.test(event.key)" name="password2" id="password" placeholder="Nueva Contraseña" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="text-light">Confirmar Contraseña</label>
                        <input type="password" onkeypress="return /[a-z 0-9]/i.test(event.key)" name="confpass2" id="confpass" placeholder="Confirmar Contraseña" required class="form-control">
                    </div>
                    <div>
                        <button type="submit" name="cambiar_pass" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <pre class="text-light">
        ⠀⠀           ⣠⣴⣶⣿⣿⣷⣶⣄⣀⣀⠀⠀⠀⠀⠀⠀⠀⠀⠀
        ⠀⠀⠀⠀⠀⠀⠀⠀⠀⣰⣾⣿⣿⡿⢿⣿⣿⣿⣿⣿⣿⣿⣷⣦⡀⠀⠀⠀⠀⠀
        ⠀⠀⠀⠀⠀⠀⠀⢀⣾⣿⣿⡟⠁⣰⣿⣿⣿⡿⠿⠻⠿⣿⣿⣿⣿⣧⠀⠀⠀⠀
        ⠀⠀⠀⠀⠀⠀⠀⣾⣿⣿⠏⠀⣴⣿⣿⣿⠉⠀⠀⠀⠀⠀⠈⢻⣿⣿⣇⠀⠀⠀
        ⠀⠀⠀⠀⢀⣠⣼⣿⣿⡏⠀⢠⣿⣿⣿⠇⠀⠀⠀⠀⠀⠀⠀⠈⣿⣿⣿⡀⠀⠀
        ⠀⠀⠀⣰⣿⣿⣿⣿⣿⡇⠀⢸⣿⣿⣿⡀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⡇⠀⠀
        ⠀⠀⢰⣿⣿⡿⣿⣿⣿⡇⠀⠘⣿⣿⣿⣧⠀⠀⠀⠀⠀⠀⢀⣸⣿⣿⣿⠁⠀⠀
        ⠀⠀⣿⣿⣿⠁⣿⣿⣿⡇⠀⠀⠻⣿⣿⣿⣷⣶⣶⣶⣶⣶⣿⣿⣿⣿⠃⠀⠀⠀
        ⠀⢰⣿⣿⡇⠀⣿⣿⣿⠀⠀⠀⠀⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠁⠀⠀⠀⠀
        ⠀⢸⣿⣿⡇⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀⠉⠛⠛⠛⠉⢉⣿⣿⠀⠀⠀⠀⠀⠀
        ⠀⢸⣿⣿⣇⠀⣿⣿⣿⠀⠀⠀⠀⠀⢀⣤⣤⣤⡀⠀⠀⢸⣿⣿⣿⣷⣦⠀⠀⠀
        ⠀⠀⢻⣿⣿⣶⣿⣿⣿⠀⠀⠀⠀⠀⠈⠻⣿⣿⣿⣦⡀⠀⠉⠉⠻⣿⣿⡇⠀⠀
        ⠀⠀⠀⠛⠿⣿⣿⣿⣿⣷⣤⡀⠀⠀⠀⠀⠈⠹⣿⣿⣇⣀⠀⣠⣾⣿⣿⡇⠀⠀
        ⠀⠀⠀⠀⠀⠀⠀⠹⣿⣿⣿⣿⣦⣤⣤⣤⣤⣾⣿⣿⣿⣿⣿⣿⣿⣿⡟⠀⠀⠀
        ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠉⠻⢿⣿⣿⣿⣿⣿⣿⠿⠋⠉⠛⠋⠉⠉⠁⠀⠀⠀⠀
        ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠉⠉⠉⠁⠀⠀⠀⠀
    </pre>
</div>
<?php include_once "includes/footer.php"; ?>