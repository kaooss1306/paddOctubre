<?php
// Iniciar la sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $data = [
        'nombreCliente' => $_POST['nombreCliente'],
        'nombreFantasia' => $_POST['nombreFantasia'],
        'id_tipoCliente' => $_POST['id_tipoCliente'],
        'razonSocial' => $_POST['razonSocial'],
        'grupo' => $_POST['grupo'],
        'RUT' => $_POST['RUT'],
        'giro' => $_POST['giro'],
        'nombreRepresentanteLegal' => $_POST['nombreRepresentanteLegal'],
        'RUT_representante' => $_POST['RUT_representante'],
        'direccionEmpresa' => $_POST['direccionEmpresa'],
        'id_region' => $_POST['id_region'],
        'id_comuna' => $_POST['id_comuna'],
        'telCelular' => $_POST['telCelular'],
        'telFijo' => $_POST['telFijo'],
        'email' => $_POST['email'],
        'formato' => $_POST['formato'],
        'nombreMoneda' => $_POST['nombreMoneda'],
        'valor' => $_POST['valor']
    ];

    // URL de la API de Supabase
    $url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?id_cliente=eq.{$id_cliente}";

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Prefer: return=minimal',
        'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc', // Reemplaza con tu API key de Supabase
        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc' // Reemplaza con tu API key de Supabase
    ]);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la conexión cURL
    curl_close($ch);

    // Verificar la respuesta
    if ($http_status == 204) { // Supabase devuelve 204 No Content en una actualización exitosa
        $response = [
            "success" => true,
            "alert" => [
                "title" => "¡Éxito!",
                "text" => "Cliente actualizado correctamente",
                "icon" => "success"
            ]
        ];
    } else {
        $response = [
            "success" => false,
            "error" => "Error al actualizar el cliente. Código de estado HTTP: " . $http_status
        ];
    }

    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no es una solicitud POST, devolver un error
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(["error" => "Método no permitido"]);
}
?>