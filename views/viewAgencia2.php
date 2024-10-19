<?php
session_start();

include '../querys/qclientes.php';
include '../componentes/header.php';
include '../componentes/sidebar.php';

$idAgencia = isset($_GET['id']) ? $_GET['id'] : null;

$agencias = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Agencias?select=*');
$regiones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Region?select=*');
$comunas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comunas?select=*');

$agencia = null;
foreach ($agencias as $a) {
    if ($a['id'] == $idAgencia) {
        $agencia = $a;
        break;
    }
}

$nombreRegion = '';
$nombreComuna = '';

foreach ($regiones as $region) {
    if ($region['id'] == $agencia['Region']) {
        $nombreRegion = $region['nombreRegion'];
        break;
    }
}

foreach ($comunas as $comuna) {
    if ($comuna['id_comuna'] == $agencia['Comuna']) {
        $nombreComuna = $comuna['nombreComuna'];
        break;
    }
}

if (!$agencia) {
    echo "Agencia no encontrada.";
    exit();
}
?>

<div class="main-content">
 <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListAgencia.php">Ver Agencias</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $agencia['NombreDeFantasia']; ?></li>
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
                                    <?php echo $agencia['NombreDeFantasia']; ?></div>
                                <div class="author-box-job">
                                             <?php
    // Convertir la cadena de fecha y hora a un objeto DateTime
    $fecha = new DateTime($agencia['created_at']);
    
    // Formatear la fecha como deseas (en este caso, solo la fecha)
    echo 'Registrado el: '.$fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
    ?>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-job">

                                    Nombre Identificador: <?php echo $agencia['NombreIdentificador']; ?>
                                </div>
                                <div class="w-100 d-sm-none"></div>
                            </div>
                        </div>
                    </div>


                </div>
        




<div class="col-12 col-md-12 col-lg-8">
<div class="card">
            <div class="card-header milinea">
                
               
            </div>
            <div class="card-body">
                <!-- Pestañas -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="generales-tab" data-bs-toggle="tab" href="#generales" role="tab" aria-controls="generales" aria-selected="true">Datos Generales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="facturacion-tab" data-bs-toggle="tab" href="#facturacion" role="tab" aria-controls="facturacion" aria-selected="false">Datos de Facturación</a>
                    </li>
                     <div class="agregar2">
                    <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizaragencia2" data-idagencia="<?php echo $idAgencia ?>" onclick="loadAgenciaData2(this)">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                </div>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Datos Generales -->
                    <div class="tab-pane fade show active" id="generales" role="tabpanel" aria-labelledby="generales-tab">
                        <div class="row">
                            
                                <div class="col-md-4 col-6 b-r">
                                <strong>Razón Social:</strong><br>
                                   
                                    <p class="text-muted""><?php echo $agencia['RazonSocial']; ?></p>
                                </div>


                                <div class="col-md-4 col-6 b-r">
                                    <strong>Nombre de Fantasía:</strong><br>
                                    <p><?php echo $agencia['NombreDeFantasia']; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Nombre Identificador:</strong><br>
                                    <p><?php echo $agencia['NombreIdentificador']; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Rut:</strong><br>
                                    <p><?php echo $agencia['RutAgencia']; ?></p>
                                </div>
                            
                           
                                <div class="col-md-4 col-6 b-r">
                                        <strong>Giro:</strong><br>
                                    <p><?php echo $agencia['Giro']; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Nombre Representante Legal:</strong><br>
                                    <p><?php echo $agencia['NombreRepresentanteLegal']; ?></p>
                                </div>
                               <div class="col-md-4 col-6 b-r">
                                    <strong>Rut Representante:</strong><br>
                                    <p><?php echo $agencia['rutRepresentante']; ?></p>
                                </div>
                            
                        </div>
                    </div>
                    <!-- Datos de Facturación -->
                    <div class="tab-pane fade" id="facturacion" role="tabpanel" aria-labelledby="facturacion-tab">
                        <div class="row">
                            
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Dirección:</strong><br>
                                    <p><?php echo $agencia['DireccionAgencia']; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Teléfono Celular:</strong><br>
                                    <p><?php echo $agencia['telCelular']; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Teléfono Fijo:</strong><br>
                                    <p><?php echo $agencia['telFijo']; ?></p>
                                </div>
                          
                            
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Email:</strong><br>
                                    <p><?php echo $agencia['Email']; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Región:</strong><br>
                                    <p><?php echo $nombreRegion; ?></p>
                                </div>
                                <div class="col-md-4 col-6 b-r">
                                    <strong>Comuna:</strong><br>
                                    <p><?php echo $nombreComuna; ?></p>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
</div>

<div class="modal fade" id="actualizaragencia2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Agencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioactualizarAge">
                    <div>
                        <h3 class="titulo-registro mb-3">Actualizar Agencia:</h3>
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" name="id_agencia">
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
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                            <div class="col-6">
                                <p><input class="form-control" placeholder="Dirección" name="direccionagencia" required></p>
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
                            </div>
                            <div class="col-6">
                                <p><input class="form-control" placeholder="Teléfono celular" name="telCelular" required></p>
                                <p><input class="form-control" placeholder="Teléfono fijo" name="telFijo" required></p>
                                <p><input class="form-control" placeholder="Email" name="email" required></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveBtn" onclick="submitForm(event)">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar pestañas Bootstrap
    var tabElems = document.querySelectorAll('a[data-toggle="tab"]')
    tabElems.forEach(function(tabElem) {
        tabElem.addEventListener('click', function (event) {
            event.preventDefault()
            var tabId = this.getAttribute('href')
            document.querySelector(tabId).classList.add('show', 'active')
            this.classList.add('active')
            
            tabElems.forEach(function(otherTab) {
                if (otherTab !== tabElem) {
                    otherTab.classList.remove('active')
                    var otherTabId = otherTab.getAttribute('href')
                    document.querySelector(otherTabId).classList.remove('show', 'active')
                }
            })
        })
    })

document.addEventListener('DOMContentLoaded', function () {
    function loadAgenciaData2(button) {
        var idAgencia2 = button.getAttribute('data-idagencia');
        var agencia2 = getAgenciaData(idAgencia2);

        if (agencia2) {
            document.querySelector('input[name="id_agencia"]').value = agencia2.id;
            document.querySelector('input[name="razonSocial"]').value = agencia2.RazonSocial;
            document.querySelector('input[name="nombreFantasia"]').value = agencia2.NombreDeFantasia;
            document.querySelector('input[name="nombreIdentificador"]').value = agencia2.NombreIdentificador;
            document.querySelector('input[name="rut"]').value = agencia2.RutAgencia;
            document.querySelector('input[name="giro"]').value = agencia2.Giro;
            document.querySelector('input[name="nombreRepresentanteLegal"]').value = agencia2.NombreRepresentanteLegal;
            document.querySelector('input[name="rutRepresentante"]').value = agencia2.rutRepresentante;
            document.querySelector('input[name="direccionagencia"]').value = agencia2.DireccionAgencia;
            document.querySelector('input[name="telCelular"]').value = agencia2.telCelular;
            document.querySelector('input[name="telFijo"]').value = agencia2.telFijo;
            document.querySelector('input[name="email"]').value = agencia2.Email;

            document.querySelector('select[name="id_region"]').value = agencia2.Region;
            document.querySelector('select[name="id_comuna"]').value = agencia2.Comuna;
        } else {
            console.log("No se encontró la agencia con ID:", idAgencia);
        }
    }

    function getAgenciaData(idAgencia2) {
        var agenciasMap = <?php echo json_encode($agencias); ?>;
        return agenciasMap.find(agencia => agencia.id == idAgencia2) || null;
    }

    window.loadAgenciaData2 = loadAgenciaData2;

    // Filtrar comunas por región seleccionada
    document.getElementById('region').addEventListener('change', function () {
        var regionId = this.value;
        var comunaSelect = document.getElementById('comuna');
        var opcionesComunas = comunaSelect.querySelectorAll('option');

        // Mostrar solo las comunas que pertenecen a la región seleccionada
        opcionesComunas.forEach(function (opcion) {
            if (opcion.getAttribute('data-region') === regionId) {
                opcion.style.display = 'block';
            } else {
                opcion.style.display = 'none';
            }
        });

        // Seleccionar la primera opción visible
        var firstVisibleOption = comunaSelect.querySelector('option[data-region="' + regionId + '"]');
        if (firstVisibleOption) {
            firstVisibleOption.selected = true;
        }
    });

    // Disparar el evento change al cargar la página para establecer el estado inicial
    document.getElementById('region').dispatchEvent(new Event('change'));
});

<script src="../assets/js/actualizarviewagen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/eliminaragencia.js"></script>
<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>
