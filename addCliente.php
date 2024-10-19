<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
// Incluir el header y la barra lateral
include 'componentes/header.php';
include 'componentes/sidebar.php';
include 'querys/qinsertclient.php';
?>
<style>
    .invalid {
    border: 2px solid red;
}

.error-message {
    color: red;
    font-size: 11px;
    text-align:center;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
}

.error-message.active {
    opacity: 1;
    max-height: 30px;
}
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <!-- Form  -->
        <form id="regForm" action="">
            <!-- One "tab" for each step in the form: -->
            <div class="tab">
                <h3 class="titulo-registro mb-3">Información cliente:</h3>
                <div class="row">
                    <div class="col-6">
                        <p><input class="form-control" placeholder="Nombre de cliente" name="nombreCliente"></p>
                        <p><input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia"></p>
                        <select class="form-select mb-3" name="id_tipoCliente" id="tipocliente">
                            <?php foreach ($tiposClientes as $tiposCliente) : ?>
                                <option value="<?php echo $tiposCliente['id_tyipoCliente']; ?>"><?php echo $tiposCliente['nombreTipoCliente']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p><input class="form-control" placeholder="Razón Social" name="razonSocial"></p>
                        <p><input class="form-control" placeholder="Grupo" name="grupo"></p>
                    </div>
                    <div class="col-6">
                        <div class="input-container">
                            <p><input class="form-control" placeholder="Rut Empresa" name="RUT"></p>
                            <div class="error-message" id="RUT-error">RUT INVALIDO - DEBES INGRESAR SIN PUNTOS Y CON GUIÓN</div>
                        </div>
                        <p><input class="form-control" placeholder="Giro" name="giro"></p>
                        <p><input class="form-control" placeholder="Nombre representante legal" name="nombreRepresentanteLegal"></p>
                        <div class="input-container">
                            <p><input class="form-control" placeholder="Rut Representante" name="Rut_representante"></p>
                            <div class="error-message" id="Rut_representante-error">RUT INVALIDO - DEBES INGRESAR SIN PUNTOS Y CON GUIÓN</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab">
                <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                <div class="row">
                    <div class="col-6">
                        <p><input class="form-control" placeholder="Dirección" name="direccionEmpresa"></p>
                        <select class="form-select mb-3" name="id_region" id="region" required>
                            <?php foreach ($regiones as $regione) : ?>
                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="form-select mb-3" name="id_comuna" id="comuna" required>
                            <?php foreach ($comunas as $comuna) : ?>
                                <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                    <?php echo $comuna['nombreComuna']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p><input class="form-control" placeholder="Teléfono celular" name="telCelular"></p>
                    </div>
                    <div class="col-6">
                        <p><input class="form-control" placeholder="Teléfono fijo" name="telFijo"></p>
                        <div class="input-container">
                            <p><input class="form-control" placeholder="Email" name="email" id="email"></p>
                            <div class="error-message" id="email-error">EMAIL INCORRECTO</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab">
                <h3 class="titulo-registro mb-3">Otros datos</h3>
                <div class="row">
                    <div class="col">
                        <p><input class="form-control" placeholder="Formato" name="formato"></p>
                    </div>
                    <div class="col">
                        <p><input class="form-control" placeholder="Moneda" name="nombreMoneda"></p>
                    </div>
                    <div class="col">
                        <p><input class="form-control" placeholder="Valor" name="valor"></p>
                    </div>
                </div>
            </div>
            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn">Anterior</button>
                    <button type="button" id="nextBtn">Siguiente</button>
                </div>
            </div>
            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </form>
    </section>
</div>

<script src="<?php echo $ruta; ?>assets/js/formulariomultipass.js"></script>
<script>
document.getElementById('region').addEventListener('change', function () {
    var regionId = this.value;
    var comunaSelect = document.getElementById('comuna');
    var opcionesComunas = comunaSelect.querySelectorAll('option');

    opcionesComunas.forEach(function (opcion) {
        if (opcion.getAttribute('data-region') === regionId) {
            opcion.style.display = 'block';
        } else {
            opcion.style.display = 'none';
        }
    });

    var firstVisibleOption = comunaSelect.querySelector('option[data-region="' + regionId + '"]');
    if (firstVisibleOption) {
        firstVisibleOption.selected = true;
    }
});

document.getElementById('region').dispatchEvent(new Event('change'));
</script>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>