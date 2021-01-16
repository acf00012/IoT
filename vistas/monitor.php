<!DOCTYPE html>
<html lang="en">

<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Mexico_City');

require "basico/head.php";
if (!isset($_SESSION["nombre"])){
    header("Location: sesion.php");
} else {
?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <?php require "basico/sidebar.php"?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

          <!-- Main Content -->
          <div id="content">
              <!-- Topbar -->
              <?php require "basico/nav.php"?>
              <!-- End of Topbar -->

              <!-- Begin Page Content -->
              <div class="container-fluid"><!-- Page Heading -->
                  <form>
                      <div class="row">
                          <div class="col-xl-2 col-md-6 mb-2 text-right">
                              <label  class="label text-right"><b>Temperatura:</b></label>
                          </div>
                          <div class="col-xl-2 col-md-6 mb-2">
                              <label id="txtTemperatura" class="label text-right"><b>0 °C</b></label>
                          </div>
                          <div class="col-xl-2 col-md-6 mb-2 text-right">
                              <label class="label text-right"><b>Humedad:</b></label>
                          </div>
                          <div class="col-xl-2 col-md-6 mb-2">
                              <label id="txtHumedad" class="label text-right"><b>0 %</b></label>
                          </div>
                          <div class="col-xl-2 col-md-6 mb-2 text-right">
                              <label class="label text-right"><b>Actualizado:</b></label>
                          </div>
                          <div class="col-xl-2 col-md-6 mb-2">
                              <label id="txtHoraActualización" class="label text-right"><b> 00:00:00</b></label>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="container-fluid">
                  <?php require "basico/graficos.php"; ?>

              </div>
              <!-- /.container-fluid -->

          </div>
          <!-- End of Main Content -->

          <!-- Footer -->
          <?php require "basico/footer.php"?>
          <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php require "basico/modal.php"?>
  <!-- Bootstrap core JavaScript-->
  <?php require "basico/java.php"?>
  <script type="text/javascript" src="../scripts/sMonitor.js"></script>


</body>

</html>
<?php }
ob_end_flush();?>
