<?php
// Iniciar la sesión
session_start();

// Incluir archivos necesarios
require_once 'querys/qsoportes.php';
require_once 'componentes/header.php';
require_once 'componentes/sidebar.php';

// Función para escapar la salida HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
<style>
       .is-invalid {
        border-color: #dc3545 !important;
    }
    .custom-tooltip {
        position: absolute;
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }
    .custom-tooltip::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #dc3545 transparent transparent transparent;
    }
    .input-wrapper {
        position: relative;
    }

    .expand-icon {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .expand-icon.open {
        transform: rotate(90deg);
    }
    .fade-in {
        animation: fadeIn 0.1s;
    }
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    .child-row {
        background-color: #f8f9fa;
        overflow: hidden;
       
    }
    .child-row.show {
        max-height: 1000px; /* Ajusta este valor según sea necesario */
    }
    .expand-icon.fas.fa-angle-down, .expand-icon.fas.fa-angle-right {
  font-size: 17px !important;
}
.sorting_1 {
  text-align: center !important;
}
.fas.fa-globe.mediow {
  color: #EF4D36;
  font-size: 20px;
}
.dist_marketing-btn-icon__AWP8I {
  color: red;
  width: 20px;
}
</style>
<div class="main-content">
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Soportes</li>
        </ol>
    </nav><br>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Soportes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Soporte</th>
                                            <th>Nombre de Proveedor</th>
                                            <th>RUT</th>
                                            <th>Teléfono Fijo</th>
                                            <th>Teléfono Móvil</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($soportes as $soporte): ?>
                                            <?php $proveedor = $proveedoresMap[$soporte['id_proveedor']] ?? []; ?>
                                            <tr>
                                                <td><?= e($soporte['id_soporte']) ?></td>
                                                <td><?= e($soporte['nombreIdentficiador']) ?></td>
                                                <td><?= e($proveedor['nombreProveedor'] ?? '') ?></td>
                                                <td><?= e($proveedor['rutProveedor'] ?? '') ?></td>
                                                <td><?= e($proveedor['telFijo'] ?? '') ?></td>
                                                <td><?= e($proveedor['telCelular'] ?? '') ?></td>
                                                <td>
                                                    <div class="alineado">
                                                        <label class="custom-switch sino" data-toggle="tooltip"
                                                            title="<?= $soporte['estado'] ? 'Desactivar Soporte' : 'Activar Soportes' ?>">
                                                            <input type="checkbox"
                                                                class="custom-switch-input estado-soporte"
                                                                data-id="<?= e($soporte['id_soporte'] ?? '') ?>" 
                                                                data-tipo="proveedor" 
                                                                <?= isset($soporte['estado']) && $soporte['estado'] ? 'checked' : '' ?>>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                  
                                                    <a class="btn btn-primary micono" href="views/viewSoporte.php?id_soporte=<?= e($soporte['id_soporte']) ?>" data-toggle="tooltip" title="Ver Soporte">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php
                                                            // Paso 1: Obtener todos los id_medios para un id_proveedor específico
                                                            $id_sopor = $soporte['id_soporte'];

                                                            // Realiza la solicitud para obtener los datos de la tabla proveedor_medios

                                                            $id_medios_array = [];
                                                            foreach ($soportes_medios as $fila) {
                                                                if ($fila['id_soporte'] == $id_sopor) {
                                                                    $id_medios_array[] = $fila['id_medio'];
                                                                }
                                                            }                 

                                                            $medios_nombres = [];
                                                            foreach ($medios as $medio) {
                                                                if (in_array($medio['id'], $id_medios_array)) {
                                                                    $medios_nombres[] = $medio['NombredelMedio'];
                                                                }
                                                            }
                                                            $id_medios_json = json_encode($id_medios_array);
                                                            if (!empty($medios_nombres)) {
                                                                $medios_list = implode(", ", $medios_nombres);
                                                                $tooltip_content =  $medios_list;
                                                            } else {
                                                                $tooltip_content = ""; // Puedes dejarlo vacío o agregar un mensaje como "No hay medios disponibles"
                                                            }
                                                            
                                                            // Paso 3: Mostrar los nombres en una lista tipo tooltip
                                                            ?> 
                                                    <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizarSoporte" data-idmedios="<?php echo $id_medios_json; ?>"   data-id-soporte="<?= e($soporte['id_soporte']) ?>" onclick="loadProveedorDataSoporte(this)">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="assets/js/toggleSoportes.js"></script>
<script src="assets/js/getregiones.js"></script>
<script src="assets/js/actualizarsoporteindividual.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() { 
    function showError(input, message) {
        input.classList.add('is-invalid');
        var tooltip = document.getElementById(input.id + '-tooltip');
        tooltip.textContent = message;
        tooltip.style.opacity = '1';
        positionTooltip(input, tooltip);
    }

    function hideError(input) {
        input.classList.remove('is-invalid');
        var tooltip = document.getElementById(input.id + '-tooltip');
        tooltip.style.opacity = '0';
    }
    function positionTooltip(input, tooltip) {
        var rect = input.getBoundingClientRect();
        tooltip.style.left = '10px';
        tooltip.style.top = -(tooltip.offsetHeight + 5) + 'px';
    }
    var Fn = {
        validaRut: function(rutCompleto) {
            if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(rutCompleto)) return false;
            var tmp = rutCompleto.split('-');
            var digv = tmp[1];
            var rut = tmp[0];
            if (digv == 'K') digv = 'k';
            return (Fn.dv(rut) == digv);
        },
        dv: function(T) {
            var M = 0, S = 1;
            for (; T; T = Math.floor(T / 10)) S = (S + T % 10 * (9 - M++ % 6)) % 11;
            return S ? S - 1 : 'k';
        }
    };
    function validaPhoneChileno(phone) {
        // Patrón para teléfonos chilenos
        // Acepta formatos: +56912345678, 912345678, 221234567
        var phonePattern = /^(\+?56|0)?([2-9]\d{8}|[2-9]\d{7})$/;
        return phonePattern.test(phone);
    }

    // Validación en tiempo real para RUTs
    var rutInputs = document.querySelectorAll('#rutProveedorp, #rutRepresentantep, #rutRepresentantex, #rutSoporte, #rut_soporte, #rutRepresentante');
    rutInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value === "") {
                hideError(this);
            } else if (!Fn.validaRut(this.value)) {
                showError(this, "RUT INVALIDO - DEBES INGRESAR SIN PUNTOS Y CON GUIÓN");
            } else {
                hideError(this);
            }
        });
    });
 

   // Validación en tiempo real para Email
   var emailInputs = document.querySelectorAll('.email-input');
var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

emailInputs.forEach(function(emailInput) {
    emailInput.addEventListener('input', function() {
        if (this.value === "") {
            hideError(this);
        } else if (!emailPattern.test(this.value)) {
            showError(this, "EMAIL INCORRECTO");
        } else {
            hideError(this);
        }
    });
});

      // Validación en tiempo real para teléfonos
      var phoneInputs = document.querySelectorAll('.phone-input');
phoneInputs.forEach(function(input) {
    input.addEventListener('input', function() {
        if (this.value === "") {
            hideError(this);
        } else if (!validaPhoneChileno(this.value)) {
            showError(this, "NÚMERO DE TELÉFONO NO VÁLIDO");
        } else {
            hideError(this);
        }
    });
});


});

</script>
<!-- <script src="assets/js/getmedios.js"></script> -->
<script>
function getSoporteData(idSoporte) {
    var soportesMap = <?php echo json_encode($soportesMap); ?>;
    return soportesMap[idSoporte] || null;
}
</script>

<?php 
require_once 'views/modalUpdateSoportes.php';
require_once 'componentes/settings.php';
require_once 'componentes/footer.php';
?>