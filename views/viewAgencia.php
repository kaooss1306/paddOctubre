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
                                <div class="theditar"><button type="button" class="btn btn-danger micono ver-agencia-btn novedad" data-bs-toggle="modal" data-bs-target="#actualizaragencia" data-idagencia="<?php echo $idAgencia ?>">
    <i class="fas fa-pencil"></i> Editar datos
</button></div>
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

<div class="modal fade" id="actualizaragencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Agencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioactualizar23">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <input type="hidden" name="id_agencia">
                            <label for="razonSocial" class="form-label">Razón Social</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input id="razonSocial" class="form-control" placeholder="Razón Social" name="razonSocial" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombreFantasia" class="form-label">Nombre de Fantasía</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                <input type="text" class="form-control" id="nombreFantasia" name="nombreFantasia" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombreIdentificador" class="form-label">Nombre Identificador</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" class="form-control" id="nombreIdentificador" name="nombreIdentificador" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rut" class="form-label">RUT Agencia</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" class="form-control" id="rut" name="rut" required>
                                <div class="custom-tooltip" id="rut-tooltip"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="giro" class="form-label">Giro</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                <input type="text" class="form-control" id="giro" name="giro" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombreRepresentanteLegal" class="form-label">Nombre Representante Legal</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nombreRepresentanteLegal" name="nombreRepresentanteLegal" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rutRepresentante" class="form-label">RUT Representante</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" class="form-control" id="rutRepresentante" name="rutRepresentante" required>
                                <div class="custom-tooltip" id="rutRepresentante-tooltip"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="direccionagencia" class="form-label">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control" id="direccionagencia" name="direccionagencia" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="region" class="form-label">Región</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-map"></i></span>
                                <select class="form-select" id="region" name="id_region" required>
                                    <?php foreach ($regiones as $regione) : ?>
                                        <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="comuna" class="form-label">Comuna</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                <select class="form-select" id="comuna" name="id_comuna" required>
                                    <?php foreach ($comunas as $comuna) : ?>
                                        <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                            <?php echo $comuna['nombreComuna']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="telCelular" class="form-label">Teléfono Celular</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="tel" class="form-control phone-input" id="telCelular" name="telCelular" required>
                                <div class="custom-tooltip" id="telCelular-tooltip"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="telFijo" class="form-label">Teléfono Fijo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" class="form-control phone-input" id="telFijo" name="telFijo" required>
                                <div class="custom-tooltip" id="telFijo-tooltip"></div>
                                
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control email-input" id="email" name="email" required>
                                <div class="custom-tooltip" id="email-tooltip"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>


<script>
// Objeto global para nuestras funciones
var AgencyManager = {
    loadAgenciaData: function(idAgencia) {
        var agencia = this.getAgenciaData(idAgencia);

        if (agencia) {
            // Rellenar los campos del formulario con los datos de la agencia
            document.querySelector('input[name="id_agencia"]').value = agencia.id;
            document.querySelector('input[name="razonSocial"]').value = agencia.RazonSocial;
            document.querySelector('input[name="nombreFantasia"]').value = agencia.NombreDeFantasia;
            document.querySelector('input[name="nombreIdentificador"]').value = agencia.NombreIdentificador;
            document.querySelector('input[name="rut"]').value = agencia.RutAgencia;
            document.querySelector('input[name="giro"]').value = agencia.Giro;
            document.querySelector('input[name="nombreRepresentanteLegal"]').value = agencia.NombreRepresentanteLegal;
            document.querySelector('input[name="rutRepresentante"]').value = agencia.rutRepresentante;
            document.querySelector('input[name="direccionagencia"]').value = agencia.DireccionAgencia;
            document.querySelector('input[name="telCelular"]').value = agencia.telCelular;
            document.querySelector('input[name="telFijo"]').value = agencia.telFijo;
            document.querySelector('input[name="email"]').value = agencia.Email;

            // Manejar los selects de región y comuna
            var regionSelect = document.querySelector('select[name="id_region"]');
            var comunaSelect = document.querySelector('select[name="id_comuna"]');
            
            if (regionSelect && comunaSelect) {
                regionSelect.value = agencia.Region;
                regionSelect.dispatchEvent(new Event('change'));
                
                // Esperar a que se actualicen las comunas antes de seleccionar
                setTimeout(() => {
                    comunaSelect.value = agencia.Comuna;
                }, 100);
            }

            // El modal se abrirá automáticamente por el atributo data-bs-toggle="modal"
        } else {
            console.log("No se encontró la agencia con ID:", idAgencia);
        }
    },

    getAgenciaData: function(idAgencia) {
        // Asumiendo que tienes los datos de la agencia en PHP
        return <?php echo json_encode($agencia); ?>;
    },

    actualizarComunas: function(regionId) {
        var comunaSelect = document.querySelector('select[name="id_comuna"]');
        var comunas = <?php echo json_encode($comunas); ?>;
        
        // Limpiar opciones actuales
        comunaSelect.innerHTML = '';
        
        // Filtrar y añadir nuevas opciones
        comunas.filter(function(comuna) {
            return comuna.id_region == regionId;
        }).forEach(function(comuna) {
            var option = document.createElement('option');
            option.value = comuna.id_comuna;
            option.textContent = comuna.nombreComuna;
            comunaSelect.appendChild(option);
        });
    },

    init: function() {
        // Inicializar pestañas Bootstrap
        var tabElems = document.querySelectorAll('a[data-bs-toggle="tab"]')
        tabElems.forEach(function(tabElem) {
            tabElem.addEventListener('click', function (event) {
                event.preventDefault()
                var tabId = this.getAttribute('href')
                var tabContent = document.querySelector(tabId)
                if (tabContent) {
                    // Remover clases activas de todas las pestañas y contenidos
                    document.querySelectorAll('.nav-link, .tab-pane').forEach(function(el) {
                        el.classList.remove('active', 'show')
                    })
                    // Activar la pestaña y contenido seleccionados
                    this.classList.add('active')
                    tabContent.classList.add('active', 'show')
                }
            })
        })

        // Añadir evento para actualizar comunas cuando cambia la región
        var regionSelect = document.querySelector('select[name="id_region"]');
        if (regionSelect) {
            regionSelect.addEventListener('change', function() {
                AgencyManager.actualizarComunas(this.value);
            });
        }

        // Añadir evento al botón de ver agencia
        var verAgenciaBtn = document.querySelector('.ver-agencia-btn');
        if (verAgenciaBtn) {
            verAgenciaBtn.addEventListener('click', function() {
                var idAgencia = this.getAttribute('data-idagencia');
                AgencyManager.loadAgenciaData(idAgencia);
            });
        }
    }
};

// Inicializar AgencyManager cuando se carga el DOM
document.addEventListener('DOMContentLoaded', function() {
    AgencyManager.init();
});
</script>



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
    var rutInputs = document.querySelectorAll('#rut, #rutRepresentante, #rutx, #rutRepresentantex, #telCelularx, #telFijox, #emailx');
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














<script src="<?php echo $ruta; ?>assets/js/updateViewAgencia2.js"></script>
<script src="../assets/js/actualizarviewagen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/eliminaragencia.js"></script>
<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>
