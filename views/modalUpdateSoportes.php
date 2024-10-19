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
                                            <span class="input-group-text"><i class="far fa-user-circle"></i></span>
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
                                        <select class="sesel form-select region-select" name="id_regionx" id="regionx" required>
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
                                        <select class="sesel form-select comuna-select" name="id_comunax" id="comunax" required>
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

<style>
    .medio-soporte {
        margin: 30px 0px;
    }

    .medio-soporte .medio-item {
        border-radius: 30px;
        padding: 5px 10px;
        border: solid;
    }
</style>
<script src="../assets/js/getregiones.js"></script>
<script src="../assets/js/getmedios.js"></script>
<script src="../assets/js/actualizarsoporteindividual.js"></script>