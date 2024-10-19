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

<!-- Main Content -->
<div class="main-content">
    <section class="section">

            <!-- Form  -->
            <form id="agenciaform" action="">
    <!-- One "tab" for each step in the form: -->
    <div class="tab2">
        <h3 class="titulo-registro mb-3">Agregar Nueva Agencia:</h3>
        <div class="row">
            <div class="col-6">
                <p><input class="form-control" placeholder="Razón Social" name="razonSocial" required></p>
                <p><input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia" required></p>
                <p><input class="form-control" placeholder="Nombre Identificador" name="nombreIdentificador" required></p>
                <p><input class="form-control" placeholder="Rut" name="rut" required></p>
            </div>
            <div class="col-6">
                <p><input class="form-control" placeholder="Giro" name="giro" required></p>
                <p><input class="form-control" placeholder="Nombre Representante legal" name="nombreRepresentanteLegal" required></p>
                <p><input class="form-control" placeholder="Rut Representante" name="rutRepresentante" required></p>
            </div>
        </div>
    </div>
    <div class="tab2">
        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
        <div class="row">
            <div class="col-6">
                <p><input class="form-control" placeholder="Dirección" name="direccionEmpresa" required></p>
                <select class="form-select mb-3" name="id_region" id="region" required>
                    <?php foreach ($regiones as $regione) : ?>
                        <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="form-select mb-3" name="id_comuna" id="comuna" required>
                    <?php foreach ($comunas as $comuna) : ?>
                        <option value="<?php echo $comuna['id_comuna']; ?>"><?php echo $comuna['nombreComuna']; ?></option>
                    <?php endforeach; ?>
                </select>
                <p><input class="form-control" placeholder="Teléfono celular" name="telCelular" required></p>
            </div>
            <div class="col-6">
                <p><input class="form-control" placeholder="Teléfono fijo" name="telFijo" required></p>
                <p><input class="form-control" placeholder="Email" name="email" required></p>
            </div>
        </div>
    </div>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn2" onclick="nextPrev(-1)">Anterior</button>
            <button type="button" id="nextBtn2" onclick="nextPrev(1)">Siguiente</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
        <span class="step"></span>
    </div>
</form>
        
    </section>
</div>
<script src="<?php echo $ruta; ?>assets/js/formularioagencia.js"></script>

<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>


