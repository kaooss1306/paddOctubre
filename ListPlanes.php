<?php
// Iniciar la sesión
session_start();


// Función para hacer peticiones cURL
  // Función para hacer peticiones cURL
  function makeRequest($url) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// Obtener datos
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');
$meses = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Meses?select=*');
$anos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');



$mesesMap = [];
foreach ($meses as $mes) {
    $mesesMap[$mes['Id']] = $mes;
}
$anosMap = [];
foreach ($anos as $anio) {
    $anosMap[$anio['id']] = $anio;
}
$clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente;
}
$contratosMap = [];
foreach ($contratos as $contract) {
    $contratosMap[$contract['id']] = $contract;
}

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
                            <h4>Listado de Planes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Contrato</th>
                                            <th>Cliente</th>
                                            <th>Nombre plan</th>
                                            <th>Mes</th>
                                            <th>Año</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php foreach ($planes as $plan): ?>
<tr>
    <td><?php echo $plan['id_planes_publicidad']; ?></td>
    <td><?php echo isset($contratosMap[$plan['id_contrato']]) ? $contratosMap[$plan['id_contrato']]['NombreContrato'] : 'N/A'; ?></td>
    <td><?php echo isset($contratosMap[$plan['id_contrato']]) ? $clientesMap[$plan['id_contrato']]['nombreCliente'] : 'N/A'; ?></td>
    <td><?php echo $plan['NombrePlan']; ?></td>
    <td><?php echo isset($mesesMap[$plan['id_Mes']]) ? $mesesMap[$plan['id_Mes']]['Nombre'] : 'N/A'; ?></td>
    <td><?php echo isset($anosMap[$plan['id_Anio']]) ? $anosMap[$plan['id_Anio']]['years'] : 'N/A'; ?></td>
    <td>
    <div class="alineado">
    <label class="custom-switch mt-2" data-toggle="tooltip" 
           title="<?php echo $plan['estado'] == 1 ? 'Desactivar plan' : 'Activar plan'; ?>">
        <input type="checkbox" name="custom-switch-checkbox-<?php echo $plan['id_planes_publicidad']; ?>" 
               class="custom-switch-input estado-switch" 
               data-id="<?php echo $plan['id_planes_publicidad']; ?>"
               data-tipo="plan"
               <?php echo $plan['estado'] == 1 ? 'checked' : ''; ?>>
        <span class="custom-switch-indicator"></span>
    </label>
</div>
</td>
<td><a href="#" data-toggle="tooltip" title="Ver Cliente"><i class="fas fa-eye btn btn-primary micono"></i></a> <a href="#" data-toggle="tooltip" title="Editar Cliente"><i class="fas fa-pencil-alt btn btn-success micono"></i></a> <a href="#" data-toggle="tooltip" title="Eliminar Cliente"><i class="fas fa-trash-alt btn btn-danger micono"></i></a></td>
                                       
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