<?php
// Iniciar sesión
session_start();

include 'querys/qcontratos.php';
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>
<!-- Main Content -->
      <div class="main-content">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Contratos</li>
        </ol>
    </nav><br>
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header milinea">
                            <div class="titulox"><h4>Listado de Contratos</h4></div>
                            <div class="agregar">
                            <a href="#" 
       class="btn btn-primary open-modal" 
       data-bs-toggle="modal" 
       data-bs-target="#modalAddContrato">
        <i class="fas fa-plus-circle"></i> Agregar Contrato
    </a>
                            </div>
                        </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="tableExportadora">
                        <thead>
                          <tr>
                            <th>
                              ID
                            </th>
                            <th>Nombre Contrato</th>
                            <th>Nombre Cliente</th>
                            <th>Producto</th>
                            <th>Proveedor</th>
                            <th>Medio</th>
                            <th>Forma de Pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contratos as $contrato): 
                        $nombreCliente = isset($clientesMap[$contrato['IdCliente']]) ? $clientesMap[$contrato['IdCliente']]['nombreCliente'] : 'N/A';
                        $nombreProducto = 'N/A';
                        if (isset($productosMap[$contrato['IdCliente']]) && !empty($productosMap[$contrato['IdCliente']])) {
                            $nombreProducto = $productosMap[$contrato['IdCliente']][0]['NombreDelProducto'];
                        }
                        $nombreProvee = isset($proveedorMap[$contrato['IdProveedor']]) ? $proveedorMap[$contrato['IdProveedor']]['nombreProveedor'] : 'N/A';
                        $nombreMedio = isset($mediosMap[$contrato['IdMedios']]) ? $mediosMap[$contrato['IdMedios']]['NombredelMedio'] : 'N/A';
                        $pagoForma = isset($pagosMap[$contrato['id_FormadePago']]) ? $pagosMap[$contrato['id_FormadePago']]['NombreFormadePago'] : 'N/A';
                        ?>
                        <tr>
    <td><?php echo $contrato['id']; ?></td>
    <td><?php echo $contrato['NombreContrato']; ?></td>
    <td><?php echo $nombreCliente; ?></td>
    <td><?php echo $nombreProducto; ?></td>
    <td><?php echo $nombreProvee; ?></td>
    <td><?php echo $nombreMedio; ?></td>
    <td><?php echo $pagoForma; ?></td>
    <td><div class="alineado">
       <label class="custom-switch sino" data-toggle="tooltip" 
       title="<?php echo $contrato['Estado'] ? 'Desactivar Contrato' : 'Activar Contrato'; ?>">
    <input type="checkbox" 
           class="custom-switch-input estado-switchC"
           data-id="<?php echo $contrato['id']; ?>" data-tipo="contrato" <?php echo $contrato['Estado'] ? 'checked' : ''; ?>> <span class="custom-switch-indicator"></span>
</label>
    </div></td>
    <td>
      <a class="btn btn-primary micono" href="views/viewContrato.php?id=<?php echo $contrato['id']; ?>" data-toggle="tooltip" title="Ver Contrato"><i class="fas fa-eye "></i></a>
      <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizarcontrato" data-idcontrato="<?php echo $contrato['id']; ?>"><i class="fas fa-pencil-alt"></i></button>


                                            

                                        
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

<script src="assets/js/toggleContratos.js"></script>
      <?php include 'componentes/settings.php'; ?>
      <?php include 'querys/modulos/modalAddContrato.php'; ?>
      <?php include 'componentes/footer.php'; ?>
      