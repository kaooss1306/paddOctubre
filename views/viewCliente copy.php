<?php
// Iniciar la sesión
session_start();

// Incluir funciones necesarias
include '../querys/qclientes.php';

// Obtener el ID del cliente de la URL
$idCliente = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : null;

if (!$idCliente) {
    die("No se proporcionó un ID de cliente válido.");
}

// Obtener datos del cliente específico
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?id_cliente=eq.$idCliente&select=*";
$cliente = makeRequest($url);

// Verificar si se obtuvo el cliente
if (empty($cliente) || !isset($cliente[0])) {
    die("No se encontró el cliente con el ID proporcionado.");
}

$datosCliente = $cliente[0];

// Obtener productos asociados al cliente
$productos = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?Id_Cliente=eq.$idCliente&select=*");

// Crear un mapa de productos para fácil acceso si es necesario
$productosMap = array_column($productos, null, 'id');

// Obtener comisión del cliente
$comisionCliente = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_cliente=eq.$idCliente&select=*");

// Verificar si se obtuvo la comisión del cliente
// Verificar si se obtuvo la comisión del cliente
if (!empty($comisionCliente) && is_array($comisionCliente) && isset($comisionCliente[0])) {
    $primerComision = $comisionCliente[0];
    
    $valorComision = $primerComision['valorComision'] ?? "No disponible";
    $fechaInicio = $primerComision['inicioComision'] ?? "No disponible";
    $fechaTermino = $primerComision['finComision'] ?? "No disponible";
} else {
    $valorComision = "No disponible";
    $fechaInicio = "No disponible";
    $fechaTermino = "No disponible";
}

// Obtener tipos de moneda
$monedas = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoMoneda?select=*");

// Crear un mapa de monedas para fácil acceso
$monedasMap = array_column($monedas, 'nombreMoneda', 'id_moneda');

// Obtener tipos de formato

$formatos = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/formatoComision?select=*");
// Crear un mapa de formatos para fácil acceso
$formatosMap = array_column($formatos, 'nombreFormato', 'id_formatoComision');

include '../componentes/header.php';
include '../componentes/sidebar.php';
?>
      <!-- Main Content -->
      <div class="main-content">
      
      <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListClientes.php">Ver Clientes</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $datosCliente['nombreCliente'] ; ?></li>
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
                        <?php echo $datosCliente['nombreCliente'] ; ?>
                      </div>
                      <div class="author-box-job">
                      <?php
    // Convertir la cadena de fecha y hora a un objeto DateTime
    $fecha = new DateTime($datosCliente['created_at']);
    
    // Formatear la fecha como deseas (en este caso, solo la fecha)
    echo 'Registrado el: '.$fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
    ?>
                    
                    </div>
                    </div>
                    <div class="text-center">
                      <div class="author-box-job">
               
                        <?php echo 'Sitio Web: ' .$datosCliente['web_cliente'] ; ?>
                   
                      </div>
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Detalles del Cliente</h4>
                  </div>
                  <div class="card-body">
                    <div class="py-4">
                      <p class="clearfix">
                        <span class="float-start">
                        Nombre Cliente
                        </span>
                        <span class="float-right text-muted">
                          <?php echo $datosCliente['nombreCliente'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Nombre de Fantasía
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['nombreFantasia'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Razón Social
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['razonSocial'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Tipo de Cliente
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $tiposClienteMap[$datosCliente['id_tipoCliente']] ?? ''; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          RUT
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['RUT'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                        Representante Legal
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['nombreRepresentanteLegal'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          RUT Representante Legal
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['RUT_representante'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Región
                        </span>
                        <span class="float-right text-muted">
                         <?php echo $regionesMap[$datosCliente['id_region']] ?? ''; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Comuna
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $comunasMap[$datosCliente['id_comuna']] ?? ''; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Dirección Empresa
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['direccionEmpresa'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Teléfono Celular
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['telCelular'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Teléfono Fijo
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['telFijo'] ; ?>
                        </span>
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
                        <a class="nav-link active" id="home-tab2" data-bs-toggle="tab" href="#facturacion" role="tab"
                          aria-selected="true">Datos Facturación</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-bs-toggle="tab" href="#contacto" role="tab"
                          aria-selected="false">Datos de Contacto</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-bs-toggle="tab" href="#otros" role="tab"
                          aria-selected="false">Otros Datos</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-bs-toggle="tab" href="#productos" role="tab"
                          aria-selected="false">Productos</a>
                      </li>

                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="facturacion" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-2 col-6 b-r">
                            <strong>Razon Social</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['razonSocial'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>RUT Empresa</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['RUT'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>Región</strong>
                            <br>
                            <p class="text-muted"><?php echo $regionesMap[$datosCliente['id_region']] ?? ''; ?></p>
                          </div>
                          <div class="col-md-2 col-6">
                            <strong>Comuna</strong>
                            <br>
                            <p class="text-muted"><?php echo $comunasMap[$datosCliente['id_comuna']] ?? ''; ?></p>
                          </div>
                          <div class="col-md-2 col-6">
                            <strong>Dirección</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['direccionEmpresa'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6">
                            <strong>Facturación</strong>
                            <br>
                            <p class="text-muted"><?php echo $tiposClienteMap[$datosCliente['id_tipoCliente']] ?? ''; ?></p>
                          </div>
                        </div>
                      
                      </div>


                      
                      <div class="tab-pane fade" id="contacto" role="tabpanel" aria-labelledby="profile-tab2">
                      <div class="row">
                      <div class="col-md-2 col-6 b-r">
                            <strong>Nombre</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['nombreRepresentanteLegal'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>Apellido</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['apellidoRepresentante'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>Teléfono Celular</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['telCelular'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>Teléfono Fijo</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['telFijo'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>Email</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['email'] ; ?></p>
                          </div>
                          <div class="col-md-2 col-6 b-r">
                            <strong>Sitio Web</strong>
                            <br>
                            <p class="text-muted"><?php echo $datosCliente['web_cliente'] ; ?></p>
                          </div>
                      </div>
                      </div>

                      <div class="tab-pane fade" id="otros" role="tabpanel" aria-labelledby="profile-tab3">
                       <div class="card-header milinea">
                            <div class="titulox"><h4>Listado de Comisiones</h4></div>
                            <div class="agregar"><a class="btn btn-primary" href="addCliente.php"><i class="fas fa-plus-circle"></i> Agregar Comisión</a></div>
                        </div>
                       <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Comision</th>
                <th>Valor</th>
                <th>Formato</th>
                <th>Fecha Inicio</th>
                <th>Fecha de Término</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($comisionCliente) && isset($comisionCliente[0])): ?>
                <?php foreach ($comisionCliente as $comision): ?>

                <tr>
                <td><?php echo htmlspecialchars($monedasMap[$comision['id_tipoMoneda']] ?? 'No disponible'); ?>
                </td>
                    <td><?php echo htmlspecialchars($valorComision); ?></td>
                    
                    <td><?php echo htmlspecialchars($formatosMap[$comision['id_formatoComision']] ?? 'No disponible'); ?></td>
                    <td><?php echo htmlspecialchars($fechaInicio); ?></td>
                    <td><?php echo htmlspecialchars($fechaTermino); ?></td>
                    <td>
                                                <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizarcliente" data-idcliente="" data-toggle="tooltip" title="Editar" ><i class="fas fa-pencil-alt"></i></button>
                                                <a href="#" data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt btn btn-danger micono"></i></a>
                                            
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay datos disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>



                  
                      </div>

                      <div class="tab-pane fade" id="productos" role="tabpanel" aria-labelledby="profile-tab4">
                      
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Nombre Producto</th>
                <th>N° Campañas</th>
                <th>N° Contratos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>

                <tr>
                    <td><?php echo htmlspecialchars($producto['NombreDelProducto']); ?></td>
                    <td>
    <?php
    // Obtener el ID del producto actual
    $nombreDelProducto = urlencode($producto['id']); // O usa el ID directamente si es un número

    // Construir la URL de solicitud
    $url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?id_Producto=eq.$nombreDelProducto&select=*";

    // Realizar la solicitud y obtener la respuesta
    $campaign = makeRequest($url);

    // Contar ocurrencias de 'id_Producto'
    $campaniaCounts = [];

    foreach ($campaign as $entry) {
        $idProducto = $entry['id_Producto'];
        if (isset($campaniaCounts[$idProducto])) {
            $campaniaCounts[$idProducto]++;
        } else {
            $campaniaCounts[$idProducto] = 1;
        }
    }

    // Obtener el contador para el producto actual
    $conteo = isset($campaniaCounts[$nombreDelProducto]) ? $campaniaCounts[$nombreDelProducto] : 0;

    // Mostrar el contador de campañas en un elemento <p>
    ?>
    <p><?php echo htmlspecialchars($conteo); ?></p>
</td>
                    <td><?php echo htmlspecialchars($datosCliente['telCelular']); ?></td>
                    <td>      <a href="" data-toggle="tooltip" title="Ver Cliente"><i class="fas fa-eye btn btn-primary micono"></i></a>
                                                <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizarcliente" data-idcliente="" onclick="loadClienteData(this)" ><i class="fas fa-pencil-alt"></i></button>
                                                <a href="#" data-toggle="tooltip" title="Eliminar Cliente"><i class="fas fa-trash-alt btn btn-danger micono"></i></a>
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
<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>