<?php
// Configuración de Supabase
$supabaseUrl = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

// Obtener los proveedores
function makeRequest($url) {
    global $supabaseKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

if (isset($_GET['id_proveedor'])) {
    $id_proveedor = $_GET['id_proveedor'];
    $proveedor = makeRequest($supabaseUrl . "Proveedores?id_proveedor=eq.$id_proveedor&select=*");

    // Obtener todos los medios y la relación con proveedores
    $proveedor_medios = makeRequest($supabaseUrl . "proveedor_medios?select=*");
    $medios = makeRequest($supabaseUrl . "Medios?select=*");

    // Mapear id_medio a nombre_medio
    $mapMedios = [];
    foreach ($medios as $medio) {
        $mapMedios[$medio['id']] = $medio['NombredelMedio'];
    }

    // Asignar nombres de medios al proveedor
    if (!empty($proveedor)) {
        $proveedor = $proveedor[0]; // Asumiendo que solo obtienes un proveedor
        $proveedor['medios'] = [];
        foreach ($proveedor_medios as $pm) {
            if ($pm['id_proveedor'] == $proveedor['id_proveedor']) {
                if (isset($mapMedios[$pm['id_medio']])) {
                    $proveedor['medios'][] = $mapMedios[$pm['id_medio']];
                }
            }
        }
    }

    echo json_encode($proveedor);
} else {
    echo json_encode([]);
}
?>
