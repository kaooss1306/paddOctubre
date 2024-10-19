<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qordenes.php';

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
                            <h4>Listado de Ordenes De Compra</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Copia</th>
                                            <th>N° Contrato </th>
                                            <th>Proveedor</th>
                                            <th>Cod Megatime</th>
                                            <th>Tema</th>
                                            <th>Soporte</th>
                                            <th>Clasificación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ordenes as $orden): ?>
                                        <tr>
                                            <td><?php echo $orden['id_ordenes_de_comprar']; ?></td>
                                            <td><?php echo "copia" ?></td>
                                            <td>
                                                <?php
                                                 foreach ($contratos as $contrato) {
                                                     if ($planesMap[$orden['id_planes']]['id_contrato'] == $contrato['id']) {
                                                         echo $contrato['num_contrato'];
                                                     }
                                                 }
                                              
                                                ?>
                                            </td>
                                            <td><?php echo $proveedoresMap[$orden['id_proveedor']]['nombreProveedor'] ?? ''; ?></td>
                                            <td><?php echo $orden['Codigo']; ?></td>
                                          
                                            <td><?php echo $temasMap[$orden['id_tema']]['NombreTema'] ?? ''; ?></td>
                                            <td><?php echo $soportesMap[$orden['id_soporte']]['nombre_soporte'] ?? ''; ?></td>
                                            <td><?php echo $clasificacionesMap[$orden['id_clasificacion']]['NombreClasificacion'] ?? ''; ?></td>
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