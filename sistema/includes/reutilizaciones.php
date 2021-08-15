<?php

function modal($i){
    echo '
    <div class="modal fade" id=myModal'.$i.' role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Seguro que deseas eliminar este dato? 😮</h4>
                </div>
                <div class="modal-body">
                    <input class="btn btn-danger" type="submit"   name="delete" id=del'.$i.' value="Sí, Eliminalo!">
                    <input class="btn btn-info"   type="button"   data-dismiss="modal" value="No">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>';
}
function bttnguardar_borrar($i){
    echo '
        <td class="align-middle"><input class="btn btn-info"   type="submit" id=save'.$i.' name="guardar"  value="Guardar"   disabled></td>
        <td class="align-middle"><input class="btn btn-danger" type="button" id=bdele'.$i.' data-target=#myModal'.$i.' value="Eliminar" data-toggle="modal" disabled></td> 
    ';
}
function bttnrestaurar($i){
    echo '
        <td class="align-middle"><input class="btn btn-info"   type="submit" id=rest'.$i.' name="restaurar"  value="Restaurar"></td>
    ';
}
function filtro($v1, $v2){
    echo '
    <h5 class="text-light">Filtrar por:</h5>
    <div class="row mb-3">
        <div class="col-6">
            <select name="find_options" class="form-control bg-dark text-light">
                <option id="opt_Available">Habilitados</option>
                <option id="opt_Unavailable">Deshabilitados</option>
            </select>
        </div>
        <div class="col-1">
            <button class="btn btn-success" onclick="filtro()">
                Buscar
            </button>
        </div>
    </div>
    <h5 hidden id="lbl_Available" class="text-warning">Total Habilitados: '.$v1.'</h5>
    <h5 hidden id="lbl_Unavailable" class="text-warning">Total Deshabilitados: '.$v2.'</h5>    
    ';
}

function buscar_cliente_modal(){
    echo '<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-light modal-title" id="exampleModalLabel">Seleccionar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="bg-dark">
                        <table class="col-12 table table-dark" id="table_id">
                            <thead class="thead-dark">
                                <tr>
                                    <th>CI</th>
                                    <th>NOMBRE</th>
                                    <th>APELLIDO PATERNO</th>
                                    <th>APELLIDO MATERNO</th>
                                    <th>TELEFONO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
';
}

function buscar_producto_modal(){
    echo '<div class="modal fade bd-example-modal-xl-2" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-light modal-title" id="exampleModalLabel">Seleccionar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="bg-dark">
                        <table class="col-12 table table-dark" id="table_id_pro">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>TALLA</th>
                                    <th>CATEGORIA</th>
                                    <th>MARCA</th>
                                    <th>COLOR</th>
                                    <th>PRECIO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
';
}

function buscar_producto_asignar_modal(){
    echo '<div class="modal fade bd-example-modal-xl-2" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-light modal-title" id="exampleModalLabel">Seleccionar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="bg-dark">
                        <table class="col-12 table table-dark" id="table_id_pro">
                            <thead class="thead-dark">
                                <tr>
                                <th>ID</th>
                                <th>CATEGORIA</th>
                                <th>MARCA</th>
                                <th>NOMBRE</th>
                                <th>TALLA</th>
                                <th>COLOR</th>
                                <th>CANTIDAD</th>
                                <th hidden>ID COMPRA</th>
                                <th>ACCIÓN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
';
}