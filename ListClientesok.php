<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qclientes.php';

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
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
</style>
<div class="main-content">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Clientes</li>
        </ol>
    </nav><br>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header milinea">
                            <div class="titulox"><h4>Listado de Clientes</h4></div>
                            <div class="agregar"><a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClienteModal"><i class="fas fa-plus-circle"></i> Agregar Cliente</a></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Cliente</th>
                                            <th>Nombre de Fantasia</th>
                                            <th>Grupo</th>
                                            <th>Razón Social</th>
                                            <th>Tipo de Cliente</th>
                                            <th>Rut Empresa</th>
                                            <th>Región</th>
                                            <th>Comuna</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clientes as $cliente): ?>
                                        <tr>
                                            <td><?php echo $cliente['id_cliente']; ?></td>
                                            <td><?php echo $cliente['nombreCliente']; ?></td>
                                            <td><?php echo $cliente['nombreFantasia']; ?></td>
                                            <td><?php echo $cliente['grupo']; ?></td>
                                            <td><?php echo $cliente['razonSocial']; ?></td>
                                            <td><?php echo $tiposClienteMap[$cliente['id_tipoCliente']] ?? ''; ?></td>
                                            <td><?php echo $cliente['RUT']; ?></td>
                                            <td><?php echo $regionesMap[$cliente['id_region']] ?? ''; ?></td>
                                            <td><?php echo $comunasMap[$cliente['id_comuna']] ?? ''; ?></td>
                                            <td>
                                                <div class="alineado">
                                                    <label class="custom-switch sino" data-toggle="tooltip" 
                                                    title="<?php echo $cliente['estado'] ? 'Desactivar Cliente' : 'Activar Cliente'; ?>">
                                                        <input type="checkbox" 
                                                            class="custom-switch-input estado-switch"
                                                            data-id="<?php echo $cliente['id_cliente']; ?>" data-tipo="cliente" <?php echo $cliente['estado'] ? 'checked' : ''; ?>>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary micono" href="views/viewCliente.php?id_cliente=<?php echo $cliente['id_cliente']; ?>" data-toggle="tooltip" title="Ver Cliente"><i class="fas fa-eye "></i></a>
                                                <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizarcliente" data-idcliente="<?php echo $cliente['id_cliente']; ?>" onclick="loadClienteData(this)" ><i class="fas fa-pencil-alt"></i></button>
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

<!-- Modal para Agregar Cliente -->
<div class="modal fade" id="addClienteModal" tabindex="-1" aria-labelledby="addClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClienteModalLabel">Agregar Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClienteForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombreCliente" class="form-label">Nombre del Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nombreFantasia" class="form-label">Nombre de Fantasía</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                    <input type="text" class="form-control" id="nombreFantasia" name="nombreFantasia">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="id_tipoCliente" class="form-label">Tipo de Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                    <select class="form-select" id="id_tipoCliente" name="id_tipoCliente" required>
                                        <?php foreach ($tiposCliente as $tipo): ?>
                                            <option value="<?php echo $tipo['id_tyipoCliente']; ?>"><?php echo htmlspecialchars($tipo['nombreTipoCliente']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="razonSocial" class="form-label">Razón Social</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control" id="razonSocial" name="razonSocial" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="grupo" class="form-label">Grupo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    <input type="text" class="form-control" id="grupo" name="grupo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 input-wrapper">
                                <label for="RUT" class="form-label">RUT Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="RUT" name="RUT" required>
                                </div>
                                <div class="custom-tooltip" id="RUT-tooltip"></div>
                            </div>
                            <div class="mb-3">
                                <label for="giro" class="form-label">Giro</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" class="form-control" id="giro" name="giro" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nombreRepresentanteLegal" class="form-label">Nombre Representante Legal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control" id="nombreRepresentanteLegal" name="nombreRepresentanteLegal" required>
                                </div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="Rut_representante" class="form-label">RUT Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="Rut_representante" name="Rut_representante" required>
                                </div>
                                <div class="custom-tooltip" id="Rut_representante-tooltip"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="direccionEmpresa" class="form-label">Dirección Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" id="direccionEmpresa" name="direccionEmpresa" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="id_region" class="form-label">Región</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-map"></i></span>
                                    <select class="form-select" id="id_region" name="id_region" required>
                                        <?php foreach ($regiones as $region): ?>
                                            <option value="<?php echo $region['id']; ?>"><?php echo $region['nombreRegion']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="id_comuna" class="form-label">Comuna</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                    <select class="form-select" id="id_comuna" name="id_comuna" required>
                                        <?php foreach ($comunas as $comuna): ?>
                                            <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>"><?php echo $comuna['nombreComuna']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 input-wrapper">
                                <label for="telCelular" class="form-label">Teléfono Celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" class="form-control" id="telCelular" name="telCelular" required>
                                </div>
                                <div class="custom-tooltip" id="telCelular-tooltip"></div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="telFijo" class="form-label">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="telFijo" name="telFijo">
                                </div>
                                <div class="custom-tooltip" id="telFijo-tooltip"></div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control email-input" id="email" name="email" required>
                                </div>
                                <div class="custom-tooltip" id="email-tooltip"></div>
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="formato" class="form-label">Formato</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                    <select class="form-select" id="update_formato" name="formato">
                                        <?php foreach ($formatoComisionMap as $id => $comision): ?>
                                            <option value="<?php echo htmlspecialchars($id); ?>">
                                                <?php echo htmlspecialchars($comision['nombreFormato']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombreMoneda" class="form-label">Moneda</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                                    <select class="form-select" id="update_nombreMoneda" name="nombreMoneda">
                                        <?php foreach ($tipoMonedaMap as $id => $tipozMoneda): ?>
                                            <option value="<?php echo htmlspecialchars($id); ?>">
                                                <?php echo htmlspecialchars($tipozMoneda['nombreMoneda']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-cash"></i></span>
                                    <input type="number" class="form-control" id="valor" name="valor">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveClienteBtn">Guardar Cliente</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Actualizar Cliente -->
<div class="modal fade" id="actualizarcliente" tabindex="-1" aria-labelledby="actualizarclienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarclienteLabel">Actualizar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateClienteForm">
                    <input type="hidden" id="id_cliente" name="id_cliente">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="update_nombreCliente" class="form-label">Nombre del Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="update_nombreCliente" name="nombreCliente" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_nombreFantasia" class="form-label">Nombre de Fantasía</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                    <input type="text" class="form-control" id="update_nombreFantasia" name="nombreFantasia">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_id_tipoCliente" class="form-label">Tipo de Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                    <select class="form-select" id="update_id_tipoCliente" name="id_tipoCliente" required>
                                        <?php foreach ($tiposCliente as $tipo): ?>
                                            <option value="<?php echo $tipo['id_tyipoCliente']; ?>"><?php echo htmlspecialchars($tipo['nombreTipoCliente']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_razonSocial" class="form-label">Razón Social</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control" id="update_razonSocial" name="razonSocial" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_grupo" class="form-label">Grupo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    <input type="text" class="form-control" id="update_grupo" name="grupo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 input-wrapper">
                                <label for="update_RUT" class="form-label">RUT Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="update_RUT" name="RUT" required>
                                </div>
                                <div class="custom-tooltip" id="update_RUT-tooltip"></div>
                            </div>
                            <div class="mb-3">
                                <label for="update_giro" class="form-label">Giro</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" class="form-control" id="update_giro" name="giro" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_nombreRepresentanteLegal" class="form-label">Nombre Representante Legal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control" id="update_nombreRepresentanteLegal" name="nombreRepresentanteLegal" required>
                                </div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="update_Rut_representante" class="form-label">RUT Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="update_RUT_representante" name="RUT_representante" required>
                                </div>
                                <div class="custom-tooltip" id="update_RUT_representante-tooltip"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="update_direccionEmpresa" class="form-label">Dirección Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" id="update_direccionEmpresa" name="direccionEmpresa" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_id_region" class="form-label">Región</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-map"></i></span>
                                    <select class="form-select" id="update_id_region" name="id_region" required>
                                        <?php foreach ($regiones as $region): ?>
                                            <option value="<?php echo $region['id']; ?>"><?php echo $region['nombreRegion']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_id_comuna" class="form-label">Comuna</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                    <select class="form-select" id="update_id_comuna" name="id_comuna" required>
                                        <?php foreach ($comunas as $comuna): ?>
                                            <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>"><?php echo $comuna['nombreComuna']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 input-wrapper">
                                <label for="update_telCelular" class="form-label">Teléfono Celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" class="form-control" id="update_telCelular" name="telCelular" required>
                                </div>
                                <div class="custom-tooltip" id="update_telCelular-tooltip"></div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="update_telFijo" class="form-label">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="update_telFijo" name="telFijo">
                                </div>
                                <div class="custom-tooltip" id="update_telFijo-tooltip"></div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="update_email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="update_email" name="email" required>
                                </div>
                                <div class="custom-tooltip" id="update_email-tooltip"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="update_formato" class="form-label">Formato</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                    <select class="form-select" id="update_formato" name="formato">
                                        <?php foreach ($formatoComisionMap as $id => $comision): ?>
                                            <option value="<?php echo htmlspecialchars($id); ?>">
                                                <?php echo htmlspecialchars($comision['nombreFormato']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="update_nombreMoneda" class="form-label">Moneda</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                                    <select class="form-select" id="update_nombreMoneda" name="nombreMoneda">
                                        <?php foreach ($tipoMonedaMap as $id => $tipozMoneda): ?>
                                            <option value="<?php echo htmlspecialchars($id); ?>">
                                                <?php echo htmlspecialchars($tipozMoneda['nombreMoneda']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="update_valor" class="form-label">Valor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-cash"></i></span>
                                    <input type="number" class="form-control" id="update_valor" name="valor">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="updateClienteBtn">Actualizar Cliente</button>
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
        var phonePattern = /^(\+?56|0)?([2-9]\d{8}|[2-9]\d{7})$/;
        return phonePattern.test(phone);
    }

    var rutInputs = document.querySelectorAll('#RUT, #Rut_representante, #update_RUT, #update_RUT_representante');
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

    function validateEmail(input) {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (input.value === "") {
            hideError(input);
        } else if (!emailPattern.test(input.value)) {
            showError(input, "EMAIL INCORRECTO");
        } else {
            hideError(input);
        }
    }

    var emailInputs = document.querySelectorAll('.email-input, #update_email');
    emailInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            validateEmail(this);
        });
    });

    var phoneInputs = document.querySelectorAll('#telCelular, #telFijo, #update_telCelular, #update_telFijo');
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

    document.getElementById('saveClienteBtn').addEventListener('click', function() {
        if (validateForm()) {
            submitForm();
        } else {
            alert("Por favor, complete todos los campos correctamente antes de enviar.");
        }
    });

    function validateForm() {
        var inputs = document.querySelectorAll('#addClienteForm input, #addClienteForm select');
        var valid = true;
        
        inputs.forEach(function(input) {
            if (input.value === "") {
                input.classList.add("invalid");
                valid = false;
            } else {
                input.classList.remove("invalid");
            }
        });

        if (!Fn.validaRut(document.getElementById('RUT').value) ||
            !Fn.validaRut(document.getElementById('Rut_representante').value)) {
            valid = false;
        }

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(document.getElementById('email').value)) {
            valid = false;
        }

        return valid;
    }

    function submitForm() {
        var form = document.getElementById('addClienteForm');
        var formData = new FormData(form);

        fetch('querys/qinsert_cliente.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Cliente agregado exitosamente',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
                $('#addClienteModal').modal('hide');
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Error al agregar cliente: ' + data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al procesar la solicitud',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    document.getElementById('id_region').addEventListener('change', function () {
        var regionId = this.value;
        var comunaSelect = document.getElementById('id_comuna');
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

    document.getElementById('id_region').dispatchEvent(new Event('change'));

    var editButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#actualizarcliente"]');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            loadClienteData(this);
        });
    });

    var updateClienteBtn = document.getElementById('updateClienteBtn');
    if (updateClienteBtn) {
        updateClienteBtn.addEventListener('click', updateCliente);
    } else {
        console.error('Botón de actualizar cliente no encontrado');
    }

    function showLoading() {
        let loadingElement = document.getElementById('custom-loading');
        if (!loadingElement) {
            loadingElement = document.createElement('div');
            loadingElement.id = 'custom-loading';
            loadingElement.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); display: flex; justify-content: center; align-items: center; z-index: 9999;">
                    <img src="/assets/img/loading.gif" alt="Cargando..." style="width: 220px; height: 135px;">
                </div>
            `;
            document.body.appendChild(loadingElement);
        }
        loadingElement.style.display = 'block';
    }

    function hideLoading() {
        const loadingElement = document.getElementById('custom-loading');
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
    }

    function loadClienteData(button) {
        const id_cliente = button.getAttribute('data-idcliente');
        console.log('ID del cliente obtenido del botón:', id_cliente);

        if (!id_cliente) {
            console.error('Error: No se pudo obtener el ID del cliente del botón');
            Swal.fire({
                title: 'Error',
                text: 'No se pudo obtener el ID del cliente',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        document.getElementById('id_cliente').value = id_cliente;
        console.log('ID del cliente establecido en el formulario:', document.getElementById('id_cliente').value);

        fetch('querys/qget_cliente.php?id_cliente=' + id_cliente)
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const cliente = data.cliente;
                    console.log('Datos del cliente recibidos:', cliente);
                    
                    const campos = [
                        'nombreCliente', 'nombreFantasia', 'id_tipoCliente',
                        'razonSocial', 'grupo', 'RUT', 'giro', 'nombreRepresentanteLegal',
                        'direccionEmpresa', 'id_region', 'telCelular',
                        'telFijo', 'email', 'formato', 'nombreMoneda', 'valor',
                        'RUT_representante'
                    ];

                    campos.forEach(campo => {
                        const valor = cliente[campo] || cliente[campo.toUpperCase()] || '';
                        setValueSafely('update_' + campo, valor);
                        console.log(`Campo ${campo} establecido:`, valor);
                    });

                    const regionSelect = document.getElementById('update_id_region');
                    if (regionSelect) {
                        regionSelect.dispatchEvent(new Event('change'));
                    
                        setTimeout(() => {
                            const idComuna = cliente.id_comuna || cliente.ID_COMUNA || '';
                            setValueSafely('update_id_comuna', idComuna);
                            console.log('ID Comuna establecido:', idComuna);
                        }, 100);
                    }

                    updateSelectField('update_id_tipoCliente', cliente.id_tipoCliente || cliente.ID_TIPOCLIENTE);
                    updateSelectField('update_id_region', cliente.id_region || cliente.ID_REGION);

                    console.log('Datos del cliente cargados correctamente');
                } else {
                    throw new Error(data.error || 'Error desconocido al cargar los datos del cliente');
                }
            })
            .catch(error => {
                console.error('Error en loadClienteData:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al cargar los datos del cliente: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    }

    function setValueSafely(id, value) {
        const element = document.getElementById(id);
        if (element) {
            element.value = value !== undefined && value !== null ? value : '';
            console.log(`Valor establecido para ${id}:`, element.value);
            element.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
            console.warn(`Elemento no encontrado: ${id}`);
        }
    }

    function updateSelectField(id, value) {
        var select = document.getElementById(id);
        if (select && select.tagName === 'SELECT') {
            var option = select.querySelector(`option[value="${value}"]`);
            if (option) {
                option.selected = true;
                console.log(`Opción seleccionada para ${id}:`, value);
                select.dispatchEvent(new Event('change', { bubbles: true }));
            } else {
                console.warn(`Opción no encontrada para ${id} con valor ${value}`);
            }
        } else {
            console.warn(`Elemento select no encontrado: ${id}`);
        }
    }

    function updateCliente() {
        console.log('Función updateCliente iniciada');
        var form = document.getElementById('updateClienteForm');
        var formData = new FormData(form);

        var idCliente = document.getElementById('id_cliente').value;
        formData.append('id_cliente', idCliente);

        console.log('ID Cliente:', formData.get('id_cliente'));

        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        fetch('querys/qupdate_cliente.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Respuesta del servidor recibida');
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error('HTTP error ' + response.status + ': ' + text);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos de respuesta:', data);
            if (data.success) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('actualizarcliente'));
                modal.hide();

                Swal.fire({
                    title: data.alert.title,
                    text: data.alert.text,
                    icon: data.alert.icon,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading(); // Mostrar el indicador de carga personalizado
                        window.location.reload();
                    }
                });
            } else {
                throw new Error(data.error || 'Error desconocido al actualizar el cliente');
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al actualizar el cliente: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    window.addEventListener('load', hideLoading);
});
</script>

<?php include 'componentes/settings.php'; ?>
<script src="assets/js/toggleClientes.js"></script>
<script src="assets/js/deleteCliente.js"></script>
<?php include 'componentes/footer.php'; ?>