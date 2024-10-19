<?php
//session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$nombre = $_SESSION['user_name'];





$ruta = 'https://improved-space-goldfish-jjw6rv7r4vxc5v9x-3000.app.github.dev/';









$current_file = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="es">

<head>
  
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PADD - Origen Medios</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/misestilos.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/formulario.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/bundles/bootstrap/css/bootstrap.min.css">

  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css">

  

  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/components.css">
  <!-- Custom style CSS -->



  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/custom.css">
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel='shortcut icon' type='image/x-icon' href='https://www.origenmedios.cl/wp-content/uploads/2023/09/favicon-32.png' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline me-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-bs-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <div class="crmtitulo">PADD DE ADMINISTRACIÓN</div>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right duo">
   Bienvenid@ - <?php echo htmlspecialchars($nombre); ?>
          <li class="dropdown"><a href="#" data-bs-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php echo $ruta; ?>assets/img/cristianImg.png"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              
              <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Mi Perfíl
              </a><a href="" class="dropdown-item has-icon"> <i class="fas fa-copy"></i>
                Publicar Mensajes
              </a>
              <a href="" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Muro de Mensajes
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Salir de Padd
              </a>
            </div>
          </li>
        </ul>
      </nav>
