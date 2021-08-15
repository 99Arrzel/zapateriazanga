</div>
<footer class="footer">
    <div class="footer__block block no-margin-bottom">
        <div class="container-fluid text-center">
            <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            <p class="no-margin-bottom"><?php echo fechaPeru(); ?> &copy; AJR <a
                    href="https://angelsifuentes.com">Zapatería</a>.</p>
        </div>
    </div>
</footer>
</div>
</div>
<!-- JavaScript files-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper.js/umd/popper.min.js"> </script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="js/Chart.bundle.min.js"></script>
<script src="js/front.js"></script>
<!-- <script src="js/jquery.dataTables.min.js"></script> -->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/datatable/datatables.js"> </script>
<script src="js/datatable/Buttons-1.7.1/js/dataTables.buttons.js"> </script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/datatable/RowGroup-1.1.3/js/dataTables.rowGroup.js"></script>
<script src="js/sweetalert2@10.js"></script>
<script type="text/javascript" src="js/producto.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script>
$(document).ready(function() {
    $('#table').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay datos",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(Filtro de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron coincidencias",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar orden de columna ascendente",
                "sortDescending": ": Activar orden de columna desendente"
            }
        }
    });
});
</script>
<script src="js/validaciones.js"></script>
<link rel="stylesheet" href="css/tabla.css">
</body>

</html>