<?php
error_log("deleteMedio.php se ha ejecutado");

// Habilitar el logging de errores
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/ruta/a/tu/error_log.txt'); // Asegúrate de cambiar esto a una ruta válida

define('SUPABASE_URL', 'https://ekyjxzjwhxotpdfzcpfq.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc');

function makeRequest($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=minimal'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($data && ($method == 'POST' || $method == 'PATCH')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        error_log('Curl error: ' . curl_error($ch));
        return ['error' => 'Curl error: ' . curl_error($ch)];
    }
    
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        return $method == 'GET' ? json_decode($response, true) : true;
    } else {
        error_log("HTTP Error: $httpCode, Response: $response");
        return ['error' => "HTTP Error: $httpCode", 'response' => $response];
    }
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    error_log("Intentando eliminar medio con ID: $id");

    $url = SUPABASE_URL . "/rest/v1/Medios?id=eq." . urlencode($id);
    error_log("URL de eliminación: $url");

    $resultado = makeRequest($url, 'DELETE');
    error_log("Resultado de makeRequest: " . json_encode($resultado));

    if ($resultado === true) {
        error_log("Medio eliminado con éxito");
        echo json_encode(['success' => true, 'message' => 'Medio eliminado con éxito']);
    } else {
        error_log("Error al eliminar el medio. Detalles: " . json_encode($resultado));
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el medio', 'details' => $resultado]);
    }
} else {
    error_log("Método no permitido o ID no proporcionado");
    echo json_encode(['success' => false, 'message' => 'Método no permitido o ID no proporcionado']);
}