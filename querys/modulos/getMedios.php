<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de Supabase
$supabaseUrl = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

// Función para manejar errores y devolver una respuesta JSON
function returnError($message) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $message]);
    exit;
}

// Función para hacer una solicitud cURL
function makeRequest($url, $headers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($response === false) {
        returnError('Error en la solicitud cURL: ' . $error);
    }
    
    return $response;
}

// Headers para las solicitudes a Supabase
$headers = array(
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey
);

try {
    // Obtener los medios
    $urlMedios = $supabaseUrl . 'Medios?select=id,NombredelMedio,codigo,Id_Clasificacion,Estado';
    $responseMedios = makeRequest($urlMedios, $headers);
    $medios = json_decode($responseMedios, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar la respuesta de medios: ' . json_last_error_msg());
    }

    // Obtener las clasificaciones
    $urlClasificaciones = $supabaseUrl . 'ClasificacionMedios?select=id_clasificacion_medios,NombreClasificacion';
    $responseClasificaciones = makeRequest($urlClasificaciones, $headers);
    $clasificaciones = json_decode($responseClasificaciones, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar la respuesta de clasificaciones: ' . json_last_error_msg());
    }

    // Crear un mapa de clasificaciones
    $mapaClasificaciones = [];
    foreach ($clasificaciones as $clasificacion) {
        $mapaClasificaciones[$clasificacion['id_clasificacion_medios']] = $clasificacion['NombreClasificacion'];
    }

    // Agregar el nombre de la clasificación a cada medio
    foreach ($medios as &$medio) {
        $medio['NombreClasificacion'] = isset($mapaClasificaciones[$medio['Id_Clasificacion']])
            ? $mapaClasificaciones[$medio['Id_Clasificacion']]
            : 'Sin clasificación';
    }

    // Devolver los medios en formato JSON
    header('Content-Type: application/json');
    echo json_encode($medios);

} catch (Exception $e) {
    returnError($e->getMessage());
}
?>