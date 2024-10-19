<div class="modal fade" id="agregarSoportessss" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
     
            <div class="modal-body">
                <form id="formualarioSoporte">
                    <!-- Campo oculto para el ID -->
                    <input type="hidden"  name="id_proveedor" id="id_proveedor">
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
    <button type="button" class="dropdown-button" style="display:none;">Select Medios</button>
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
                                    <label class="labelforms" for="codigo">Rut</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Rut" name="rut_soporte" required>
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre Representante Legal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-user"></i></span>
                                        </div>
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
                                    <label class="labelforms" for="codigo">Rut Representante</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Rut Representante" name="rutRepresentante" required>
                                    </div>
                                </div></div>
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                        <div class="col-6">

                        <div class="form-group">
                        <label  for="codigo">Dirección Facturación</label>
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
                                        <select class="sesel form-select" name="id_region" id="regionxx" required>
                                    <?php foreach ($regiones as $regione) : ?>
                                        <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                    </div>
                                    <label class="labelforms" for="codigo">Teléfono celular</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Teléfono celular" name="telCelular" required>
                                    </div>
                                    </div></div>
                        <div class="col-6">

                        <div class="form-group">
                        <label  for="codigo">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Email" name="email">
                                    </div>   
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_comuna" id="comunaxx" required>
                                <?php foreach ($comunas as $comuna) : ?>
                                    <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                        <?php echo $comuna['nombreComuna']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                                    </div> 
                                    <label class="labelforms"  for="codigo">Teléfono fijo</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Teléfono fijo" name="telFijo" required>
                                    </div>   



                            
                           
                                
                        </div></div>
                    </div>
                   </div>
                    
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>


                                  

                        <input name="razonsoculto" type="hidden">
                        <input name="nombref" type="hidden">
                        <input name="rutt" type="hidden">
                        <input name="giroo" type="hidden">
                        <input name="nombreRepesentanteO" type="hidden">
                        <input name="rutRepresent" type="hidden">
                        <input name="direcciono" type="hidden">
                        <input name="regiono" type="hidden">
                        <input name="comunao" type="hidden">
                        <input name="telCelularo" type="hidden">
                        <input name="telFijoo" type="hidden">
                        <input name="emailO" type="hidden">
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
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('regionxx').addEventListener('change', function () {
        var regionId = this.value;
        var comunaSelect = document.getElementById('comunaxx');
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

    document.getElementById('regionxx').dispatchEvent(new Event('change'));
});</script>

<script src="../../assets/js/getmedios.js"></script>