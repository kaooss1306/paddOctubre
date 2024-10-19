<?php
// Iniciar la sesión
session_start();
// Definir variables de configuración
//$ruta = 'localhost/paddv4/';
// Función para hacer peticiones cURL
include '../querys/qsoportes.php';
// Obtener el ID del cliente de la URL
$id_soporte = isset($_GET['id_soporte']) ? $_GET['id_soporte'] : null;




$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?id_soporte=eq.$id_soporte&select=*";
$soporte = makeRequest($url);



$datosSoporte = $soporte[0];


include '../componentes/header.php';
include '../componentes/sidebar.php';
?>
<!-- Main Content -->
<div class="main-content">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListSoportes.php">Ver Soporte</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $datosSoporte['nombreIdentficiador']; ?></li>
        </ol>
    </nav>
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="clearfix"></div>
                                <div class="author-box-job">
                                    Nombre Soporte:
                                    
                                </div>
                                <div class="nombrex author-box-name">
                                <div class="cabeza">
                             <h4> <?php echo $datosSoporte['nombreIdentficiador']; ?></h4> 
                             <button type="button" class="btn btn-danger micono" data-bs-toggle="modal" data-bs-target="#actualizar_soportes" data-id-soporte="<?= $id_soporte ?>" onclick="obtenerDatos(<?= $id_soporte  ?>)" ><i class="fas fa-pencil-alt"></i> Editar datos</button>
                            </div>
                                   
                                </div>
                                <!-- <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizar_soportes" data-id-soporte="<?= $id_soporte ?>" onclick="loadSoportePro(this)">
                                    <i class="fas fa-pencil-alt"></i>
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-bs-toggle="tab" href="#facturacion" role="tab" aria-selected="true">Detalles del Soporte
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="facturacion" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="row">
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Razon Social</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosSoporte['razonSocial']; ?></p>
                                            <strong>Representante Legal</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosSoporte['nombreRepresentanteLegal']; ?></p>
                                            <strong>Telefono Fijo</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosSoporte['telFijo']; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Nombre Fantasia</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['nombreFantasia'];
                                                ?>
                                            </p>
                                            <strong>Rut Representante</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['rutRepresentante'];
                                                ?>
                                            </p>
                                            <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['email'];
                                                ?>
                                            </p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Rut soporte</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['rut_soporte'];
                                                ?>
                                            </p>
                                            <strong>Dirección</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['direccion'];
                                                ?>
                                            </p>
                                            <strong>Bonificacion Año</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['bonificacion_ano'];
                                                ?>
                                            </p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Giro</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['giro'];
                                                ?>
                                            </p>
                                            <strong>Telefono Celular</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['telCelular'];
                                                ?>
                                            </p>
                                            <strong>Escala</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php
                                                echo $datosSoporte['escala'];
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="settingSidebar">
        <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
        </a>
        <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
                <div class="setting-panel-header">Setting Panel
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Select Layout</h6>
                    <div class="selectgroup layout-color w-50">
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                            <span class="selectgroup-button">Light</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                            <span class="selectgroup-button">Dark</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Sidebar Color</h6>
                    <div class="selectgroup selectgroup-pills sidebar-color">
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Color Theme</h6>
                    <div class="theme-setting-options">
                        <ul class="choose-theme list-unstyled mb-0">
                            <li title="white" class="active">
                                <div class="white"></div>
                            </li>
                            <li title="cyan">
                                <div class="cyan"></div>
                            </li>
                            <li title="black">
                                <div class="black"></div>
                            </li>
                            <li title="purple">
                                <div class="purple"></div>
                            </li>
                            <li title="orange">
                                <div class="orange"></div>
                            </li>
                            <li title="green">
                                <div class="green"></div>
                            </li>
                            <li title="red">
                                <div class="red"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Mini Sidebar</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Sticky Header</span>
                        </label>
                    </div>
                </div>
                <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                    <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                        <i class="fas fa-undo"></i> Restore Default
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    
</script>

<script src="/assets/js/toggleSoportes.js"></script>

<script src="/assets/js/actualizar_soportes.js"></script>

<!-- <script src="assets/js/getmedios.js"></script> -->

<?php 
include '../componentes/settings.php';
include 'modalUpdateSoportes.php';
// require_once 'views/modalUpdateSoportes.php';
include '../componentes/footer.php'; ?>