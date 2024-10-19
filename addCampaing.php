<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}



// Incluir el header y la barra lateral
include 'querys/qagregarcampaign.php';
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Agregar Nueva Campaña</h4>
                        
                        </div>
                        <div class="card-body">
                            <?php if ($message): ?>
                                <div class="alert alert-info"><?php echo $message; ?></div>
                            <?php endif; ?>
                            <?php if ($debug_info): ?>
                                <pre><?php echo htmlspecialchars($debug_info); ?></pre>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label>Nombre Cliente</label>
                                    <input type="text" class="form-control" name="nombreCliente" required>
                                </div>
                                <div class="form-group">
                                    <label>Clientes</label>
                                    <select class="form-control" name="cliente">
                                        <?php foreach ($clientesMap as $idCliente => $cliente) : ?>
                                            <option value="<?php echo $idCliente; ?>"><?php echo $cliente['nombreCliente']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Grupo</label>
                                    <input type="text" class="form-control" name="grupo">
                                    <td><?php echo $clientesMap[$campania['id_Cliente']]['nombreCliente'] ?? ''; ?></td>
                                </div>
                                <div class="form-group">
                                    <label>Razón Social</label>
                                    <input type="text" class="form-control" name="razonSocial" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de Cliente</label>
                                    <select class="form-control" name="tipoCliente">
                                        <?php foreach ($tiposCliente as $id => $nombre): ?>
                                            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($nombre); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de Facturación</label>
                                    <select class="form-control" name="tipoFacturacion">
                                        <?php if (empty($tiposFacturacion)): ?>
                                            <option value="">No se encontraron tipos de facturación</option>
                                        <?php else: ?>
                                            <?php foreach ($tiposFacturacion as $id => $tipo): ?>
                                                <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($tipo); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>RUT Empresa</label>
                                    <input type="text" class="form-control" name="rutEmpresa" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar Cliente</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'componentes/footer.php'; ?>