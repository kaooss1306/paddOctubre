
<!-- Modal para agregar un nuevo contrato -->
<div class="modal fade" id="modalAddContrato" tabindex="-1" aria-labelledby="modalAddContratoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddContratoLabel">Agregar Contrato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-add-contrato">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nombreContrato" class="form-label">Nombre del Contrato</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                <input type="text" class="form-control" id="NombreContrato" name="NombreContrato" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="idCliente" class="form-label">Seleccione un Cliente</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <select class="form-select" id="IdCliente" name="IdCliente" required>
                 
                  <?php foreach ($clientesMap as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombreCliente']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
          <div class="col-md-6 mb-3">
  <label for="idProducto" class="form-label">Seleccione un Producto</label>
  <div class="input-group">
    <span class="input-group-text"><i class="bi bi-box"></i></span>
    <select class="form-select" id="idProducto" name="idProducto" required>
      <option value="">Seleccione un producto</option>
    </select>
  </div>
</div>
            <div class="col-md-6 mb-3">
              <label for="idProveedor" class="form-label">Seleccione un Proveedor</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-truck"></i></span>
                <select class="form-select" id="IdProveedor" name="IdProveedor" required>
                  <?php foreach ($proveedorMap as $proveedor): ?>
                    <option value="<?php echo $proveedor['id_proveedor']; ?>"><?php echo $proveedor['nombreProveedor']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="idMedio" class="form-label">Seleccione un Medio</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-broadcast"></i></span>
                <select class="form-select" id="IdMedios" name="IdMedios" required>
                  <?php foreach ($mediosMap as $medio): ?>
                    <option value="<?php echo $medio['id']; ?>"><?php echo $medio['NombredelMedio']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="idFormaDePago" class="form-label">Seleccione una Forma de Pago</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                <select class="form-select" id="idFormaDePago" name="id_FormadePago" required>
                  <?php foreach ($pagosMap as $pago): ?>
                    <option value="<?php echo $pago['id']; ?>"><?php echo $pago['NombreFormadePago']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col-md-6 mb-3">
              <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <input type="date" class="form-control" id="FechaInicio" name="FechaInicio" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="FechaTermino" class="form-label">Fecha de Término</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <input type="date" class="form-control" id="FechaTermino" name="FechaTermino" required>
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col-md-6 mb-3">
              <label for="FechaInicio" class="form-label">Mes</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <select class="form-select" id="id_Mes" name="id_Mes" required>
    <?php foreach ($mesesMap as $id => $mes): ?>
        <option value="<?php echo $id; ?>"><?php echo $mes['Nombre']; ?></option>
    <?php endforeach; ?>
</select>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="FechaTermino" class="form-label">Año</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <select class="form-select" id="id_Anio" name="id_Anio" required>
    <?php foreach ($aniosMap as $id => $anio): ?>
        <option value="<?php echo $id; ?>"><?php echo $anio['years']; ?></option>
    <?php endforeach; ?>
</select>
              </div>
            </div>
          </div>
          <div class="row otros">
            <div class="col-md-4 mb-3">
              <label for="estado" class="form-label">Tipo de Publicidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                <select class="form-select" id="IdTipoDePublicidad" name="IdTipoDePublicidad" required>
    <?php foreach ($tipoPMap as $tipo): ?>
        <option value="<?php echo $tipo['id_Tipo_Publicidad']; ?>"><?php echo $tipo['NombreTipoPublicidad']; ?></option>
    <?php endforeach; ?>
</select>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="estado" class="form-label">Forma de Pago</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                <select class="form-select" id="id_FormadePago" name="id_FormadePago" required>
    <?php foreach ($pagosMap as $pago): ?>
        <option value="<?php echo $pago['id']; ?>"><?php echo $pago['NombreFormadePago']; ?></option>
    <?php endforeach; ?>
</select>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="estado" class="form-label">Tipo de Orden</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-aspect-ratio"></i></span>
                <select class="form-select" id="id_GeneraracionOrdenTipo" name="id_GeneraracionOrdenTipo" required>
    <?php foreach ($ordenMap as $orden): ?>
        <option value="<?php echo $orden['id']; ?>"><?php echo $orden['NombreTipoOrden']; ?></option>
    <?php endforeach; ?>
</select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Valor Neto</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="form-control" id="ValorNeto" name="ValorNeto" required>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Valor Bruto</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="form-control" id="ValorBruto" name="ValorBruto" required>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Descuento</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="form-control" id="Descuento1" name="Descuento1" required>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Valor Total</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="form-control" id="ValorTotal" name="ValorTotal" required>
              </div>
            </div>
          </div>
          <div class="row">
          <div class="col-md-12 mb-3">
              <label for="estado" class="form-label">Observaciones</label>
              <div class="input-group">
                <textarea class="form-control" id="Observaciones" name="Observaciones" rows="4" cols="50" placeholder="Escribe las Observaciones..."></textarea>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Estado del Contrato</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                <select class="form-select" id="estado" name="Estado" required>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="num_contrato" class="form-label">Número del Contrato</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-journal"></i></span>
                <input type="number" class="form-control" id="num_contrato" name="num_contrato" readonly>
              </div>
            </div>
          </div>
       
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn-add-contrato">Agregar Contrato</button>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/addContrato.js"></script>