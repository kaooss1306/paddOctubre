<?php $anio_actual = date("Y");?>
<footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; <?php echo $anio_actual;?> <div class="bullet"></div> Desarrollado por <a href="#">Origen Medios</a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <!-- JS Libraies -->
   <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>
  <!-- Template JS File -->


<script>
$(document).ready(function() {
    const COLORS = { ACTIVE: '#28a745', INACTIVE: '#dc3545' };

    function updateSwitch($switch, state = null) {
        if (state !== null) $switch.prop('checked', state);
        $switch.siblings('.custom-switch-indicator')
               .css('background-color', ($switch.prop('checked') ? COLORS.ACTIVE : COLORS.INACTIVE) + ' !important');
    }

    function handleAjax($switch, estado) {
        $.ajax({
            url: 'hooks/updateEstado.php',
            method: 'POST',
            data: { id_planes_publicidad: $switch.data('id'), Estado: estado },
            success: response => {
                try {
                    if (!JSON.parse(response).success) throw new Error(response);
                } catch (e) {
                    console.error('Error:', e);
                    updateSwitch($switch, !estado);
                }
            },
            error: () => {
                console.error('Error en la solicitud AJAX');
                updateSwitch($switch, !estado);
            }
        });
    }

    $('.custom-switch-input').each(function() {
        updateSwitch($(this));
    }).on('change', function() {
        const $switch = $(this);
        updateSwitch($switch);
        handleAjax($switch, $switch.prop('checked') ? 1 : 0);
    });
});
</script>
</body>

</html>