<?php
// Iniciar la sesión
session_start();
// Definir variables de configuración
//$ruta = 'localhost/paddv4/';
// Función para hacer peticiones cURL
include '../querys/qclientes.php';
include 'componentes/header.php';
// Obtener el ID del cliente de la URL
$idCliente = isset($_GET['id_soporte']) ? $_GET['id_soporte'] : null;

if (!$idCliente) {
    die("No se proporcionó un ID de cliente válido.");
}





// Obtener datos del cliente específico
// Obtener datos del cliente específico
$soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
$proveedor_medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_medios?select=*');
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?id_soporte=eq.$idCliente&select=*";
$cliente = makeRequest($url);
$soporte_medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/soporte_medios?select=*');
$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');
$proveedorS = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?id_proveedor=eq.$idCliente&select=*");
// Verificar si se obtuvo el cliente
if (empty($cliente) || !isset($cliente[0])) {
    die("No se encontró el cliente con el ID proporcionado.");
}

$datosCliente = $cliente[0];

// Obtener productos asociados al cliente

if ($idCliente) {
  // Hacer la petición a la API Supabase para obtener las filas que coincidan con el id_soporte
  $url = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_soporte?id_soporte=eq.' . $idCliente . '&select=*';

  // Configuración de cURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  // Agregar la clave API en el encabezado
  $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'; // Reemplaza con tu clave API de Supabase
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "apikey: $apiKey",
      "Authorization: Bearer $apiKey"
  ));

  // Ejecutar la petición
  $response = curl_exec($ch);

  // Verificar errores de cURL
  if (curl_errno($ch)) {
    echo 'Error de cURL: ' . curl_error($ch);
}


$soporte_medios_data = json_decode($response, true);

// Cerrar cURL
curl_close($ch);



// Contar el número de filas devueltas
$countProveedores = count($soporte_medios_data);


// Extraer los id_proveedor únicos
$id_provedoresxx = array_unique(array_column($soporte_medios_data, 'id_proveedor'));

if (!empty($id_provedoresxx)) {
  // Convertir los ID a una cadena separada por comas para usarlos en la consulta
  $id_provedoresxx_str = implode(',', $id_provedoresxx);

  // No necesitas codificar la cadena aquí si ya está en formato adecuado para la consulta
  $proveedores_url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?id_proveedor=in.(1)";
  $proveedores4 = makeRequest($proveedores_url);
  $proveedores_data = $proveedores4; 
  // Depuración: var_dump en backend para $proveedores_data
  
} else {
  $proveedores_data = [];
}

  // Aquí puedes seguir con la lógica para mostrar los proveedores en la tabla
  // utilizando la variable $proveedores_data
} else {
  echo "El id_soporte no fue proporcionado.";
}



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
      <!-- Main Content -->
      <div class="main-content">
      
      <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListClientes.php">Ver Soportes</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $datosCliente['nombreIdentficiador'] ; ?></li>
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
                        <?php echo $datosCliente['nombreIdentficiador'] ; ?>
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
              
                  </div>
                </div>
                <div class="card">
                <div style="display: flex;
    justify-content: space-between;" class="card-header">
     
                    <h4>Detalles del Soporte</h4>
                    <?php
                                                            // Paso 1: Obtener todos los id_medios para un id_proveedor específico
                                                            $id_sopor = $datosCliente['id_soporte'];

                                                            // Realiza la solicitud para obtener los datos de la tabla proveedor_medios

                                                            $id_medios_array = [];
                                                            foreach ($soporte_medios as $fila) {
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
                    <a class="btn btn-danger micono"  data-bs-toggle="modal" data-bs-target="#actualizarSoporte" data-idmedios="<?php echo $id_medios_json; ?>" data-id-soporte="<?php echo $idCliente ?>" data-idproveedor="${proveedor.id_proveedor}" onclick="loadProveedorDataSoporte(this)"><i class="fas fa-pencil-alt"></i> Editar datos</a>

                  </div>
                  <div class="card-body">
                    <div class="py-4">
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
                          Nombre de Fantasía
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['nombreFantasia'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Nombre Identificador
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['nombreIdentficiador'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Rut
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['rut_soporte'] ; ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-start">
                          Giro 
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['giro'] ; ?>
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
                          Dirección
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['direccion'] ; ?>
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
                          Email
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $datosCliente['email'] ; ?>
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
                      <p class="clearfix">
                        <span class="float-start">
                          Medios 
                        </span>
                        <span class="float-right text-muted">
                        <?php
                                                            // Paso 1: Obtener todos los id_medios para un id_proveedor específico
                                                            $id_soporte = $datosCliente['id_soporte'];

                                                            // Realiza la solicitud para obtener los datos de la tabla proveedor_medios

                                                            $id_medios_array = [];
                                                            foreach ($soporte_medios as $fila) {
                                                                if ($fila['id_soporte'] == $id_soporte) {
                                                                    $id_medios_array[] = $fila['id_medio'];
                                                                }
                                                            }                 

                                                            $medios_nombres = [];
                                                            foreach ($medios as $medio) {
                                                                if (in_array($medio['id'], $id_medios_array)) {
                                                                    $medios_nombres[] = $medio['NombredelMedio'];
                                                                }
                                                            }

                                                            if (!empty($medios_nombres)) {
                                                                $medios_list = implode(" , ", $medios_nombres);
                                                                $tooltip_content = "<span class='float-right text-muted'>" . $medios_list . "</span>";
                                                            } else {
                                                                $tooltip_content = ""; // Puedes dejarlo vacío o agregar un mensaje como "No hay medios disponibles"
                                                            }
                                                            
                                                            // Paso 3: Mostrar los nombres en una lista tipo tooltip
                                                            ?>     
                        <?php echo $tooltip_content; ?>
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
               
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div style="padding:10px;" class="card">
                <div class="card-header milinea dos">
                            <div class="titulox"><h4>Listado de Proveedores</h4></div>
                            
                        </div>
                <table class="table table-striped" id="tableExportadora">
                
    <thead>
        <tr>
      
            <th>ID</th>
            <th>Medio</th>
            <th>Nombre Proveedores</th>
            <th>Razón Social</th>
            <th>Rut</th>
            <th>N° de Soportes</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($proveedores_data as $proveedorll): ?>
        <tr class="proveedor-row" data-proveedor-id="<?php echo $proveedorll['id_proveedor']; ?>">
        
            <td><?php echo $proveedorll['id_proveedor']; ?></td>
            <td>
            <?php
                                                            // Paso 1: Obtener todos los id_medios para un id_proveedor específico
                                                            $id_proveedor = $proveedorll['id_proveedor'];

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



                                                            <svg width="24" data-bs-toggle="tooltip" data-bs-html="true"  height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="dist_marketing-btn-icon__AWP8I"><path fill-rule="evenodd" clip-rule="evenodd" d="M24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24C18.6274 24 24 18.6274 24 12ZM13.0033 22.3936C12.574 22.8778 12.2326 23 12 23C11.7674 23 11.426 22.8778 10.9967 22.3936C10.5683 21.9105 10.1369 21.1543 9.75435 20.1342C9.3566 19.0735 9.03245 17.7835 8.81337 16.3341C9.8819 16.1055 10.9934 15.9922 12.1138 16.0004C13.1578 16.0081 14.1912 16.1211 15.1866 16.3341C14.9675 17.7835 14.6434 19.0735 14.2457 20.1342C13.8631 21.1543 13.4317 21.9105 13.0033 22.3936ZM15.3174 15.3396C14.2782 15.1229 13.2039 15.0084 12.1211 15.0004C10.9572 14.9919 9.7999 15.1066 8.68263 15.3396C8.58137 14.4389 8.51961 13.4874 8.50396 12.5H15.496C15.4804 13.4875 15.4186 14.4389 15.3174 15.3396ZM16.1609 16.5779C15.736 19.3214 14.9407 21.5529 13.9411 22.8293C16.6214 22.3521 18.9658 20.9042 20.5978 18.862C19.6345 18.0597 18.4693 17.3939 17.1586 16.9062C16.8326 16.7849 16.4997 16.6754 16.1609 16.5779ZM21.1871 18.0517C20.1389 17.1891 18.8906 16.4837 17.5074 15.969C17.1122 15.822 16.708 15.6912 16.2967 15.5771C16.411 14.5992 16.4798 13.5676 16.4962 12.5H22.9888C22.8973 14.5456 22.2471 16.4458 21.1871 18.0517ZM7.70333 15.5771C7.58896 14.5992 7.52024 13.5676 7.50384 12.5H1.01116C1.10267 14.5456 1.75288 16.4458 2.81287 18.0517C3.91698 17.1431 5.24216 16.4096 6.71159 15.8895C7.0368 15.7744 7.3677 15.6702 7.70333 15.5771ZM3.40224 18.862C5.03424 20.9042 7.37862 22.3521 10.0589 22.8293C9.05934 21.5529 8.26398 19.3214 7.83906 16.5779C7.57069 16.6552 7.3059 16.74 7.04526 16.8322C5.65305 17.325 4.41634 18.0173 3.40224 18.862ZM15.496 11.5H8.50396C8.51961 10.5126 8.58136 9.56113 8.68263 8.66039C9.84251 8.90232 11.0448 9.01653 12.2521 8.99807C13.2906 8.9822 14.3202 8.86837 15.3174 8.66039C15.4186 9.56113 15.4804 10.5126 15.496 11.5ZM9.75435 3.86584C9.3566 4.9265 9.03245 6.21653 8.81337 7.66594C9.92191 7.90306 11.0758 8.01594 12.2369 7.99819C13.2391 7.98287 14.2304 7.87047 15.1866 7.66594C14.9675 6.21653 14.6434 4.9265 14.2457 3.86584C13.8631 2.84566 13.4317 2.08954 13.0033 1.60643C12.574 1.12215 12.2326 1 12 1C11.7674 1 11.426 1.12215 10.9967 1.60643C10.5683 2.08954 10.1369 2.84566 9.75435 3.86584ZM16.4962 11.5C16.4798 10.4324 16.411 9.40077 16.2967 8.42286C16.6839 8.31543 17.0648 8.19328 17.4378 8.05666C18.848 7.54016 20.1208 6.82586 21.1871 5.94826C22.2471 7.55418 22.8973 9.4544 22.9888 11.5H16.4962ZM17.0939 7.11766C18.4298 6.62836 19.6178 5.95419 20.5978 5.13796C18.9658 3.09584 16.6214 1.64793 13.9411 1.17072C14.9407 2.44711 15.736 4.67864 16.1609 7.42207C16.4773 7.33102 16.7886 7.22949 17.0939 7.11766ZM7.33412 7.26641C7.50092 7.32131 7.66929 7.37321 7.83905 7.42207C8.26398 4.67864 9.05934 2.44711 10.0589 1.17072C7.37862 1.64793 5.03423 3.09584 3.40224 5.13796C4.48835 6.04266 5.82734 6.77048 7.33412 7.26641ZM7.02148 8.21629C5.4308 7.69274 3.99599 6.92195 2.81287 5.94826C1.75288 7.55418 1.10267 9.4544 1.01116 11.5H7.50384C7.52024 10.4324 7.58896 9.40077 7.70333 8.42286C7.47376 8.35918 7.24638 8.29031 7.02148 8.21629Z" fill="currentColor"></path></svg>
                                                            <span style="margin-left:5px;"><?php echo $tooltip_content; ?></span>
                                                       
                                                        </td>  
            <td><?php echo $proveedorll['nombreProveedor']; ?></td>
            <td><?php echo $proveedorll['razonSocial']; ?></td>
            <td><?php echo $proveedorll['rutProveedor']; ?></td>
            <td>
                <?php
                    $contador = 0;
                    foreach ($soportes as $soporte) {
                        if ($proveedorll['id_proveedor'] == $soporte['id_proveedor']) {
                            $contador++;
                        }
                    }
                    echo $contador;
                ?>
            </td>
            <td>
                                            <div class="alineado">
       <label class="custom-switch sino" data-toggle="tooltip" 
       title="<?php echo $proveedorll['estado'] ? 'Desactivar Proveedor' : 'Activar Cliente'; ?>">
    <input type="checkbox" 
           class="custom-switch-input estado-switch2"
           data-id="<?php echo $proveedorll['id_proveedor']; ?>" data-tipo="proveedor" <?php echo $proveedorll['estado'] ? 'checked' : ''; ?>>
    <span class="custom-switch-indicator"></span>
</label>
    </div>
                                            </td>
            <td>
                <!-- Acciones -->
                <a class="btn btn-primary " href="viewProveedor.php?id_proveedor=<?php echo $proveedorll['id_proveedor']; ?>" data-toggle="tooltip" title="Ver Proveedor"><i class="fas fa-eye "></i></a>  
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-idmedios="<?php echo $id_medios_json; ?>" data-bs-target="#actualizarProveedor" data-idproveedor="<?php echo $proveedorll['id_proveedor']; ?>" onclick="loadProveedorData(this)"><i class="fas fa-pencil-alt"></i></button>

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
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input type="hidden" name="idprooo">
                                        <input type="hidden"  name="idmedios">
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentificadorp">
                                    </div>
                                    <label class="labelforms" for="codigo">Medios</label>
                                    <div id="dropdown4" class="dropdown-medios input-group dropdown" >
                                        <div class="sell input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
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
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="rutProveedorp" name="rutProveedorp" required>
                                    <div class="custom-tooltip" id="rutProveedorp-tooltip"></div>
                                </div>    

                              



                                    <label class="labelforms" for="codigo">Giro Proveedor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro Proveedor" name="giroProveedorp">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasiap">
                                    </div>
                                 
                                    <label for="rutRepresentantep" class="labelforms">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
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
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Razón Social" name="razonSocialp">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-map"></i></span>
                                        </div>
                                        <select class="sesel region-select form-select" name="id_regionp" id="region" required>
                                            <?php foreach ($regiones as $regione) : ?>
                                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <label for="telCelularp" class="labelforms">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono Celular" id="telCelularp" name="telCelularp" required>
                                    <div class="custom-tooltip" id="telCelularp-tooltip"></div>
                                </div>     

                                <label for="emailp" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
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
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccionFacturacionp">
                                    </div>
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
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
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
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
<script src="../assets/js/toggleProveedor.js"></script>


      <div class="modal fade" id="actualizarSoporte" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioactualizarSoporte">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Actualizar Soporte</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="labelforms" for="codigo">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input type="hidden" name="idSoporteHidden" id="idSoporteHidden">
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
                                    <div id="dropdown3" class="dropdown-medios input-group dropdown" >
                                        <div class="sell input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
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
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" placeholder="Rut Soporte" id="rutSoporte" name="rutSoporte" required>
                                    <div class="custom-tooltip" id="rutSoporte-tooltip"></div>
                                </div>

                                    <label class="labelforms" for="codigo">Giro Soporte</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro Proveedor" name="giroProveedorx">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasiax">
                                    </div>

                                    <label for="rutRepresentantex" class="labelforms">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
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
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Razón Social" name="razonSocialx">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-map"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_regionx" id="regionx" required>
                                            <?php foreach ($regiones as $regione) : ?>
                                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telCelularx" class="labelforms">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Rut Soporte" id="telCelularx" name="telCelularx" required>
                                    <div class="custom-tooltip" id="telCelularx-tooltip"></div>
                                </div>   
                                
                                <label for="emailx" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
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
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccionx">
                                    </div>
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
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
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
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
<script>
function getSoporteData(idSoporte) {
    var soportesMap = <?php echo json_encode($soportesMap); ?>;
    return soportesMap[idSoporte] || null;
}
</script>
      <script>
      
      
      function getProveedorData(idProveedor) {
    var proveedoresMap = <?php echo json_encode($proveedoresMap); ?>;
    return proveedoresMap[idProveedor] || null;
}
  </script>
<script src="<?php echo $ruta; ?>assets/js/actualizarviewproveedor.js"></script>
<script src="../assets/js/getmedios.js"></script>
<script src="../assets/js/getregiones.js"></script>
<script src="../assets/js/actualizarsoporteindividual.js"></script>
      <script src="../assets/js/toggleProveedor.js"></script>

<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>