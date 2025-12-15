<!DOCTYPE html>
<html lang="es" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Consultorios Jurídicos UNIANDES</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./public/images/logo.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="./public/assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="./public/assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="./public/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="./public/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="./public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="./public/assets/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="./public/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="./public/assets/js/config.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <style>
    #loadingScreen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 9999;
      display: none;
    }

    #loadingMessage {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 18px;
    }
  </style>
  <!-- Content -->
  <div id="loadingScreen">
    <div id="loadingMessage">Cargando...</div>
  </div>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register Card -->
        <div class="card">
          <div class="card-body" style="text-align: center;">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">

                <h1>Consultorios Jurídicos
                  <hr> UNIANDES
                </h1>
              </a>
            </div>
            <!-- /Logo -->
            <!--  <form id="registro" method="post" style="text-align: center;">-->
            <h4 class="mb-2">Registro de Asistencia</h4>
            <!-- Stream video via webcam -->
            <video id="video" width="320" height="320" autoplay></video>

            <canvas id="canvas" width="320" height="320" style="display: none;"></canvas>

            <div class="mb-3">
              <label for="Cedula" class="form-label">Ingrese su número de cédula</label>
              <input type="text" class="form-control" id="Cedula" name="Cedula" placeholder="Enter your username" autofocus required />
            </div>
            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo de Acceso</label>
              <select name="tipo" id="tipo" class="form-control" required></select>
            </div>
            <!--<button onclick="GuardarEditar()" class="btn btn-primary d-grid w-100">Guardar</button>-->
            <button id="captureButton" name="captureButton" class="btn btn-primary d-grid w-100">Guardar</button>
            <!-- </form>-->
          </div>
        </div>

      </div>
    </div>
  </div>

  <p class="text-center">
    <a href="login.php">
      <span>Inicio de Sesión</span>
    </a>
  </p>
  <!-- / Content -->

  <br>


  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="./public/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="./public/assets/vendor/libs/popper/popper.js"></script>
  <script src="./public/assets/vendor/js/bootstrap.js"></script>
  <script src="./public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="./public/assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="./public/assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="./camara.js"></script>

</body>

</html>