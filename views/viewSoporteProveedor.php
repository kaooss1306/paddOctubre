<?php
// Iniciar la sesión
session_start();
// Definir variables de configuración
//$ruta = 'localhost/paddv4/';
// Función para hacer peticiones cURL
include '../querys/qproveedor.php';
// Obtener el ID del cliente de la URL
$idProveedor = isset($_GET['id_proveedor']) ? $_GET['id_proveedor'] : null;

if (!$idProveedor) {
    die("No se proporcionó un ID de cliente válido.");
}
$contactosFiltrados = array_filter($contactos, function($contacto) use ($idProveedor) {
  return $contacto['id_proveedor'] == $idProveedor;
});
if ($idProveedor) {
  $soportesx2 = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?id_proveedor=eq.$idProveedor");
} else {
  $soportesx2 = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*");
}

// Obtener datos del cliente específico
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?id_proveedor=eq.$idProveedor&select=*";
$proveedor = makeRequest($url);

// Verificar si se obtuvo el medio
if (empty($proveedor) || !isset($proveedor[0])) {
    die("No se encontró el cliente con el ID proporcionado.");
}

$datosProveedor = $proveedor[0];

// Obtener clasificaciones asociadas al medio
$themedio = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/ClasificacionMedios?select=*");

// Crear un mapa de clasificaciones para fácil acceso
$clasificacionesMap = array_column($themedio, null, 'id_clasificacion_medios');

include '../componentes/header.php';
include '../componentes/sidebar.php';

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
</style>
      <!-- Main Content -->
      <div class="main-content">
      
      <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListProveedores.php">Ver Proveedor</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $datosProveedor['nombreProveedor'] ; ?></li>
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
                      <div class="nombrex author-box-name">
                        <?php echo $datosProveedor['nombreProveedor'] ; ?>
                      </div>
                      <div class="author-box-job">
                      <?php echo 'RUT: ' .$datosProveedor['rutProveedor'] ; ?>
                      
                    
                    </div>
                    </div>
                    <div class="text-center">
                      <div class="author-box-job">
               
                                                        <?php
                                    // Convertir la cadena de fecha y hora a un objeto DateTime
                                    $fecha = new DateTime($datosProveedor['created_at']);
                                    
                                    // Formatear la fecha como deseas (en este caso, solo la fecha)
                                    echo 'Registrado el: '.$fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
                                    ?>
                   
                      </div>
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div style="display: flex;
    justify-content: space-between;" class="card-header">
                  <?php
                                                            // Paso 1: Obtener todos los id_medios para un id_proveedor específico
                                                            $id_proveedor = $datosProveedor['id_proveedor'];

                                                            // Realiza la solicitud para obtener los datos de la tabla proveedor_medios

                                                            $id_medios_array = [];
                                                            foreach ($proveedor_medios as $fila) {
                                                                if ($fila['id_proveedor'] == $id_proveedor) {
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
                    <h4>Detalles del Proveedor</h4>
                    <a class="btn btn-danger micono"  data-bs-toggle="modal" data-bs-target="#actualizarProveedor" data-idmedios="<?php echo $id_medios_json; ?>" data-idproveedor="<?php echo $idProveedor ?>" onclick="loadProveedorData(this)" ><i class="fas fa-pencil-alt"></i> Editar datos</a>

                  </div>
                  <div class="card-body">
    <div class="py-4">
        <p class="clearfix">
            <span class="float-start">Nombre Proveedor</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['nombreProveedor']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Nombre de Fantasía</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['nombreFantasia']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Razón Social</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['razonSocial']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Giro Proveedor</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['giroProveedor']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Dirección</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['direccionFacturacion']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Representante</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['nombreRepresentante']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Rut Representante</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['rutRepresentante']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Teléfono Celular</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['telCelular']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Teléfono Fijo</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['telFijo']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Correo</span>
            <span class="float-right text-muted "><?php echo $datosProveedor['email']; ?></span>
        </p>
        <p class="clearfix">
            <span class="float-start">Medios</span>
            <span class="float-right text-muted "><?php echo $tooltip_content?></span>
        </p>
    </div>
</div>
                </div>
               
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    
                      

                      <li class="nav-item">
                        <a class="nav-link active" id="profile-tab4" data-bs-toggle="tab" href="#soportes" role="tab"
                          aria-selected="false">Soportes</a>
                      </li>

             
                    

                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade " id="generales" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-4 col-6 b-r">
                            <strong>Razón Social</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['razonSocial'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Nombre de Fantasía</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['nombreFantasia'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Nombre Identificador</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['nombreIdentificador'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6">
                            <strong>Giro Proveedor</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['giroProveedor']; ?></p>
                          </div>
                          <div class="col-md-4 col-6">
                            <strong>Representante Legal</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['nombreRepresentante'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6">
                            <strong>RUT Representante</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['rutRepresentante'] ; ?></p>
                          </div>
                           <div class="col-md-4 col-6">
                            <strong>N° de Soportes</strong>
                            <br>
                            <p class="text-muted">
                             <?php
                                                 
                            $contador = 0;
                            foreach ($soportes as $soporte) {
                                if ($datosProveedor['id_proveedor'] == $soporte['id_proveedor']) {
                                    $contador++;
                                }
                            }
                            echo $contador;
                          ?>
                            </p>
                          </div>

                           <div class="col-md-4 col-6">
                            <strong>N° de Medios</strong>
                            <br>
                            <p class="text-muted">Acá data</p>
                          </div>

                          <div class="col-md-4 col-6">
                            <strong>Clientes</strong>
                            <br>
                            <p class="text-muted">Acá data</p>
                          </div>

                        </div>
                      
                      </div>


                      
                      <div class="tab-pane fade" id="facturacion" role="tabpanel" aria-labelledby="profile-tab2">
                      <div class="row">
                      <div class="col-md-4 col-6 b-r">
                            <strong>Región</strong>
                            <br>
                            <p class="text-muted"><?php echo $regionesMap[$datosProveedor['id_region']] ?? ''; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Comuna</strong>
                            <br>
                            <p class="text-muted"><?php echo $comunasMap[$datosProveedor['id_comuna']] ?? ''; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Dirección</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['direccionFacturacion'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Teléfono Fijo</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['telFijo'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Teléfono Celular</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['telCelular'] ; ?></p>
                          </div>
                          <div class="col-md-4 col-6 b-r">
                            <strong>Email</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosProveedor['email'] ; ?></p>
                          </div>
                      </div>
                      </div>

                      <div class="tab-pane fade  " id="contactos" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="card-header milinea">
                                        <div class="titulox am">Listado de Contactos</div>
                                        <div class="agregar">
                                            <a href="#" class="btn btn-primary open-modal"  data-bs-toggle="modal"
                                                data-bs-target="#contactoProveedor">
                                                <i class="fas fa-plus-circle"></i> Agregar Contacto
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                    <table class="table table-striped" id="tablecontactos">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($contactosFiltrados) && isset($contactosFiltrados[0])): ?>
        <?php foreach ($contactosFiltrados as $contacto): ?>
        <tr>
            <td><?php echo htmlspecialchars($contacto['id_contacto'] ?? 'No disponible'); ?></td>
            <td><?php echo htmlspecialchars($contacto['nombres'] ?? 'No disponible'); ?></td>
            <td><?php echo htmlspecialchars($contacto['apellidos'] ?? 'No disponible'); ?></td>
            <td><?php echo htmlspecialchars($contacto['telefono'] ?? 'No disponible'); ?></td>
            <td><?php echo htmlspecialchars($contacto['email'] ?? 'No disponible'); ?></td>
            <td>
              <input type="hidden" data-idproveedor="<?php echo $idProveedor ?>" value="<?php echo $idProveedor ?>">
                <input type="hidden" class="id_contacto" value="<?php echo htmlspecialchars($contacto['id_contacto'] ?? 'No disponible'); ?>">
                <button type="button" class="btn btn-success miconoz" 
        data-bs-toggle="modal" 
        data-bs-target="#actualizarContactoModal"
        data-idcontacto="<?php echo htmlspecialchars($contacto['id_contacto']); ?>" 
        data-nombre="<?php echo htmlspecialchars($contacto['nombres']); ?>"
        data-apellido="<?php echo htmlspecialchars($contacto['apellidos']); ?>"
        data-telefono="<?php echo htmlspecialchars($contacto['telefono']); ?>"
        data-email="<?php echo htmlspecialchars($contacto['email']); ?>"
        data-toggle="tooltip" 
        title="Editar">
    <i class="fas fa-pencil-alt"></i>
</button>
                <button type="button" class="btn btn-danger miconoz eliminar-contacto"
                        data-id-proveer="<?php echo $idProveedor; ?>" data-idcontacto="<?php echo htmlspecialchars($contacto['id_contacto'] ?? ''); ?>"
                        data-toggle="tooltip" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="6">No hay datos disponibles</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table></div>
                      </div>

  <div class="tab-pane fade show active" id="soportes" role="tabpanel" aria-labelledby="profile-tab4">
  <div class="conshan milinea">
            <div class="titulox"><h4>Listado de Soportes</h4></div>
            <div class="agregar">
                <button style="border-radius:25px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarSoportessss"
                    data-rso="<?php echo $datosProveedor['razonSocial'] ; ?>" data-nfo="<?php echo $datosProveedor['nombreFantasia'] ; ?>" data-rpo="<?php echo $datosProveedor['rutProveedor'] ; ?>" data-gpo="<?php echo $datosProveedor['giroProveedor'] ; ?>"
                    data-nro="<?php echo $datosProveedor['nombreRepresentante'] ; ?>" data-rpoo="<?php echo $datosProveedor['rutRepresentante'] ; ?>" data-dfo="<?php echo $datosProveedor['direccionFacturacion'] ; ?>"
                    data-iro="<?php echo $datosProveedor['id_region'] ; ?>" data-ico="<?php echo $datosProveedor['id_comuna'] ; ?>" data-tco="<?php echo $datosProveedor['telCelular'] ; ?>" data-tfo="<?php echo $datosProveedor['telFijo'] ; ?>" 
                    data-elo="<?php echo $datosProveedor['email'] ; ?>" data-id="<?php echo $datosProveedor['id_proveedor'] ; ?>">
                    <i class="fas fa-plus-circle"></i> Crear Soporte 
                </button>
                <button style="border-radius:25px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarsoporteprov"
                    data-id-proveedor="<?php echo $datosProveedor['id_proveedor'] ; ?>" >
                    <i class="fas fa-plus-circle"></i> Agregar Soporte
                </button>
            </div>
        </div>

       <div class="table-responsive">
                                <table class="table table-striped" id="tablesoportes">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Soporte</th>
            <th>Descripción</th>
            <th>Medios Asociados</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="soportes-tbody">
        <!-- Las filas se llenarán aquí mediante JavaScript -->
    </tbody>
</table></div>
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
                    <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
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
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
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


  <div class="modal fade" id="contactoProveedor" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >AGREGAR CONTACTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>


                <form id="contactoagregar">
                    <input type="hidden" name="id_proveedor" value="<?php echo $idProveedor; ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nombre" name="nombre">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="apellido" name="apellido">

                        </div>
                    </div>
                    <div class="form-group">
                       
                    <label for="telefonoxx" class="labelforms">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" id="telefonoxx" name="telefono" required>
                                    <div class="custom-tooltip" id="telefonoxx-tooltip"></div>
                                </div> 
                    </div>
                    <div class="form-group">

                    <label for="emailxxx" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    <input type="text" class="form-control email-input" id="emailxxx" name="email" required>
                                    <div class="custom-tooltip" id="emailxxx-tooltip"></div>
                                </div>  


                      
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Contacto</button>
                </form>
            </div>
        </div>
    </div>
</div>
      <div class="modal fade" id="actualizarContactoModal" tabindex="-1" role="dialog" aria-labelledby="actualizarContactoModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarContactoModal">ACTUALIZAR CONTACTO</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarcontactop">
                    <input type="hidden" name="id_proveedor" value="<?php echo $idProveedor; ?>">
                    <input type="hidden" id="id_contacto" name="id_contacto">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="apellido" name="apellido">
                        </div>
                    </div>
                    <div class="form-group">


                    <label for="telefono" class="labelforms">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" id="telefono" name="telefono" required>
                                    <div class="custom-tooltip" id="telefono-tooltip"></div>
                                </div>  


                    </div>
                    <div class="form-group">
                        
                    <label for="emailxx" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    <input type="text" class="form-control email-input" id="emailxx" name="email" required>
                                    <div class="custom-tooltip" id="emailxx-tooltip"></div>
                                </div>  
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Contacto</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="actualizarProveedor" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            
              <div class="modal-body">
                 <!-- Alerta para mostrar el resultado de la actualización -->
                 <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>
                            
                 
                 <form id="formactualizarproveedor">
                 <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Actualizar Proveedor</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="labelforms" for="codigo">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                                        </div>
                                        <input type="hidden" name="idprooo">
                                        <input type="hidden"  name="idmedios">
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentificadorp">
                                    </div>
                                    <label class="labelforms" for="codigo">Medios</label>
                                    <div id="dropdown1" class="dropdown-medios input-group dropdown" >
                                        <div class="sell input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <div class="selected-options" onclick="toggleDropdown()"></div>
                                        <button type="button" class="dropdown-button" style="font-size:14px; padding: 7px 20px !important; display:none;">Select Medios</button>
                                        <div class="dropdown-content">
                                            <?php foreach ($medios as $medio) : ?>
                                                <label>
                                                    <input type="checkbox" name="id_medios[]" value="<?php echo $medio['id']; ?>">
                                                    <?php echo $medio['NombredelMedio']; ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Proveedor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Proveedor" name="nombreProveedorp">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre Representante</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre Representante" name="nombreRepresentantep">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">


                        
                                <label for="rutProveedorp" class="labelforms">Rut Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="rutProveedorp" name="rutProveedorp" required>
                                    <div class="custom-tooltip" id="rutProveedorp-tooltip"></div>
                                </div>    

                              



                                    <label class="labelforms" for="codigo">Giro Proveedor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-suitcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro Proveedor" name="giroProveedorp">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-spock"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasiap">
                                    </div>
                                 
                                    <label for="rutRepresentantep" class="labelforms">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="rutRepresentantep" name="rutRepresentantep" required>
                                    <div class="custom-tooltip" id="rutRepresentantep-tooltip"></div>
                                </div>       
                                    
                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Razón Social</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Razón Social" name="razonSocialp">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel region-select form-select" name="id_regionp" id="region" required>
                                            <?php foreach ($regiones as $regione) : ?>
                                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <label for="telCelularp" class="labelforms">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono Celular" id="telCelularp" name="telCelularp" required>
                                    <div class="custom-tooltip" id="telCelularp-tooltip"></div>
                                </div>     

                                <label for="emailp" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    <input type="text" class="form-control email-input" id="emailp" name="emailp" required>
                                    <div class="custom-tooltip" id="emailp-tooltip"></div>
                                </div>  
                                
                           
                                   
                                  
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Dirección Facturación</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccionFacturacionp">
                                    </div>
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel comuna-select form-select" name="id_comunap" id="comuna" required>
                                            <?php foreach ($comunas as $comuna) : ?>
                                                <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                                    <?php echo $comuna['nombreComuna']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <label for="telFijop" class="labelforms">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono fijo" id="telFijop" name="telFijop" required>
                                    <div class="custom-tooltip" id="telFijop-tooltip"></div>
                                </div>




                                  
                                </div>
                            </div>
                        </div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="codigo">Bonifiación por año %</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Bonifiación por año %" name="bonificacion_anop">
                                    </div>
                                </div>
                            </div>
                            <div class="col" id="moneda-container">
                                <div class="form-group">
                                    <label for="codigo">Escala de rango</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-chart-bar"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Escala de rango" name="escala_rangop">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary btn-lg rounded-pill" type="submit" id="actualizarProveedor">
                            <span class="btn-txt">Guardar Proveedor</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

<div class="modal fade" id="actualizarsoporte22" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioactualizarSoporteProv">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Actualizar Soporte</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="labelforms" for="codigo">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                                        </div>
                                        <input type="hidden" name="rutProveedorx">
                                        <input type="hidden"  name="idmedios">
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentificadorx">
                                    </div>
                                   
                                    
                                    <label class="labelforms" for="codigo">Nombre Representante</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre Representante" name="nombreRepresentantex">
                                    </div>
                                    <label class="labelforms" for="codigo">Medios</label>
                                    <div id="dropdown2" class="dropdown-medios input-group dropdown" >
                                        <div class="sell input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <div class="selected-options" onclick="toggleDropdown()"></div>
                                        <button type="button" class="dropdown-button" style="font-size:14px; padding: 7px 20px !important; display:none;">Select Medios</button>
                                        <div class="dropdown-content">
                                            <?php foreach ($medios as $medio) : ?>
                                                <label>
                                                    <input type="checkbox" name="id_medios[]" value="<?php echo $medio['id']; ?>">
                                                    <?php echo $medio['NombredelMedio']; ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">

                                <label for="rutSoporte" class="labelforms">Rut Soporte</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                    <input type="text" class="form-control" placeholder="Rut Soporte" id="rutSoporte" name="rutSoporte" required>
                                    <div class="custom-tooltip" id="rutSoporte-tooltip"></div>
                                </div>

                                    <label class="labelforms" for="codigo">Giro Soporte</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-suitcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro Proveedor" name="giroProveedorx">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-spock"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasiax">
                                    </div>

                                    <label for="rutRepresentantex" class="labelforms">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                    <input type="text" class="form-control" placeholder="Rut Representante" id="rutRepresentantex" name="rutRepresentantex" required>
                                    <div class="custom-tooltip" id="rutRepresentantex-tooltip"></div>
                                </div>           

                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Razón Social</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Razón Social" name="razonSocialx">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_regionx" id="regionx" required>
                                            <?php foreach ($regiones as $regione) : ?>
                                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telCelularx" class="labelforms">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Rut Soporte" id="telCelularx" name="telCelularx" required>
                                    <div class="custom-tooltip" id="telCelularx-tooltip"></div>
                                </div>   
                                
                                <label for="emailx" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    <input type="text" class="form-control email-input" placeholder="Email" id="emailx" name="emailx" required>
                                    <div class="custom-tooltip" id="emailx-tooltip"></div>
                                </div>    

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Dirección Facturación</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccionx">
                                    </div>
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_comunax" id="comunax" required>
                                            <?php foreach ($comunas as $comuna) : ?>
                                                <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                                    <?php echo $comuna['nombreComuna']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telFijox" class="labelforms">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono fijo" id="telFijox" name="telFijox" required>
                                    <div class="custom-tooltip" id="telFijox-tooltip"></div>
                                </div>               

                                </div>
                            </div>
                        </div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="codigo">Bonifiación por año %</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Bonifiación por año %" name="bonificacion_anox">
                                    </div>
                                </div>
                            </div>
                            <div class="col" id="moneda-container">
                                <div class="form-group">
                                    <label for="codigo">Escala de rango</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-chart-bar"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Escala de rango" name="escala_rangox">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn bn-padd micono" type="submit" id="actualizarProveedor">
                            <span class="btn-txt">Guardar Soporte</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="agregarsoporteprov" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>
                
                <!-- Campo para mostrar el id_proveedor -->
                <input type="hidden"  class="form-control" placeholder="Prueba de id " name="pruebaid" id="pruebaid">
                
                <form id="formagregarsoporte3">
                    <div class="form-group">
                        <label for="soporteSelect">Selecciona un Soporte</label>
                        <select class="form-control" id="soporteSelect" name="id_soporte">
                            <!-- Opciones se llenarán dinámicamente -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Soporte</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarSoportessss" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
     
            <div class="modal-body">
                <form id="formualarioSoporteProv">
                    <!-- Campo oculto para el ID -->
                    <input type="hidden"  name="id_proveedor" value="<?php echo $datosProveedor['id_proveedor'] ; ?>" id="id_proveedor">
           
          
                    <!-- Campos del formulario -->
                    <h3 class="titulo-registro mb-3">Agregar Soporte</h3>
                    <div class="row">
                        <div class="col-6">
                        <div class="form-group">
                                    <label for="codigo">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentficiador" required>
                                    </div>
                        </div>
                              
                               
                        </div>
                        <div class="col-6">
                        <div class="form-group">
                          <label  for="codigo">Medios</label>
                                        <div id="dropdown4" class="input-group dropdown" >
                                            <div class="sell input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <div class="selected-options" onclick="toggleDropdown()"></div>
                                            <button type="button" class="dropdown-button" style="font-size:14px; padding: 7px 20px !important; display:none;">Select Medios</button>
                                            <div class="dropdown-content">
                                                <?php foreach ($medios as $medio) : ?>
                                                    <label>
                                                        <input type="checkbox" name="id_medios[]" value="<?php echo $medio['id']; ?>">
                                                        <?php echo $medio['NombredelMedio']; ?>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
</div>
                    </div>
                    <div class="row"><label class="opeo"><input type="checkbox" name="revision"> <span>Usar los mismos datos del proveedor</span></label></div>
                   <div class="checklust">
                   <div class="row ">
                        <div class="col-6">
                        <div class="form-group">
                        <label  for="codigo">Razón Social</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Razón Social" name="razonSocial">
                                    </div>
                                   
                                  
                        <label for="rut_soporte" class="labelforms">Rut</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingresa el Rut" id="rut_soporte" name="rut_soporte" required>
                                    <div class="custom-tooltip" id="rut_soporte-tooltip"></div>
                                </div>
                        <label class="labelforms" for="codigo">Nombre Representante Legal</label>
                                    <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                          
                                        <input class="form-control" placeholder="Nombre Representante Legal" name="nombreRepresentanteLegal" required>
                                    </div> 
                          
 
                              
                        </div>
                        </div>
                        <div class="col-6">
                        <div class="form-group">
                        <label  for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-spock"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia" required>
                                    </div>
                        <label class="labelforms"  for="codigo">Giro</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-suitcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro" name="giro" required>
                                    </div>
                        <label for="rut_soporte" class="labelforms">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="rutRepresentante" name="rutRepresentante" required>
                                    <div class="custom-tooltip" id="rutRepresentante-tooltip"></div>
                                </div>




                                    
                                </div></div>
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                        <div class="col-6">

                        <div class="form-group">
                        <label class="labelforms"  for="codigo">Dirección Facturación</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccion">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel form-select region-select" name="id_region"  required>
                                    <?php foreach ($regiones as $regione) : ?>
                                        <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                    </div>

                                    <label for="telCelular" class="labelforms">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" id="telCelular" name="telCelular" required>
                                    <div class="custom-tooltip" id="telCelular-tooltip"></div>
                                </div>    

                                    </div></div>
                        <div class="col-6">

                        <div class="form-group">

                        <label for="email" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    <input type="text" class="form-control email-input" id="email" name="email" required>
                                    <div class="custom-tooltip" id="email-tooltip"></div>
                                </div>                  
 
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel form-select comuna-select" name="id_comuna"  required>
                                <?php foreach ($comunas as $comuna) : ?>
                                    <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                        <?php echo $comuna['nombreComuna']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                                    </div> 


                                    <label for="telFijo" class="labelforms">Teléfono fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="phone-input form-control" id="telFijo" name="telFijo" required>
                                    <div class="custom-tooltip" id="telFijo-tooltip"></div>
                                </div>  

                        </div></div>
                    </div>
                   </div>
                    
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>


                                  

                        <input name="razonsoculto" type="hidden">
                        <input name="nombref" type="hidden" >
                        <input name="rutt" type="hidden" >
                        <input name="giroo" type="hidden" >
                        <input name="nombreRepesentanteO" type="hidden" >
                        <input name="rutRepresent" type="hidden" >
                        <input name="direcciono" type="hidden" >
                        <input name="regiono" type="hidden" >
                        <input name="comunao" type="hidden" >
                        <input name="telCelularo" type="hidden" >
                        <input name="telFijoo" type="hidden" >
                        <input name="emailO" type="hidden" >
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                        <label  for="codigo">Bonificación por año %</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Bonificación por año %" name="bonificacion_ano" required>
                                    </div>  </div>
                        
                            </div>
                            <div class="col" id="moneda-container">
                            <div class="form-group">
                        <label  for="codigo">Escala de rango</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Escala de rango" name="escala_rango" required>
                                    </div>  </div>
                               
                            </div>
                        </div>
                    </div> 
                    <button type="submit" class="loiloi" id="provprov">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function getProveedorData(idProveedor) {
    var proveedoresMap = <?php echo json_encode($proveedoresMap); ?>;
    return proveedoresMap[idProveedor] || null;
}
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

<script>
function getSoporteData(idSoporte) {
    var soportesMap = <?php echo json_encode($soportesMap); ?>;
    return soportesMap[idSoporte] || null;
}
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('agregarSoportessss');

    modal.addEventListener('show.bs.modal', (event) => {
        // Obtener el botón que abrió el modal
        const button = event.relatedTarget;

        // Asignar el ID del proveedor al input oculto en el modal
    
        // Asignar los valores de los atributos data-* a los inputs ocultos en el modal
        modal.querySelector('input[name="id_proveedor"]').value = button.getAttribute('data-id');
        modal.querySelector('input[name="razonsoculto"]').value = button.getAttribute('data-rso');
        modal.querySelector('input[name="nombref"]').value = button.getAttribute('data-nfo');
        modal.querySelector('input[name="rutt"]').value = button.getAttribute('data-rpo');
        modal.querySelector('input[name="giroo"]').value = button.getAttribute('data-gpo');
        modal.querySelector('input[name="nombreRepesentanteO"]').value = button.getAttribute('data-nro');
        modal.querySelector('input[name="rutRepresent"]').value = button.getAttribute('data-rpoo');
        modal.querySelector('input[name="direcciono"]').value = button.getAttribute('data-dfo');
        modal.querySelector('input[name="regiono"]').value = button.getAttribute('data-iro');
        modal.querySelector('input[name="comunao"]').value = button.getAttribute('data-ico');
        modal.querySelector('input[name="telCelularo"]').value = button.getAttribute('data-tco');
        modal.querySelector('input[name="telFijoo"]').value = button.getAttribute('data-tfo');
        modal.querySelector('input[name="emailO"]').value = button.getAttribute('data-elo');
    });
    const checkbox = modal.querySelector('input[name="revision"]');
    const checklustElements = modal.querySelectorAll('.checklust');
    const form = document.getElementById('formualarioSoporteProv');

    const toggleChecklustVisibility = () => {
        checklustElements.forEach(element => {
            element.style.display = checkbox.checked ? 'none' : 'grid';
        });
    };

    // Escuchar el evento 'change' en el checkbox
    checkbox.addEventListener('change', toggleChecklustVisibility);
   checkbox.addEventListener('change', function() {
        if (this.checked) {
            checklustElements.forEach(el => el.style.display = 'none');
            form.querySelectorAll('.form-control').forEach(input => input.removeAttribute('required'));
        } else {
            checklustElements.forEach(el => el.style.display = '');
            form.querySelectorAll('.form-control').forEach(input => input.setAttribute('required', 'required'));
        }
    });

    form.addEventListener('submit', submitFormSoporte);
    // Inicializar la visibilidad al cargar el modal
    modal.addEventListener('show.bs.modal', () => {
        toggleChecklustVisibility();
    });
});
</script>

<script>
   
document.addEventListener('DOMContentLoaded', function() {



    const form = document.getElementById('contactoagregar');
    const submitButton = form.querySelector('button[type="submit"]');
    let isSubmitting = false;

    const SUPABASE_API_KEY =
        'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';


    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        if (isSubmitting) {
            console.log('Envío ya en progreso, ignorando este envío.');
            return;
        }

        isSubmitting = true;
        submitButton.disabled = true;

        const formData = new FormData(this);
const idProveedor = formData.get('id_proveedor'); // Utiliza `get` para obtener el valor
console.log('ID Proveedor:', idProveedor);
        const data = {
            id_proveedor: parseInt(formData.get('id_proveedor')),
            nombres: formData.get('nombre'),
            apellidos: formData.get('apellido'),
            telefono: formData.get('telefono'),
            email: formData.get('email')
        };

        try {
            document.body.classList.add('loaded');

            const response = await fetch(
                'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/contactos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'apikey': SUPABASE_API_KEY,
                        'Authorization': `Bearer ${SUPABASE_API_KEY}`,
                        'Prefer': 'return=minimal'
                    },
                    body: JSON.stringify(data)
                });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
            }
    

            $('#contactoProveedor').modal('hide');
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Contacto guardado exitosamente',
                showConfirmButton: false,
                timer: 1500
            });
            refreshContactTable(<?php echo json_encode($idProveedor); ?>);
            
        } catch (error) {
            console.error('Error en la solicitud:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar el contacto: ' + error.message
            });
        } finally {
            document.body.classList.remove('loaded');
            isSubmitting = false;
            submitButton.disabled = false;
        }
    });
});
function refreshContactTable(idProveedor = null) {
    const urlContactos = `https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/contactos?select=*${idProveedor ? `&id_proveedor=eq.${idProveedor}` : ''}`;

    // Obtén los datos de los contactos
    $.ajax({
        url: urlContactos,
        method: 'GET',
        headers: {
            "Content-Type": "application/json",
            "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Authorization": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
        },
        success: function(contactos) {
            const tableBody = $('#tablecontactos tbody');
            tableBody.empty(); // Vacía el cuerpo de la tabla antes de actualizarlo

            if (contactos.length > 0) {
                contactos.forEach(function(contacto) {
                    const row = `
                        <tr>
                            <td>${contacto.id_contacto}</td>
                            <td>${contacto.nombres}</td>
                            <td>${contacto.apellidos}</td>
                            <td>${contacto.telefono}</td>
                            <td>${contacto.email}</td>
                            <td>
                                <button type="button" class="btn btn-success micono" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#actualizarContactoModal"
                                    data-idcontacto="${contacto.id_contacto}" 
                                    data-nombre="${contacto.nombres}"
                                    data-apellido="${contacto.apellidos}"
                                    data-telefono="${contacto.telefono}"
                                    data-email="${contacto.email}"
                                    data-toggle="tooltip" 
                                    title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-danger micono eliminar-contacto"
        data-idcontacto="${contacto.id_contacto}"
        data-id-proveer="${idProveedor}"
        data-toggle="tooltip" title="Eliminar">
    <i class="fas fa-trash-alt"></i>
</button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                });
            } else {
                tableBody.append('<tr><td colspan="6">No hay datos disponibles</td></tr>');
            }
        },
        error: function() {
            console.error('Error al obtener los contactos.');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    
    const proveedorId = <?php echo json_encode($idProveedor); ?>;
    if (proveedorId) {
        fetch(`/get_soportes.php?proveedor_id=${proveedorId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // Procesa los datos aquí
                populateTable(data); // Llama a la función para llenar la tabla
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
    
});



</script>
<script src="<?php echo $ruta; ?>assets/js/actualizarviewproveedor.js"></script>
<script src="../assets/js/contactoprops.js"></script>
<script src="../assets/js/getregiones.js"></script>
<script src="../assets/js/actualizarsoporteprov.js"></script>
<script src="../assets/js/getmedios.js"></script>
<script src="../assets/js/agregarsoporteprovedor.js"></script>

<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>