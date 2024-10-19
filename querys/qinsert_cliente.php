<?php
// Configuración de Supabase
$supabaseUrl = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

// Funciones de validación
function validaRut($rut) {
    if (preg_match('/^[0-9]+[-|‐]{1}[0-9kK]{1}$/', $rut)) {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;
        foreach(array_reverse(str_split($numero)) as $v) {
            if($i==8) $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        $dvr = 11 - ($suma % 11);
        if($dvr == 11) $dvr = 0;
        if($dvr == 10) $dvr = 'K';
        if($dvr == strtoupper($dv)) return true;
    }
    return false;
}

function validaEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Recoger datos del formulario
$data = $_POST;

// Validar datos
if (!validaRut($data['RUT']) || !validaRut($data['Rut_representante'])) {
    echo json_encode(['success' => false, 'error' => 'RUT inválido']);
    exit;
}

if (!validaEmail($data['email'])) {
    echo json_encode(['success' => false, 'error' => 'Email inválido']);
    exit;
}

// Preparar los datos para la inserción
$clienteData = [
    'created_at' => date('c'),
    'nombreCliente' => $data['nombreCliente'],
    'nombreFantasia' => $data['nombreFantasia'],
    'razonSocial' => $data['razonSocial'],
    'id_tipoCliente' => $data['id_tipoCliente'],
    'grupo' => $data['grupo'],
    'RUT' => $data['RUT'],
    'giro' => $data['giro'],
    'nombreRepresentanteLegal' => $data['nombreRepresentanteLegal'],
    'RUT_representante' => $data['Rut_representante'],
    'direccionEmpresa' => $data['direccionEmpresa'],
    'id_region' => $data['id_region'],
    'id_comuna' => $data['id_comuna'],
    'telCelular' => $data['telCelular'],
    'telFijo' => $data['telFijo'],
    'estado' => true,
    'email' => $data['email'],
    'formato' => $data['formato'],
    'nombreMoneda' => $data['nombreMoneda'],
    'valor' => $data['valor']

];

// Realizar la petición a Supabase
$ch = curl_init($supabaseUrl . '/rest/v1/Clientes');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($clienteData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey,
    'Prefer: return=minimal'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Preparar la respuesta
if ($httpCode == 201) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al insertar: ' . $response]);
}