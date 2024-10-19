<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qproveedor.php';

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
                            <div class="titulox"><h4>Listado de Proveedores</h4></div>
                            <div class="agregar"><button type="button" class="btn btn-primary micono" data-bs-toggle="modal" data-bs-target="#agregarProveedor"  ><i class="fas fa-plus-circle"></i> Agregar proveedor</button>
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora" >
                                    <thead>
                                        <tr>

                                            <th>ID</th>
                                            <th>Medio</th>
                                            <th>Nombre Proveedores</th>
                                            <th>Razón Social</th>
                                            <th>Rut</th>
                                            <th>N° de Soportes</th>
                                            <th>Listado de Soportes</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="proveedores-tbody">
                                        <?php foreach ($proveedores as $proveedor): ?>
                                        <tr class="proveedor-row" data-proveedor-id="<?php echo $proveedor['id_proveedor']; ?>">
                                
                                            <td><?php echo $proveedor['id_proveedor']; ?></td>
                                            <td>
                                                                                                        <?php
                                                            // Paso 1: Obtener todos los id_medios para un id_proveedor específico
                                                            $id_proveedor = $proveedor['id_proveedor'];

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




                                                             <svg style="margin-right:5px;" width="24" data-bs-toggle="tooltip" data-bs-html="true"  height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="dist_marketing-btn-icon__AWP8I"><path fill-rule="evenodd" clip-rule="evenodd" d="M24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24C18.6274 24 24 18.6274 24 12ZM13.0033 22.3936C12.574 22.8778 12.2326 23 12 23C11.7674 23 11.426 22.8778 10.9967 22.3936C10.5683 21.9105 10.1369 21.1543 9.75435 20.1342C9.3566 19.0735 9.03245 17.7835 8.81337 16.3341C9.8819 16.1055 10.9934 15.9922 12.1138 16.0004C13.1578 16.0081 14.1912 16.1211 15.1866 16.3341C14.9675 17.7835 14.6434 19.0735 14.2457 20.1342C13.8631 21.1543 13.4317 21.9105 13.0033 22.3936ZM15.3174 15.3396C14.2782 15.1229 13.2039 15.0084 12.1211 15.0004C10.9572 14.9919 9.7999 15.1066 8.68263 15.3396C8.58137 14.4389 8.51961 13.4874 8.50396 12.5H15.496C15.4804 13.4875 15.4186 14.4389 15.3174 15.3396ZM16.1609 16.5779C15.736 19.3214 14.9407 21.5529 13.9411 22.8293C16.6214 22.3521 18.9658 20.9042 20.5978 18.862C19.6345 18.0597 18.4693 17.3939 17.1586 16.9062C16.8326 16.7849 16.4997 16.6754 16.1609 16.5779ZM21.1871 18.0517C20.1389 17.1891 18.8906 16.4837 17.5074 15.969C17.1122 15.822 16.708 15.6912 16.2967 15.5771C16.411 14.5992 16.4798 13.5676 16.4962 12.5H22.9888C22.8973 14.5456 22.2471 16.4458 21.1871 18.0517ZM7.70333 15.5771C7.58896 14.5992 7.52024 13.5676 7.50384 12.5H1.01116C1.10267 14.5456 1.75288 16.4458 2.81287 18.0517C3.91698 17.1431 5.24216 16.4096 6.71159 15.8895C7.0368 15.7744 7.3677 15.6702 7.70333 15.5771ZM3.40224 18.862C5.03424 20.9042 7.37862 22.3521 10.0589 22.8293C9.05934 21.5529 8.26398 19.3214 7.83906 16.5779C7.57069 16.6552 7.3059 16.74 7.04526 16.8322C5.65305 17.325 4.41634 18.0173 3.40224 18.862ZM15.496 11.5H8.50396C8.51961 10.5126 8.58136 9.56113 8.68263 8.66039C9.84251 8.90232 11.0448 9.01653 12.2521 8.99807C13.2906 8.9822 14.3202 8.86837 15.3174 8.66039C15.4186 9.56113 15.4804 10.5126 15.496 11.5ZM9.75435 3.86584C9.3566 4.9265 9.03245 6.21653 8.81337 7.66594C9.92191 7.90306 11.0758 8.01594 12.2369 7.99819C13.2391 7.98287 14.2304 7.87047 15.1866 7.66594C14.9675 6.21653 14.6434 4.9265 14.2457 3.86584C13.8631 2.84566 13.4317 2.08954 13.0033 1.60643C12.574 1.12215 12.2326 1 12 1C11.7674 1 11.426 1.12215 10.9967 1.60643C10.5683 2.08954 10.1369 2.84566 9.75435 3.86584ZM16.4962 11.5C16.4798 10.4324 16.411 9.40077 16.2967 8.42286C16.6839 8.31543 17.0648 8.19328 17.4378 8.05666C18.848 7.54016 20.1208 6.82586 21.1871 5.94826C22.2471 7.55418 22.8973 9.4544 22.9888 11.5H16.4962ZM17.0939 7.11766C18.4298 6.62836 19.6178 5.95419 20.5978 5.13796C18.9658 3.09584 16.6214 1.64793 13.9411 1.17072C14.9407 2.44711 15.736 4.67864 16.1609 7.42207C16.4773 7.33102 16.7886 7.22949 17.0939 7.11766ZM7.33412 7.26641C7.50092 7.32131 7.66929 7.37321 7.83905 7.42207C8.26398 4.67864 9.05934 2.44711 10.0589 1.17072C7.37862 1.64793 5.03423 3.09584 3.40224 5.13796C4.48835 6.04266 5.82734 6.77048 7.33412 7.26641ZM7.02148 8.21629C5.4308 7.69274 3.99599 6.92195 2.81287 5.94826C1.75288 7.55418 1.10267 9.4544 1.01116 11.5H7.50384C7.52024 10.4324 7.58896 9.40077 7.70333 8.42286C7.47376 8.35918 7.24638 8.29031 7.02148 8.21629Z" fill="currentColor"></path></svg> <span> <?php echo $tooltip_content?></span>

                                                       
                                                        </td>                                            <td><?php echo $proveedor['nombreProveedor']; ?></td>
                                            <td><?php echo $proveedor['razonSocial']; ?></td>
                                            <td><?php echo $proveedor['rutProveedor']; ?></td>
                                            <td>
                                                <?php
                                          $id_proveedor = $proveedor['id_proveedor'];
                                          $soporteCount = isset($proveedorCountMapSoport[$id_proveedor]) ? $proveedorCountMapSoport[$id_proveedor] : 0;
                            echo $soporteCount; 
                                                ?>
                                            </td>
                                            <td>
                                            <a class="btn btn-primary micono" href="views/viewSoporteProveedor.php?id_proveedor=<?php echo $proveedor['id_proveedor']; ?>" data-toggle="tooltip" title="Ver Soportes"><i class="fas fa-eye "></i> <span style="font-size:10px;font-weigth:400 !important;">Ver Soportes</span></a> 

                                            </td>
                                            <td>
                                            <div class="alineado">
                                            <label class="custom-switch sino" data-toggle="tooltip" 
                                            title="<?php echo $proveedor['estado'] ? 'Desactivar Proveedor' : 'Activar Cliente'; ?>">
                                            <input type="checkbox" 
                                                class="custom-switch-input estado-switch2"
                                                data-id="<?php echo $proveedor['id_proveedor']; ?>" data-tipo="proveedor" <?php echo $proveedor['estado'] ? 'checked' : ''; ?>>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                            </div>
                                            </td>
                                            <td>
                                            <a class="btn btn-primary micono" href="views/viewProveedor.php?id_proveedor=<?php echo $proveedor['id_proveedor']; ?>" data-toggle="tooltip" title="Ver Proveedor"><i class="fas fa-eye "></i></a> 

                                                <a class="btn btn-success micono"  data-bs-toggle="modal" data-bs-target="#actualizarProveedor" data-idmedios="<?php echo $id_medios_json; ?>" data-idproveedor="<?php echo $proveedor['id_proveedor']; ?>" onclick="loadProveedorData(this)" ><i class="fas fa-pencil-alt"></i></a>
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
    </section>
</div>
<div class="modal fade" id="agregarProveedor" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioAgregarProveedor">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Agregar Proveedor</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="labelforms" for="codigo">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentificador">
                                    </div>
                                    <label class="labelforms" for="codigo">Medios</label>
                                    <div id="dropdown7" class="input-group dropdown" >
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
                                        <input class="form-control" placeholder="Nombre de Proveedor" name="nombreProveedor">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre Representante</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre Representante" name="nombreRepresentante">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">


                                
                                <label for="rutProveedor" class="labelforms">Rut Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="rutProveedor" name="rutProveedor" required>
                                    <div class="custom-tooltip" id="rutProveedor-tooltip"></div>
                                </div>        

                                    <label class="labelforms" for="codigo">Giro Proveedor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro Proveedor" name="giroProveedor">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia">
                                    </div>

                                    <label for="rut_soporte" class="labelforms">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="rutRepresentante" name="rutRepresentante" required>
                                    <div class="custom-tooltip" id="rutRepresentante-tooltip"></div>
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
                                        <input class="form-control" placeholder="Razón Social" name="razonSocial">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-map"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_region" id="regionx" required>
                                            <?php foreach ($regiones as $regione) : ?>
                                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telCelular" class="labelforms">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono Celular" id="telCelular" name="telCelular" required>
                                    <div class="custom-tooltip" id="telCelular-tooltip"></div>
                                </div>                  

                                <label for="email" class="labelforms">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="text" class="form-control email-input" id="email" name="email" required>
                                    <div class="custom-tooltip" id="email-tooltip"></div>
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
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccionFacturacion">
                                    </div>
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_comuna" id="comunax" required>
                                            <?php foreach ($comunas as $comuna) : ?>
                                                <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                                    <?php echo $comuna['nombreComuna']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telFijo" class="labelforms">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono fijo" id="telFijo" name="telFijo" required>
                                    <div class="custom-tooltip" id="telFijo-tooltip"></div>
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
                                        <input class="form-control" placeholder="Bonifiación por año %" name="bonificacion_ano">
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
                                        <input class="form-control" placeholder="Escala de rango" name="escala_rango">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary btn-lg rounded-pill" type="submit" id="actualizarProveedorx">
                            <span class="btn-txt">Guardar Proveedor</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
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
                                    <label for="codigo" class="labelforms">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input type="hidden" name="idprooo">
                                        <input type="hidden"  name="idmedios">
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentificadorp">
                                    </div>
                                    <label class="labelforms" for="codigo">Medios</label>
                                    <div id="dropdown1" class="dropdown-medios input-group dropdown" >
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
                                    <input type="text" class="phone-input form-control" id="telCelularp" name="telCelularp" required>
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
                                    <input type="text" class="phone-input form-control" id="telFijop" name="telFijop" required>
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





       










<script src="<?php echo $ruta; ?>assets/js/agregarsoporte.js"></script>
<script src="<?php echo $ruta; ?>assets/js/actualizarproveedor.js"></script>
<script src="<?php echo $ruta; ?>assets/js/agregarproveedor.js"></script>
<script src="<?php echo $ruta; ?>assets/js/actualizarsoporte.js"></script>

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
    var rutInputs = document.querySelectorAll('#rutRepresentantep, #rutProveedorp, #rutProveedor, #rutRepresentantex, #rutSoporte, #rut_soporte, #rutRepresentante');
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
    const form = document.getElementById('formualarioSoporte');

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
function getSoporteData(idSoporte) {
    var soportesMap = <?php echo json_encode($soportesMap); ?>;
    return soportesMap[idSoporte] || null;
}
</script>

<script>function getProveedorData(idProveedor) {
    var proveedoresMap = <?php echo json_encode($proveedoresMap); ?>;
    return proveedoresMap[idProveedor] || null;
}</script>
<script>

</script>



<script>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, procedemos con la eliminación
            fetch(`/querys/modulos/deleteProveedor.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Eliminado!',
                            'El Proveedor ha sido eliminado.',
                            'success'
                        ).then(() => {
                            // Redirigir a ListMedios.php después de cerrar la alerta
                            window.location.href = 'ListProveedores.php';
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar el Proveedor.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Ocurrió un error al intentar eliminar el medio.',
                        'error'
                    );
                });
        }
    });
}
</script>
<script>
function confirmarEliminacionSoporte(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, procedemos con la eliminación
            fetch(`/querys/modulos/deleteSoporte.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Eliminado!',
                            'El Soporte ha sido eliminado.',
                            'success'
                        ).then(() => {
                            // Redirigir a ListMedios.php después de cerrar la alerta
                            window.location.href = 'ListProveedores.php';
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar el Soporte.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Ocurrió un error al intentar eliminar el Soporte.',
                        'error'
                    );
                });
        }
    });
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const expandirProveedorId = urlParams.get('expandir');
    const nuevoSoporteId = urlParams.get('nuevoSoporte');

    if (expandirProveedorId) {
        const proveedorRow = document.querySelector(tr[data-proveedor-id="${expandirProveedorId}"]);
        if (proveedorRow) {
            const expandIcon = proveedorRow.querySelector('.expand-icon');
            if (expandIcon) {
                // Simular un clic en el icono para expandir la fila
                expandIcon.click();
                
                // Esperar a que la fila se expanda completamente
                setTimeout(() => {
                    if (nuevoSoporteId) {
                        const nuevoSoporteRow = document.querySelector(tr[data-soporte-id="${nuevoSoporteId}"]);
                        if (nuevoSoporteRow) {
                            // Resaltar el nuevo soporte
                            nuevoSoporteRow.classList.add('highlight-row');
                            nuevoSoporteRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        proveedorRow.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 500); // Ajusta este tiempo si es necesario
            }
        }

        // Limpiar los parámetros de la URL
        window.history.replaceState({}, document.title, "ListProveedores.php");
    }
});
</script>
<script src="assets/js/agregarexistprov.js"></script>
<script src="assets/js/getmedios.js"></script>
<script src="assets/js/toggleProveedor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var table;

    // Comprueba si la tabla ya está inicializada como DataTable
    if ($.fn.DataTable.isDataTable('#tableExportadora')) {
        table = $('#tableExportadora').DataTable();
    } else {
        // Si no está inicializada, inicialízala
        table = $('#tableExportadora').DataTable({
            // Aquí puedes añadir opciones de configuración si es necesario
        });
    }

    $('#tableExportadora').on('click', 'tr.proveedor-row .expand-icon', function(e) {
        e.stopPropagation(); // Previene la propagación del evento

        var icon = $(this);
        var tr = icon.closest('tr.proveedor-row');
        var row = table.row(tr);
        var proveedorId = tr.data('proveedor-id');

        if (row.child.isShown()) {
            // Cerrar esta fila
            icon.removeClass('fa-angle-down').addClass('fa-angle-right');
            row.child().find('.child-row').slideUp(300, function() {
                row.child.hide();
                tr.removeClass('shown');
            });
        } else {
            // Cerrar otras filas abiertas
            table.rows().every(function() {
                if (this.child.isShown()) {
                    var r = $(this.node());
                    r.find('.expand-icon').removeClass('fa-angle-down').addClass('fa-angle-right');
                    this.child().find('.child-row').slideUp(300, function() {
                        this.child.hide();
                        r.removeClass('shown');
                    }.bind(this));
                }
            });

            // Abrir esta fila
            icon.removeClass('fa-angle-right').addClass('fa-angle-down');
            if (row.child() && row.child().length) {
                // Si el contenido hijo ya existe, solo mostrarlo
                row.child.show();
                row.child().find('.child-row').slideDown(300, function() {
                    tr.addClass('shown');
                });
            } else {
                // Si el contenido hijo no existe, cargarlo
                $.ajax({
    url: 'get_soportes.php',
    method: 'GET',
    data: { proveedor_id: proveedorId },
    success: function(response) {
        try {
            var soportes = JSON.parse(response);
            console.log('Respuesta del servidor:', response);
            console.log('Soportes parseados:', soportes);
            
            // Validar si los datos son un array
            if (Array.isArray(soportes)) {
                console.log('Soportes array length:', soportes.length);
            } else {
                console.error('Datos recibidos no son un array.');
            }

            // Obtener los datos del proveedor desde get_proveedores.php
            $.ajax({
                url: 'get_proveedores_unico.php',
                method: 'GET',
                data: { id_proveedor: proveedorId },
                success: function(responseProveedor) {
                    var proveedor = JSON.parse(responseProveedor);
                    console.log('Datos del proveedor:', proveedor);

                    var childContent = $('<div class="child-row" style="display: none;">' + formatSoportes(soportes, proveedor) + '</div>');
                    row.child(childContent).show();
                    childContent.slideDown(300, function() {
                        tr.addClass('shown');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener datos del proveedor:", error);
                }
            });

        } catch (e) {
            console.error('Error al procesar la respuesta JSON:', e);
        }
    },
    error: function(xhr, status, error) {
        console.error("Error al obtener soportes:", error);
    }
});

            }
        }
    });});

    // Función para formatear los soportes
    function formatSoportes(soportes, proveedor) {
    let html = `
        <div class="card-header milinea">
            <div class="titulox"><h4>Listado de Soportes</h4></div>
            <div class="agregar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarSoportessss"
                    data-rso="${proveedor.razonSocial}" data-nfo="${proveedor.nombreFantasia}" data-rpo="${proveedor.rutProveedor}" data-gpo="${proveedor.giroProveedor}"
                    data-nro="${proveedor.nombreRepresentante}" data-rpoo="${proveedor.rutRepresentante}" data-dfo="${proveedor.direccionFacturacion}"
                    data-iro="${proveedor.id_region}" data-ico="${proveedor.id_comuna}" data-tco="${proveedor.telCelular}" data-tfo="${proveedor.telFijo}" 
                    data-elo="${proveedor.email}" data-id="${proveedor.id_proveedor}">
                    <i class="fas fa-plus-circle"></i>${proveedor.id_proveedor} ${proveedor.razonSocial} Crear Soporte
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarsoporteprov"
                    data-id-proveedor="${proveedor.id_proveedor}">
                    <i class="fas fa-plus-circle"></i> Agregar Soporte
                </button>
            </div>
        </div>
        <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Soporte</th>
                    <th>Razón Social</th>
                    <th>Rut</th>
                    <th>Medios</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="soportes-tbody">
    `;

    soportes.forEach(soporte => {
        const {
            id_soporte = '', nombreIdentficiador = '', razonSocial = '', rut_soporte = '', telFijo = '', medios = []
        } = soporte;

        // Crear una lista de nombres de medios
        let mediosNombres = Array.isArray(medios) ? medios.join(', ') : '';
        let tooltipContent2 = `${mediosNombres}`;

        html += `
            <tr data-soporte-id="${soporte.id_soporte}">
                <td>${id_soporte}</td>
                <td>${nombreIdentficiador}</td>
                <td>${razonSocial}</td>
                <td>${rut_soporte}</td>
                <td style="word-wrap: break-word; position:relative;"> <svg style="margin-right:5px;" width="24" data-bs-toggle="tooltip" data-bs-html="true" title="${tooltipContent2}" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="dist_marketing-btn-icon__AWP8I"><path fill-rule="evenodd" clip-rule="evenodd" d="M24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24C18.6274 24 24 18.6274 24 12ZM13.0033 22.3936C12.574 22.8778 12.2326 23 12 23C11.7674 23 11.426 22.8778 10.9967 22.3936C10.5683 21.9105 10.1369 21.1543 9.75435 20.1342C9.3566 19.0735 9.03245 17.7835 8.81337 16.3341C9.8819 16.1055 10.9934 15.9922 12.1138 16.0004C13.1578 16.0081 14.1912 16.1211 15.1866 16.3341C14.9675 17.7835 14.6434 19.0735 14.2457 20.1342C13.8631 21.1543 13.4317 21.9105 13.0033 22.3936ZM15.3174 15.3396C14.2782 15.1229 13.2039 15.0084 12.1211 15.0004C10.9572 14.9919 9.7999 15.1066 8.68263 15.3396C8.58137 14.4389 8.51961 13.4874 8.50396 12.5H15.496C15.4804 13.4875 15.4186 14.4389 15.3174 15.3396ZM16.1609 16.5779C15.736 19.3214 14.9407 21.5529 13.9411 22.8293C16.6214 22.3521 18.9658 20.9042 20.5978 18.862C19.6345 18.0597 18.4693 17.3939 17.1586 16.9062C16.8326 16.7849 16.4997 16.6754 16.1609 16.5779ZM21.1871 18.0517C20.1389 17.1891 18.8906 16.4837 17.5074 15.969C17.1122 15.822 16.708 15.6912 16.2967 15.5771C16.411 14.5992 16.4798 13.5676 16.4962 12.5H22.9888C22.8973 14.5456 22.2471 16.4458 21.1871 18.0517ZM7.70333 15.5771C7.58896 14.5992 7.52024 13.5676 7.50384 12.5H1.01116C1.10267 14.5456 1.75288 16.4458 2.81287 18.0517C3.91698 17.1431 5.24216 16.4096 6.71159 15.8895C7.0368 15.7744 7.3677 15.6702 7.70333 15.5771ZM3.40224 18.862C5.03424 20.9042 7.37862 22.3521 10.0589 22.8293C9.05934 21.5529 8.26398 19.3214 7.83906 16.5779C7.57069 16.6552 7.3059 16.74 7.04526 16.8322C5.65305 17.325 4.41634 18.0173 3.40224 18.862ZM15.496 11.5H8.50396C8.51961 10.5126 8.58136 9.56113 8.68263 8.66039C9.84251 8.90232 11.0448 9.01653 12.2521 8.99807C13.2906 8.9822 14.3202 8.86837 15.3174 8.66039C15.4186 9.56113 15.4804 10.5126 15.496 11.5ZM9.75435 3.86584C9.3566 4.9265 9.03245 6.21653 8.81337 7.66594C9.92191 7.90306 11.0758 8.01594 12.2369 7.99819C13.2391 7.98287 14.2304 7.87047 15.1866 7.66594C14.9675 6.21653 14.6434 4.9265 14.2457 3.86584C13.8631 2.84566 13.4317 2.08954 13.0033 1.60643C12.574 1.12215 12.2326 1 12 1C11.7674 1 11.426 1.12215 10.9967 1.60643C10.5683 2.08954 10.1369 2.84566 9.75435 3.86584ZM16.4962 11.5C16.4798 10.4324 16.411 9.40077 16.2967 8.42286C16.6839 8.31543 17.0648 8.19328 17.4378 8.05666C18.848 7.54016 20.1208 6.82586 21.1871 5.94826C22.2471 7.55418 22.8973 9.4544 22.9888 11.5H16.4962ZM17.0939 7.11766C18.4298 6.62836 19.6178 5.95419 20.5978 5.13796C18.9658 3.09584 16.6214 1.64793 13.9411 1.17072C14.9407 2.44711 15.736 4.67864 16.1609 7.42207C16.4773 7.33102 16.7886 7.22949 17.0939 7.11766ZM7.33412 7.26641C7.50092 7.32131 7.66929 7.37321 7.83905 7.42207C8.26398 4.67864 9.05934 2.44711 10.0589 1.17072C7.37862 1.64793 5.03423 3.09584 3.40224 5.13796C4.48835 6.04266 5.82734 6.77048 7.33412 7.26641ZM7.02148 8.21629C5.4308 7.69274 3.99599 6.92195 2.81287 5.94826C1.75288 7.55418 1.10267 9.4544 1.01116 11.5H7.50384C7.52024 10.4324 7.58896 9.40077 7.70333 8.42286C7.47376 8.35918 7.24638 8.29031 7.02148 8.21629Z" fill="currentColor"></path></svg> <span> ${tooltipContent2}</span>
</td>
                <td>${telFijo}</td>
                <td>
                    <a class="btn btn-primary micono" href="views/viewSoporte.php?id_soporte=${id_soporte}" data-toggle="tooltip" title="Ver Soporte"><i class="fas fa-eye "></i></a>
                    <a class="btn btn-success micono"  data-bs-toggle="modal" data-bs-target="#actualizarSoporte" data-id-soporte="${id_soporte}" data-idproveedor="${proveedor.id_proveedor}" onclick="loadProveedorDataSoporte(this)"><i class="fas fa-pencil-alt"></i></a>

                </td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    return html;
    $('[data-bs-toggle="tooltip"]').tooltip();
}


</script>

<?php include 'querys/modulos/modalagregarexistente.php'; ?>
<?php include 'querys/modulos/modalagregarproveedor.php'; ?>
<?php include 'querys/modulos/modalagregarsoporte.php'; ?>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>