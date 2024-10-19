<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// URL del endpoint
$baseUrl = "https://baserow-production-9ab6.up.railway.app/api/database/rows/table/164/";

// Token de autorización
$token = "nHPciD53K9SI883sLftNOUPQuaSWKNB0";

$message = '';
$debug_info = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cliente_id'])) {
    $cliente_id = $_POST['cliente_id'];
    $url = $baseUrl . $cliente_id . '/';

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar las opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Token $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if(curl_errno($ch)){
        $error = 'Error cURL: ' . curl_error($ch);
        $debug_info .= "Error en la solicitud: $error\n";
        $message = "Error al conectar con el servidor.";
    } else {
        if ($http_code == 204) {
            $message = "Cliente eliminado exitosamente.";
        } else {
            $responseData = json_decode($response, true);
            $message = "Error al eliminar el cliente. Código: $http_code";
            $debug_info .= "Respuesta del servidor: " . print_r($responseData, true) . "\n";
            
            if (isset($responseData['error']) && isset($responseData['detail'])) {
                $debug_info .= "Error específico: " . $responseData['error'] . "\n";
                $debug_info .= "Detalles del error: " . print_r($responseData['detail'], true) . "\n";
            }
        }
    }

    // Cerrar la sesión cURL
    curl_close($ch);
}

// Incluir el header y la barra lateral
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Eliminar Cliente</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($message): ?>
                                <div class="alert alert-info"><?php echo $message; ?></div>
                            <?php endif; ?>
                            <?php if ($debug_info): ?>
                                <pre><?php echo htmlspecialchars($debug_info); ?></pre>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label>ID del Cliente a Eliminar</label>
                                    <input type="number" class="form-control" name="cliente_id" required>
                                </div>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este cliente?');">Eliminar Cliente</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'componentes/footer.php'; ?>