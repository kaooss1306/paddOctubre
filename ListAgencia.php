<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qagencia.php';

include 'componentes/header.php';
include 'componentes/sidebar.php';
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
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        <div class="card-header milinea">
                        <div class="titulox"><h4>Listado Agencias</h4></div>
                        <div class="agregar"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarAgenciaModal"><i class="fas fa-plus-circle"></i> Agregar Agencia</button></div>
                        </div>
                            
                       
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre de Agencia</th>
                                            <th>Representante</th>
                                            <th>Razón Social</th>
                                            <th>Rut Agencia</th>
                                            <th>N° de Campañas</th>
                                            <th>N° de Contratos</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($agencias as $agencia): ?>
                                        <tr>
                                            <td><?php echo $agencia['id']; ?></td>
                                            <td><?php echo $agencia['NombreDeFantasia']; ?></td>
                                            <td><?php echo $agencia['NombreRepresentanteLegal']; ?></td>
                                            <td><?php echo $agencia['RazonSocial']; ?></td>
                                            <td><?php echo $agencia['RutAgencia']; ?></td>
                                            <td>
                                                <?php
                                                 
                                                 $contador = 0;
                                                 foreach ($campaigns as $campaign) {
                                                     if ($agencia['id'] == $campaign['Id_Agencia']) {
                                                         $contador++;
                                                     }
                                                 }
                                                 echo $contador;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                 
                                                 $contador = 0;
                                                 foreach ($contratos as $contrato) {
                                                     if ($agencia['id'] == $contrato['IdAgencias']) {
                                                         $contador++;
                                                     }
                                                 }
                                                 echo $contador;
                                                ?>
                                            </td>
                                          <td>
    <div class="alineado">
       <label class="custom-switch sino" data-toggle="tooltip" 
       title="<?php echo $agencia['estado'] ? 'Desactivar agencia' : 'Activar agencia'; ?>">
    <input type="checkbox" 
           class="custom-switch-input estado-switch"
           data-id="<?php echo $agencia['id']; ?>"
           <?php echo $agencia['estado'] ? 'checked' : ''; ?>>
    <span class="custom-switch-indicator"></span>
</label>
    </div>
</td>
                                            <td><a href="views/viewAgencia.php?id=<?php echo $agencia['id']; ?>" data-toggle="tooltip" title="Ver Agencia"><i class="fas fa-eye btn btn-primary miconoz"></i></a>   
                                            <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizaragencia" data-idagencia="<?php echo $agencia['id']; ?>" onclick="loadAgenciaData(this)" data-toggle="tooltip" title="Editar Agencia">
                            <i class="fas fa-pencil-alt"></i>
                        </button> 
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


<div class="modal fade" id="actualizaragencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Agencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioactualizar">
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






<!-- Modal para agregar agencia -->
<div class="modal fade" id="agregarAgenciaModal" tabindex="-1" aria-labelledby="agregarAgenciaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarAgenciaModalLabel">Agregar Nueva Agencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formularioAgregarAgencia">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="razonSocial" class="form-label">Razón Social</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <input type="text" class="form-control" id="razonSocial" name="razonSocial" required>
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
                <input type="text" class="form-control" id="rutx" name="rut" required>
                <div class="custom-tooltip" id="rutx-tooltip"></div>
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
                <input type="text" class="form-control" id="rutRepresentantex" name="rutRepresentante" required>
                <div class="custom-tooltip" id="rutRepresentantex-tooltip"></div>
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
                <select class="form-select region-select" id="region" name="id_region" required>
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
                <select class="form-select comuna-select" id="comuna" name="id_comuna" required>
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
                <input type="tel" class="form-control phone-input" id="telCelularx" name="telCelular" required>
                <div class="custom-tooltip" id="telCelularx-tooltip"></div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="telFijo" class="form-label">Teléfono Fijo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="tel" class="form-control phone-input" id="telFijox" name="telFijo" required>
                <div class="custom-tooltip" id="telFijox-tooltip"></div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="email" class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control email-input" id="emailx" name="email" required>
                <div class="custom-tooltip" id="emailx-tooltip"></div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarAgencia">Guardar Agencia</button>
      </div>
    </div>
  </div>
</div>







<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para filtrar comunas por región
    function filtrarComunasPorRegion(regionSelect, comunaSelect) {
        regionSelect.addEventListener('change', function () {
            var regionId = this.value;
            var opcionesComunas = comunaSelect.querySelectorAll('option');

            // Ocultar todas las opciones de comuna
            opcionesComunas.forEach(function (opcion) {
                opcion.style.display = 'none';
            });

            // Mostrar solo las comunas que pertenecen a la región seleccionada
            var comunasFiltradas = Array.from(opcionesComunas).filter(function (opcion) {
                return opcion.getAttribute('data-region') === regionId;
            });

            comunasFiltradas.forEach(function (opcion) {
                opcion.style.display = 'block';
            });

            // Seleccionar la primera opción visible
            if (comunasFiltradas.length > 0) {
                comunasFiltradas[0].selected = true;
            }
        });

        // Disparar el evento change al cargar la página para establecer el estado inicial
        regionSelect.dispatchEvent(new Event('change'));
    }

    // Aplicar el filtro al modal de edición
    var regionSelectEditar = document.querySelector('#actualizaragencia select[name="id_region"]');
    var comunaSelectEditar = document.querySelector('#actualizaragencia select[name="id_comuna"]');
    if (regionSelectEditar && comunaSelectEditar) {
        filtrarComunasPorRegion(regionSelectEditar, comunaSelectEditar);
    }

    // Aplicar el filtro al modal de agregar nueva agencia
    var regionSelectAgregar = document.querySelector('#agregarAgenciaModal select[name="id_region"]');
    var comunaSelectAgregar = document.querySelector('#agregarAgenciaModal select[name="id_comuna"]');
    if (regionSelectAgregar && comunaSelectAgregar) {
        filtrarComunasPorRegion(regionSelectAgregar, comunaSelectAgregar);
    }

    // Función para cargar datos de la agencia en el modal de edición
    window.loadAgenciaData = function(button) {
        var idAgencia = button.getAttribute('data-idagencia');
        var agencia = getAgenciaData(idAgencia);

        if (agencia) {
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

            document.querySelector('select[name="id_region"]').value = agencia.Region;
            document.querySelector('select[name="id_region"]').dispatchEvent(new Event('change'));
            document.querySelector('select[name="id_comuna"]').value = agencia.Comuna;
        } else {
            console.log("No se encontró la agencia con ID:", idAgencia);
        }
    }

    function getAgenciaData(idAgencia) {
        var agenciasMap = <?php echo json_encode($agenciasMap); ?>;
        return agenciasMap[idAgencia] || null;
    }
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






<script src="<?php echo $ruta; ?>assets/js/updateAgenciaUp.js"></script>
<script src="<?php echo $ruta; ?>assets/js/addAgencia.js"></script>
<script src="assets/js/toggleAgenciaEstado.js"></script>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>