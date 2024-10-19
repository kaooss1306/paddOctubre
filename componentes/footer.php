<?php $anio_actual = date("Y");?>
<footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; <?php echo $anio_actual;?> <div class="bullet"></div> Desarrollado por <a href="#">Origen Medios</a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
  <!-- General JS Scripts -->
  <script src="<?php echo $ruta; ?>assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="<?php echo $ruta; ?>assets/bundles/apexcharts/apexcharts.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo $ruta; ?>assets/js/page/index.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo $ruta; ?>assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo $ruta; ?>assets/js/custom.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
  <script src="<?php echo $ruta; ?>assets/bundles/bootstrap/js/bootstrap.min.js"></script>
  <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="assets/js/formulariomultipass.js"></script>
   JS Libraies -->
   
   <script src="<?php echo $ruta; ?>assets/bundles/datatables/datatables.min.js"></script>
  <script src="<?php echo $ruta; ?>assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo $ruta; ?>assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo $ruta; ?>assets/js/page/datatables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Template JS File -->
 
  <script>
$(document).ready(function() {
    $('.estado-switch').change(function() {
        var $switch = $(this);
        var id = $switch.data('id');
        var estado = $switch.prop('checked') ? 1 : 0;
        var tipo = $switch.data('tipo');

        $.ajax({
            url: 'hooks/updateEstado2.php',
            type: 'POST',
            data: {
                id: id,
                estado: estado,
                tipo: tipo
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('Estado actualizado correctamente');
                } else {
                    console.error('Error al actualizar el estado:', response.message);
                    $switch.prop('checked', !$switch.prop('checked'));
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                console.log('Respuesta del servidor:', jqXHR.responseText);
                $switch.prop('checked', !$switch.prop('checked'));
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>