<?php
// Iniciar el almacenamiento en búfer de salida
ob_start();

// Habilitar la visualización de errores (solo para depuración, desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de Supabase
$supabaseUrl = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

// Función para manejar errores y devolver una respuesta JSON
function returnError($message) {
    ob_clean(); // Limpiar cualquier salida anterior
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $message]);
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

// Verificar si se proporcionó un ID de cliente
if (!isset($_GET['id_cliente']) || !is_numeric($_GET['id_cliente'])) {
    returnError('ID de cliente no válido');
}

$id_cliente = intval($_GET['id_cliente']);

try {
    // Construir la URL para obtener el cliente específico
    $urlCliente = $supabaseUrl . 'Clientes?id_cliente=eq.' . $id_cliente;
    
    // Hacer la solicitud a Supabase
    $responseCliente = makeRequest($urlCliente, $headers);
    
    // Decodificar la respuesta JSON
    $clientes = json_decode($responseCliente, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar la respuesta del cliente: ' . json_last_error_msg());
    }
    
    // Verificar si se encontró el cliente
    if (empty($clientes)) {
        returnError('Cliente no encontrado');
    }
    
    // Limpiar cualquier salida anterior
    ob_clean();
    
    // Devolver los datos del primer (y único) cliente encontrado
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'cliente' => $clientes[0]]);

} catch (Exception $e) {
    returnError($e->getMessage());
}

// Finalizar y limpiar el búfer de salida
ob_end_flush();
?>