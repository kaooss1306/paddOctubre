<?php
// Configuración de Supabase
$supabaseUrl = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'; // Reemplaza esto con tu clave API real

if (isset($_GET['proveedor_id'])) {
    $proveedor_id = $_GET['proveedor_id'];

    // Obtener los id_soporte correspondientes al id_proveedor desde la tabla proveedor_soporte
    $urlProveedorSoportes = $supabaseUrl . 'proveedor_soporte?select=id_soporte&id_proveedor=eq.' . $proveedor_id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlProveedorSoportes);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ));
    $responseProveedorSoportes = curl_exec($ch);
    curl_close($ch);

    if ($responseProveedorSoportes === false) {
        echo json_encode(array('error' => 'Error en la solicitud a proveedor_soporte'));
        exit;
    }

    $proveedorSoportes = json_decode($responseProveedorSoportes, true);
    
    // Obtener los id_soporte de los soportes
    $idsSoportes = array_column($proveedorSoportes, 'id_soporte');
    
    // Si no hay soportes, no continuar
    if (empty($idsSoportes)) {
        echo json_encode(array()); // Retorna un array vacío de soportes
        exit;
    }

    // Obtener los soportes desde la tabla Soportes usando los id_soporte
    $urlSoportes = $supabaseUrl . 'Soportes?select=*&id_soporte=in.(' . implode(',', $idsSoportes) . ')';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlSoportes);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ));
    $responseSoportes = curl_exec($ch);
    curl_close($ch);

    if ($responseSoportes === false) {
        echo json_encode(array('error' => 'Error en la solicitud a Soportes'));
        exit;
    }

    $soportes = json_decode($responseSoportes, true);
    
    // Obtener los ids de medios asociados a los soportes
    $idsSoportes = array_column($soportes, 'id_soporte');
    if (empty($idsSoportes)) {
        echo json_encode(array()); // Retorna un array vacío si no hay soportes
        exit;
    }

    // Obtener los medios asociados a los soportes desde soporte_medios
    $urlSoporteMedios = $supabaseUrl . 'soporte_medios?select=id_soporte,id_medio&id_soporte=in.(' . implode(',', $idsSoportes) . ')';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlSoporteMedios);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ));
    $responseSoporteMedios = curl_exec($ch);
    curl_close($ch);

    if ($responseSoporteMedios === false) {
        echo json_encode(array('error' => 'Error en la solicitud de soporte_medios'));
        exit;
    }

    $soporteMedios = json_decode($responseSoporteMedios, true);
    
    // Obtener los ids de medios únicos
    $idsMedios = array_unique(array_column($soporteMedios, 'id_medio'));

    // Obtener los nombres de los medios desde la tabla medios
    $urlMedios = $supabaseUrl . 'Medios?select=id,NombredelMedio&id=in.(' . implode(',', $idsMedios) . ')';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlMedios);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ));
    $responseMedios = curl_exec($ch);
    curl_close($ch);

    if ($responseMedios === false) {
        echo json_encode(array('error' => 'Error en la solicitud de medios'));
        exit;
    }

    $medios = json_decode($responseMedios, true);

    // Crear un array para mapear id_medio a nombre_medios
    $mapMedios = [];
    foreach ($medios as $medio) {
        $mapMedios[$medio['id']] = $medio['NombredelMedio'];
    }

    // Asignar nombres de medios a los soportes
    foreach ($soportes as &$soporte) {
        $soporte['medios'] = [];
        foreach ($soporteMedios as $sm) {
            if ($sm['id_soporte'] == $soporte['id_soporte']) {
                if (isset($mapMedios[$sm['id_medio']])) {
                    $soporte['medios'][] = $mapMedios[$sm['id_medio']];
                }
            }
        }
    }

    // Devolver los soportes con medios en formato JSON
    echo json_encode($soportes);

} else {
    echo json_encode(array('error' => 'No se proporcionó ID de proveedor'));
}