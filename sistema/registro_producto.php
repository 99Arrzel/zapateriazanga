<?php include_once "includes/header.php";
$marcas = marca::traer_marcas_habilitadas();
$categorias = categoria::traer_categorias_habilitadas();
$proveedores = proveedor::traer_proveedores_habilitados();
$colores = color::traer_colores_habilitados();
//SI INTENTAS HACER ESTA CACA EN AJAX, NO TE VA AGARRAR
//NINGUNA SOLA VARIABLE $_FILES[] NOSE PORQUE 😥😥
if(isset($_POST['registrar_producto']))
{
  if(trim($_POST['nombre']) == "" || trim($_POST['talla']) == "" || trim($_POST['precio']) == ""){
      $mensaje = "No deje espacios en blanco";
  }else{
      $filename = $_FILES["uploadfile"]["name"];
      $tempname = $_FILES["uploadfile"]["tmp_name"];   
      $folder = "img/".$filename;
      move_uploaded_file($tempname, $folder);
      //Instanciando
      $product = new producto;
      //Corrigiendo Nombre
      $nombre = ucwords(strtolower($_POST['nombre']));
      $nombre = preg_replace('/\s+/', ' ', $nombre);
      $nombre = ltrim(rtrim($nombre));
      
      $product->nombre = $nombre;
      $product->talla = $_POST['talla'];
      $product->foto = $filename;
      
      $product->precio = $_POST['precio'];
      $product->id_marca = $_POST['id_marca'];
      $product->id_categoria = $_POST['id_categoria'];
      $product->id_color = $_POST['id_color'];
      $product->id_proveedor = $_POST['id_proveedor'];
      $product->create();
      unset($_POST);
      $mensaje = "Se registro correctamente";
  }
}   
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-light">Registrar Producto</h1>
    <a href="lista_productos.php" class="btn btn-primary text-white font-weight-bold">Listar</a>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          Nuevo Producto
        </div>
        <div id="mcform" class="card-body">
          <form action="" method="post" autocomplete="off" id="frm_reg_producto" enctype='multipart/form-data'>
            <label class="text-warning h3" id="lblMensaje"><?= $mensaje?></label>
            <div class="form-group">
              <label for="nombre" class="text-light">Nombre</label>
              <input type="text" onkeypress="return /[a-z ]/i.test(event.key)" placeholder="Nombre del producto"
                name="nombre" id="nombre" class="text-light form-control" required>
            </div>
            <div class="form-group">
              <label class="text-light">Color</label>
              <select id="id_color" name="id_color" class="text-light bg-dark form-control">
                <?php for($i = 0; $i<count($colores); $i=$i+1){?>
                <option value='<?= $colores[$i]->id ?>'>
                  <?= $colores[$i]->nombre ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="talla" class="text-light">Talla</label>
              <input type="text" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Ingrese la talla"
                class="text-light form-control" name="talla" id="talla" required>
            </div>
            <div class="form-group">
              <label for="precio" class="text-light">Precio</label>
              <input type="text" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Ingrese precio"
                class="text-light  form-control" name="precio" id="precio" required>
            </div>
            <div class="form-group">
              <label class="text-light">Proveedor</label>
              <select id="proveedor" name="id_proveedor" class="bg-dark text-light form-control">
                <?php for($i = 0; $i<count($proveedores); $i=$i+1){?>
                <option class="text-light" value='<?= $proveedores[$i]->id?>'>
                  <?= $proveedores[$i]->nombre ?>
                </option>
                <?php } ?>
              </select>
            </div> 
            <div class="form-group">
              <label class="text-light">Categoría</label>
              <select id="categoria" name="id_categoria" class="bg-dark text-light form-control">
                <?php for($i = 0; $i<count($categorias); $i=$i+1){?>
                <option class="text-light" value='<?= $categorias[$i]->id?>'>
                  <?= $categorias[$i]->nombre ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label class="text-light">Marca</label>
              <select id="marca" name="id_marca" class="bg-dark text-light form-control">
                <?php for($i = 0; $i<count($marcas); $i=$i+1){?>
                <option class="text-light" value='<?= $marcas[$i]->id?>'><?= $marcas[$i]->nombre ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="uploadfile" class="text-light">Seleccione la foto</label>
              <input type="file" name="uploadfile" value="" />
            </div>
            <button type="submit" id="bttn_reg_producto" name="registrar_producto" class="btn btn-primary">Guardar
              Producto</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>