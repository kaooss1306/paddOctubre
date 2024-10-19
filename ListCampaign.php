<?php
// Iniciar la sesión
session_start();




include 'querys/qcampaign.php';
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>

<?php
$absolutePath = dirname(__FILE__);
echo $absolutePath;
?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Campañas</h4>
                                <a href="addCampaing.php">Agregar una campaña</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tablaExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente </th>
                                            <th>Nombre de camapaña</th>
                                            <th>Producto</th>
                                            <th>Año</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($campaign as $campania): ?>
                                        <tr>
                                            <td><?php echo $campania['id_campania']; ?></td>
                                            <td><?php echo $clientesMap[$campania['id_Cliente']]['nombreCliente'] ?? ''; ?></td>
                                            <td><?php echo $campania['NombreCampania']; ?></td>
                                            <td><?php echo $productosMap[$campania['id_Producto']]['NombreDelProducto'] ?? ''; ?></td>
                                            <td><?php echo $aniosMap[$campania['Anio']]['years'] ?? ''; ?></td>
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