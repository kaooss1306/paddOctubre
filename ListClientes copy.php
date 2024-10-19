<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qclientes.php';

include 'componentes/header.php';
include 'componentes/sidebar.php';
?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Clientes</h4>
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
                                            <th>Region</th>
                                            <th>Comuna</th>
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
                                            <td><a href="#" class="btn btn-primary">Detail</a></td>
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
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>