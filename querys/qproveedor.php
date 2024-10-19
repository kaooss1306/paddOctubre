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
$contactos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/contactos?select=*');
$provedor_soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_soporte?select=*');
$proveedor_medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_medios?select=*');
$soporte_medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/soporte_medios?select=*');
$proveedores = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?select=*');
$soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
$soportecounts = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
$regiones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Region?select=*');
$comunas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comunas?select=*');
$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');
// Debug: Imprimir los datos de proveedores para verificar la estructura
// var_dump($proveedores);
$proveedorCountMapSoport = [];

foreach ($provedor_soportes as $item) {
    $id_proveedor = $item['id_proveedor'];
    if (!isset($proveedorCountMapSoport[$id_proveedor])) {
        $proveedorCountMapSoport[$id_proveedor] = 0; // Inicializa el contador para este id_proveedor
    }
    $proveedorCountMapSoport[$id_proveedor]++; // Incrementa el contador
}
$proveedoresMap = [];
foreach ($proveedores as $proveedore) {
    $proveedoresMap[$proveedore['id_proveedor']] = $proveedore;
}
$soportesMap = [];
foreach ($soportes as $soporte) {
    $soportesMap[$soporte['id_soporte']] = $soporte;
}

$clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente;    
}


$soportecountsmaps = [];
foreach ($soportecounts as $soportecount) {
    $id_soporte = $soportecount['id_soporte'];

    if (isset($soportecountsmaps[$id_soporte])) {
        $soportecountmaps[$id_soporte]['count']++;
    } else {
        $campaign['count'] = 1;
        $soportecountsmaps[$id_soporte] = $soportecount;
    }
}

$regionesMap = array_column($regiones, 'nombreRegion', 'id');
$comunasMap = array_column($comunas, 'nombreComuna', 'id_comuna');




