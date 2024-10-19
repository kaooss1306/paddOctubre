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
$campaigns = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');
$contadorcampaigns = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$regiones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Region?select=*');
$comunas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comunas?select=*');
$contadorcontratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$agencias = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Agencias?select=*');
$tipoclientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoCliente?select=*');
$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');
// Debug: Imprimir los datos de proveedores para verificar la estructura
// var_dump($proveedores);

$contadorcampaignsmaps = [];
foreach ($contadorcampaigns as $campaign) {
    $id_campania = $campaign['id_campania'];

    if (isset($contadorcampaignsmaps[$id_campania])) {
        $contadorcampaignsmaps[$id_campania]['count']++;
    } else {
        $campaign['count'] = 1;
        $contadorcampaignsmaps[$id_campania] = $campaign;
    }
}
$campaignMap2 = [];
foreach ($campaigns as $campaign) {
    $campaignMap[$campaign['id_campania']] = $campaign;
}


$contadorcontratosmaps = [];
foreach ($contadorcontratos as $contrato) {
    $id_campania = $contrato['id'];

    if (isset($contadorcontratosmaps[$id_campania])) {
        $contadorcontratosmaps[$id_campania]['count']++;
    } else {
        $contrato['count'] = 1;
        $contadorcontratosmaps[$id_campania] = $contrato;
    }
}

$regionesMap = [];
foreach ($regiones as $region) {
    $regionesMap[$region['id']] = $region['nombreRegion'];
}

$comunasMap = [];
foreach ($comunas as $comuna) {
    $comunasMap[$comuna['id_comuna']] = $comuna['nombreComuna'];
}

$clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente;
}
$contratosMap = [];
foreach ($contratos as $contrato) {
    $contratosMap[$contrato['id']] = $contrato;
}
$agenciasMap = [];
foreach ($agencias as $agencia) {
    $agenciasMap[$agencia['id']] = $agencia;
}
$tipoclientesMap = [];
foreach ($tipoclientes as $tipocliente) {
    $tipoclientesMap[$tipocliente['id_tyipoCliente']] = $tipocliente;
}
$planesMap = [];
foreach ($planes as $plane) {
    $planesMap[$plane['id_planes_publicidad']] = $plane;
}