<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qclientes.php';

include 'componentes/header.php';
include 'componentes/sidebar.php';
?>
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
                            <div class="agregar"><a class="btn btn-primary" href="addCliente.php"><i class="fas fa-plus-circle"></i> Agregar Cliente</a></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
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
           data-id="<?php echo $cliente['id_cliente']; ?>"
           <?php echo $cliente['estado'] ? 'checked' : ''; ?>>
    <span class="custom-switch-indicator"></span>
</label>
    </div>
                                            </td>
                                            <td>
                                                <a href="views/viewCliente.php?id_cliente=<?php echo $cliente['id_cliente']; ?>" data-toggle="tooltip" title="Ver Cliente"><i class="fas fa-eye btn btn-primary micono"></i></a>
                                                <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizarcliente" data-idcliente="<?php echo $cliente['id_cliente']; ?>" onclick="loadClienteData(this)" ><i class="fas fa-pencil-alt"></i></button>
                                                <a href="#" class="btn btn-danger micono delete-client" data-id="<?php echo $cliente['id_cliente']; ?>" data-toggle="tooltip" title="Eliminar Cliente"><i class="fas fa-trash-alt"></i></a>
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

<div class="modal fade" id="actualizarcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí va el contenido del formulario del modal -->
                <form id="formularioactualizarcliente">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Actualizar Cliente:</h3>
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" name="id_cliente">
                                <p><input class="form-control" placeholder="Nombre de cliente" name="nombreCliente"></p>
                                <p><input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia"></p>
                                <select class="form-select mb-3" name="id_tipoCliente" id="tipocliente">
                                    <?php foreach ($tipoclientesMap as $id => $tipocliente) : ?>
                                        <option value="<?php echo $id; ?>" <?php echo isset($cliente['id_tipoCliente']) && $id == $cliente['id_tipoCliente'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($tipocliente['nombreTipoCliente']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p><input class="form-control" placeholder="Razón Social" name="razonSocial"></p>
                                <p><input class="form-control" placeholder="Grupo" name="grupo"></p>
                            </div>
                            <div class="col-6">
                                <p><input class="form-control" placeholder="Rut Empresa" name="RUT_info"></p>
                                <p><input class="form-control" placeholder="Giro" name="giro"></p>
                                <p><input class="form-control" placeholder="Nombre representante legal" name="nombreRepresentanteLegal"></p>
                                <p><input class="form-control" placeholder="Rut Representante" name="Rut_representante"></p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                            <div class="col-6">
                                <p><input class="form-control" placeholder="Dirección" name="direccionEmpresa"></p>
                                <select class="form-select mb-3" name="id_region" id="region">
                                    <?php foreach ($regiones as $regione) : ?>
                                        <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-select mb-3" name="id_comuna" id="comuna">
                                    <?php foreach ($comunas as $comuna) : ?>
                                        <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>"><?php echo $comuna['nombreComuna']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                
                            </div>
                            <div class="col-6">
                                <p><input class="form-control" placeholder="Teléfono fijo" name="telFijo"></p>
                                <p><input class="form-control" placeholder="Teléfono celular" name="telCelular"></p>
                                <p><input class="form-control" placeholder="Email" name="email"></p>
                            </div>
                        </div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>
                        <div class="row">
    <div class="col">
        <p>
            <select class="form-select mb-3" name="formato" id="formato">
                <option value="">Seleccionar Formato</option>
                <option value="Fee">Fee</option>
                <option value="% Comisión Offline">% Comisión Offline</option>
                <option value="% Comisión Online">% Comisión Online</option>
            </select>
        </p>
    </div>
    <div class="col" id="moneda-container">
        <p>
            <select class="form-select mb-3" name="nombreMoneda" id="nombreMoneda">
                <option value="UF">UF</option>
                <option value="Peso">Peso</option>
                <option value="Dólar">Dólar</option>
            </select>
        </p>
    </div>
    <div class="col">
        <p>
            <input class="form-control" placeholder="Valor" name="valor" id="valor">
        </p>
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


<!-- Mueve el script aquí, justo antes del cierre de la etiqueta body -->
 
<script>
    function loadClienteData(button) {
        var idCliente = button.getAttribute('data-idcliente');
        var cliente = getClienteData(idCliente);

        if (cliente) {
            console.log('Datos del cliente:', cliente);
            document.querySelector('input[name="id_cliente"]').value = cliente.id_cliente;
            document.querySelector('input[name="nombreCliente"]').value = cliente.nombreCliente;
            document.querySelector('input[name="nombreFantasia"]').value = cliente.nombreFantasia;
            document.querySelector('select[name="id_tipoCliente"]').value = cliente.id_tipoCliente;
            document.querySelector('input[name="razonSocial"]').value = cliente.razonSocial;
            document.querySelector('input[name="grupo"]').value = cliente.grupo;
            document.querySelector('input[name="RUT_info"]').value = cliente.RUT;
            document.querySelector('input[name="giro"]').value = cliente.giro;
            document.querySelector('input[name="nombreRepresentanteLegal"]').value = cliente.nombreRepresentanteLegal;
            document.querySelector('input[name="Rut_representante"]').value = cliente.RUT_representante;
            document.querySelector('input[name="direccionEmpresa"]').value = cliente.direccionEmpresa;
            document.querySelector('select[name="id_region"]').value = cliente.id_region;
            document.querySelector('select[name="id_comuna"]').value = cliente.id_comuna;
            document.querySelector('input[name="telCelular"]').value = cliente.telCelular;
            document.querySelector('input[name="telFijo"]').value = cliente.telFijo;
            document.querySelector('input[name="email"]').value = cliente.email;
            document.querySelector('input[name="formato"]').value = cliente.formato;
            document.querySelector('input[name="nombreMoneda"]').value = cliente.nombreMoneda;
            document.querySelector('input[name="valor"]').value = cliente.valor;

        } else {
            console.log("No se encontró el cliente con ID:", idCliente);
        }
    }

    function getClienteData(idCliente) {
        var clientesMap = <?php echo json_encode($clientesMap); ?>;
        return clientesMap[idCliente] || null;
    }

    document.getElementById('region').addEventListener('change', function () {
        var regionId = this.value;
        var comunaSelect = document.getElementById('comuna');
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

    document.getElementById('region').dispatchEvent(new Event('change'));

</script>
<script src="<?php echo $ruta; ?>assets/js/actualizarcliente.js"></script>

<?php include 'componentes/settings.php'; ?>
<script src="assets/js/toggleClientes.js"></script>
<script src="assets/js/deleteCliente.js"></script>
<?php include 'componentes/footer.php'; ?>