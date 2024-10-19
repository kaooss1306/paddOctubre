<div class="modal fade" id="agregarsoporteprov" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>
                
                <!-- Campo para mostrar el id_proveedor -->
                <input type="hidden" class="form-control" placeholder="Prueba de id " name="pruebaid" id="pruebaid">
                
                <form id="formagregarsoporte2">
                    <div class="form-group">
                        <label for="soporteSelect">Selecciona un Soporte</label>
                        <select class="form-control" id="soporteSelect" name="id_soporte">
                            <!-- Opciones se llenarán dinámicamente -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Soporte</button>
                </form>
            </div>
        </div>
    </div>
</div>