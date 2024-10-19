<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios";

    $headers = array(
        "Content-Type: application/json",
        "apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
        "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
    );

    $ch = curl_init();

    $email = urlencode($_POST['email']);
    curl_setopt($ch, CURLOPT_URL, $url . "?Email=eq." . $email);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if(curl_errno($ch)){
        $error_message = "Error de cURL: " . curl_error($ch);
    } else {
        if($http_code == 200){
            $user_data = json_decode($response, true);
            
            if (!empty($user_data)) {
                $user = $user_data[0]; // Supabase devuelve un array de resultados
                if ($user['Password'] === $_POST['password']) {
                    if ($user['Estado'] === true) {
                        $_SESSION['user'] = $user;
                        $_SESSION['user_name'] = isset($user['nombre']) ? $user['nombre'] : 'Usuario';
                        $_SESSION['user_email'] = $user['Email'];
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        $error_message = "Su cuenta no está habilitada para acceder. Por favor, contacte al administrador.";
                    }
                } else {
                    $error_message = "Contraseña Incorrecta";
                }
            } else {
                $error_message = "Email no encontrado en la base de datos";
            }
        } else {
            $error_message = "Error en el inicio de sesión. Código HTTP: " . $http_code . ". Respuesta: " . $response;
        }
    }

    curl_close($ch);

    error_log("Intento de inicio de sesión - Email: " . $_POST['email'] . ", Error: " . ($error_message ?? 'Ninguno'));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PADD - Origen Medios</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="assets/css/misestilos.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='https://www.origenmedios.cl/wp-content/uploads/2023/09/favicon-32.png' />
</head>
<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="centrado"><img src="https://www.origenmedios.cl/wp-content/uploads/2023/10/logo-origen-2023-sm2.png"/></div>
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <span class="acceso">ACCESO A LA PLATAFORMA</span>
              </div>
              <div class="card-body">
              <form method="POST" action="" class="needs-validation" novalidate="">
        <?php if (isset($error_message)): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Por favor, ingrese su email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small medium">
                          ¿Olvidaste tu Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Por favor, ingrese su contraseña
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Recuérdame</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block largo" tabindex="4">
                      INGRESAR
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>
</html>