<?php
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

// Obtener datos+
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');
$proveedores= makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?select=*');
$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');
$pagos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/FormaDePago?select=*');
$tipoP = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoDePublicidad?select=*');
$anios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');
$meses = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Meses?select=*');
$tipoGeracionOrden = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoGeneracionDeOrden?select=*');





$contratosMap = [];
foreach ($contratos as $contrato) {
    $contratosMap[$contrato['id']] = $contrato;
}
$clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente;
}

$productosMap = [];
foreach ($productos as $producto) {
    $productosMap[$producto['Id_Cliente']][] = $producto;
}
$proveedorMap = [];
foreach ($proveedores as $proveedor) {
    $proveedorMap[$proveedor['id_proveedor']] = $proveedor;
}
$mediosMap = [];
foreach ($medios as $medio) {
    $mediosMap[$medio['id']] = $medio;
}
$pagosMap = [];
foreach ($pagos as $pago) {
    $pagosMap[$pago['id']] = $pago;
}
$tipoPMap = [];
foreach ($tipoP as $tipo) {
    $tipoPMap[$tipo['id_Tipo_Publicidad']] = $tipo;
}
$aniosMap = [];
foreach ($anios as $anio) {
    $aniosMap[$anio['id']] = $anio;
}
$mesesMap = [];
foreach ($meses as $mes) {
    $mesesMap[$mes['Id']] = $mes;
}

$ordenMap = [];
foreach ($tipoGeracionOrden as $orden) {
    $ordenMap[$orden['id']] = $orden;
}


?>