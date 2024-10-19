<?php
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
$ordenes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDeCompra?select=*');

$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');

$temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Temas?select=*');

$soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');

$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');

$proveedores = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?select=*');

$clasificaciones= makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clasificacion?select=*');

$planesMap = [];
foreach ($planes as $plane) {
    $planesMap[$plane['id_planes_publicidad']] = $plane;
}

$temasMap = [];
foreach ($temas as $tema) {
    $temasMap[$tema['id_tema']] = $tema;
}

$soportesMap = [];
foreach ($soportes as $soporte) {
    $soportesMap[$soporte['id_soporte']] = $soporte;
}

$contratosMap = [];
foreach ($contratos as $contrato) {
    $contratosMap[$contrato['id']] = $contrato;
}
$proveedoresMap =[];
foreach ($proveedores as $proveedor) {
    $proveedoresMap[$proveedor['id_proveedor']] = $proveedor;
}

$clasificacionesMap = [];
foreach ($clasificaciones as $clasificacion) {
        $clasificacionesMap[$clasificacion['id']] = $clasificacion;
}