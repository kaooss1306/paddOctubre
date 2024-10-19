<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qagencia.php';

include 'componentes/header.php';
include 'componentes/sidebar.php';
?>
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
                                <input type="tel" class="form-control" id="telCelular" name="telCelular" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="telFijo" class="form-label">Teléfono Fijo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" class="form-control" id="telFijo" name="telFijo" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required>
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
                <input type="text" class="form-control" id="rut" name="rut" required>
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
                <input type="tel" class="form-control" id="telCelular" name="telCelular" required>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="telFijo" class="form-label">Teléfono Fijo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="tel" class="form-control" id="telFijo" name="telFijo" required>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="email" class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" required>
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



<script src="<?php echo $ruta; ?>assets/js/actualizaragenciaup.js"></script>
<script src="<?php echo $ruta; ?>assets/js/addAgencia.js"></script>
<script src="assets/js/toggleAgenciaEstado.js"></script>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>