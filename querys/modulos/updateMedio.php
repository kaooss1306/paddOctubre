<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Habilitar el logging de errores
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error_log.txt'); // Asegúrate de cambiar esto a una ruta válida

define('SUPABASE_URL', 'https://ekyjxzjwhxotpdfzcpfq.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'); // Reemplaza esto con tu clave real

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
    }
    
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        return $method == 'GET' ? json_decode($response, true) : true;
    } else {
        error_log("HTTP Error: $httpCode, Response: $response");
        return false;
    }
}

// Asegúrate de que la respuesta sea siempre JSON
header('Content-Type: application/json');

error_log("Método de solicitud: " . $_SERVER["REQUEST_METHOD"]);
error_log("Datos POST recibidos: " . print_r($_POST, true));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nombreDelMedio = $_POST['NombredelMedio'] ?? '';
    $codigo = $_POST['codigo'] ?? '';
    $idClasificacion = $_POST['Id_Clasificacion'] ?? '';

    error_log("Datos procesados: id=$id, nombre=$nombreDelMedio, codigo=$codigo, clasificacion=$idClasificacion");

    $datosActualizados = [
        'NombredelMedio' => $nombreDelMedio,
        'codigo' => $codigo,
        'Id_Clasificacion' => $idClasificacion
    ];

    $url = SUPABASE_URL . "/rest/v1/Medios?id=eq.$id";
    error_log("URL de actualización: $url");
    error_log("Datos a actualizar: " . json_encode($datosActualizados));

    $resultado = makeRequest($url, 'PATCH', $datosActualizados);

    if ($resultado === false) {
        error_log("Error al actualizar el medio");
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el medio']);
    } else {
        $urlGet = SUPABASE_URL . "/rest/v1/Medios?id=eq.$id";
        $datosActualizados = makeRequest($urlGet, 'GET');
        
        if ($datosActualizados && !empty($datosActualizados)) {
            error_log("Medio actualizado con éxito: " . json_encode($datosActualizados[0]));
            echo json_encode([
                'success' => true, 
                'message' => 'Medio actualizado con éxito',
                'data' => $datosActualizados[0]
            ]);
        } else {
            error_log("Medio actualizado pero no se pudieron recuperar los datos");
            echo json_encode([
                'success' => true, 
                'message' => 'Medio actualizado con éxito, pero no se pudieron recuperar los datos'
            ]);
        }
    }
} else {
    error_log("Método no permitido");
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Asegúrate de que no haya salida después de este punto
exit;
?>