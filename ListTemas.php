<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qtema.php';

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
                            <h4>Listado de Temas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Tema</th>
                                            <th>Duración</th>
                                            <th>Codigo Mega Time</th>
                                            <th>Calidad</th>
                                            <th>Cooperado</th>
                                            <th>Rubro</th>
                                            <th>Campaña</th>
                                            <th>Medio</th>
                                            <th>Color</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($temas as $tema): ?>
                                        <tr>
                                            <td><?php echo $tema['id_tema']; ?></td>
                                            <td><?php echo $tema['NombreTema']; ?></td>
                                            <td><?php echo $tema['Duracion']; ?></td>
                                            <td><?php echo $tema['CodigoMegatime']; ?></td>
                                            <td><?php echo $calidadsMap[$tema['id_Calidad']]['NombreCalidad'] ?? ''; ?></td>
                                            <td><?php echo $coperadosMap[$tema['id_Cooperado']]['NombreCooperado'] ?? ''; ?></td>
                                            <td><?php echo $rubrosMap[$tema['id_Rubro']]['NombreRubro'] ?? ''; ?></td>
                                            <td><?php echo $campaignsMap[$tema['Id_campana']]['NombreCampania'] ?? ''; ?></td>
                                            <td><?php echo $mediosMap[$tema['id_medio']]['NombredelMedio'] ?? ''; ?></td>
                                            <td><?php echo $tema['color']; ?></td>
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