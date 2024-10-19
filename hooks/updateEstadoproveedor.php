<?php
// Iniciar la sesión
session_start();

// Habilitar el reporte de errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar la entrada
    $id = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
    $estado = filter_input(INPUT_POST, 'Estado', FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $estado === false || $estado === null) {
        echo json_encode(['success' => false, 'message' => 'Datos de entrada inválidos']);
        exit;
    }

    // Función para hacer peticiones cURL
    function makeRequest($url, $method, $data = null) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Content-Type: application/json'
            ),
        ));
        if ($data !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return ['response' => $response, 'httpCode' => $httpCode];
    }

    // URL de la API de Supabase para actualizar el registro
    $url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?id_proveedor=eq.$id";
    
    // Datos a actualizar
    $data = array('estado' => $estado);
    
    // Hacer la petición PATCH para actualizar el registro
    $result = makeRequest($url, 'PATCH', $data);
    
    if ($result['httpCode'] == 204) {
        echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error al actualizar el estado', 
            'details' => $result['response'],
            'httpCode' => $result['httpCode']
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}