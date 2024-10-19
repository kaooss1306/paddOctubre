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
$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');
$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');
$rubros = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Rubro?select=*');
$calidads = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Calidad?select=*');
$coperados = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Cooperado?select=*');
$temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Temas?select=*');

$calidadsMap = [];
foreach ($calidads as $calidad) {
    $calidadsMap[$calidad['id']] = $calidad;
}
$coperadosMap = [];
foreach ($coperados as $coperado) {
    $coperadosMap[$coperado['id_cooperado']] = $coperado;
}
$rubrosMap = [];
foreach ($rubros as $rubro) {
    $rubrosMap[$rubro['id_rubro']] = $rubro;
}
$planesMap = [];
foreach ($planes as $plane) {
    $planesMap[$plane['id_planes_publicidad']] = $plane;
}
$campaignsMap = [];
foreach ($campaigns as $campaign) {
    $campaignsMap[$campaign['id_campania']] = $campaign;
}
$mediosMap = [];
foreach ($medios as $medio) {
    $mediosMap[$medio['id']] = $medio;
}
// Debug: Imprimir los datos de proveedores para verificar la estructura
// var_dump($proveedores);



