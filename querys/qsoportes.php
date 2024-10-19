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
$soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
$proveedores = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?select=*');

$regiones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Region?select=*');
$comunas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comunas?select=*');

$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');

$soportes_medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/soporte_medios?select=*');


// Debug: Imprimir los datos de proveedores para verificar la estructura
// var_dump($proveedores);

// Crear un mapa completo de proveedores
$proveedoresMap = [];
foreach ($proveedores as $proveedor) {
    $proveedoresMap[$proveedor['id_proveedor']] = $proveedor;
}

$soportesMap = [];
foreach ($soportes as $soporte) {
    $soportesMap[$soporte['id_soporte']] = $soporte;
}

$regionesMap = array_column($regiones, 'nombreRegion', 'id');
$comunasMap = array_column($comunas, 'nombreComuna', 'id_comuna');