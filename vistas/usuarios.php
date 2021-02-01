
<!DOCTYPE html>
<html lang="en">

<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Mexico_City');

if (!isset($_SESSION["nombre"])){
    header("Location: sesion.php");
} else {
if ($_SESSION['tipo'] == 'Administrador' and $_SESSION['clave']>0) {

require "basico/head.php";
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
              <div class="container-fluid">

                  <!-- Page Heading -->
                  <div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
                      <button id="btnAgregar" class="btn btn-success" onclick="mostrarform(1)">
                          <i class="fa fa-plus-circle"></i>
                          Agregar
                      </button>
                      <button id="btnCancelar" class="btn btn-warning" onclick="mostrarform(2)">
                          <i class="fa fa-plus-circle"></i>
                          Cancelar
                      </button>
                  </div>
                  <!-- Content Row -->
                  <div class="row">

                      <!-- Earnings (Monthly) Card Example -->
                      <div class="col-xl-3 col-md-6 mb-4">
                          <a name="administrador" id="administrador" onclick="indicadores(0)" href="#" class="d-none d-sm-inline-block btn btn-warning "><i class="fas fa-user-secret fa-sm text-white-50"></i> Administradores</a>
                      </div>

                      <div class="col-xl-3 col-md-6 mb-4">
                          <a name="institucion" id="maestro" onclick="indicadores(1)" href="#" class="d-none d-sm-inline-block btn btn-warning "><i class="fas fa-user-ninja fa-sm text-white-50"></i>Maestros</a>
                      </div>

                      <!-- Earnings (Monthly) Card Example -->
                      <div class="col-xl-3 col-md-6 mb-4">
                          <a name="psicologo" id="padre" onclick="indicadores(2)" href="#" class="d-none d-sm-inline-block btn btn-warning "><i class="fas fa-user-astronaut fa-sm text-white-50"></i>Padre</a>
                      </div>

                      <!-- Earnings (Monthly) Card Example -->
                      <div class="col-xl-3 col-md-6 mb-4">
                          <a name="alumno" id="alumno" href="#" onclick="indicadores(3)" class="d-none d-sm-inline-block btn btn-warning "><i class="fas fa-user-friends fa-sm text-white-50"></i> Alumno</a>
                      </div>
                  </div>

                  <!-- Content Row -->
                  <div class="card shadow mb-4" id="listadoVista">
                      <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">Registros</h6>
                          <?php
                          //echo session_status();
                          ?>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table id="tbUsuarios" class="table table-bordered" width="100%" cellspacing="0">
                                  <thead>
                                  <tr>
                                      <th>Menú</th>
                                      <th>Nombre</th>
                                      <th>Email</th>
                                      <th>Foto</th>
                                      <th>Estado</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                                  <tfoot>
                                  <tr>
                                      <th>Menú</th>
                                      <th>Nombre</th>
                                      <th>Email</th>
                                      <th>Foto</th>
                                      <th>Estado</th>
                                  </tr>
                                  </tfoot>
                              </table>
                          </div>
                      </div>
                  </div>
                  <div class="card shadow mb-4" id="listadoEntradasSalidas">
                      <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">Entrada - Salida</h6>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table id="tbEntradasSalidas" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                  <tr>
                                      <th>Hora y fecha de acceso</th>
                                      <th>Hora y fecha de salida</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>

                  <div class="card shadow mb-4" id="formularioVista">
                      <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">Nuevo registro</h6>
                      </div>
                      <div class="card-body">
                          <form name="formulario" id="formulario" method="post" enctype="multipart/form-data">
                              <div class="row">
                                  <div class="col-sm-4">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="nombre">Nombre:</label>
                                          <input type="hidden" name="id" id="id">
                                          <input type="text" class="form-control" name="nombre"  id="nombre" maxlength="50" placeholder="Juan Morales Romero" required>
                                      </div>
                                  </div>
                                  <div class="col-sm-4">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="nickname">Apodo:</label>
                                          <input type="text" class="form-control" name="nickname"  id="nickname" maxlength="50" placeholder="..." required>
                                      </div>
                                  </div>
                                  <div class="col-sm-4">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="control" id="identificador">
                                          </label>
                                          <input type="text" class="form-control" name="control"  id="control" maxlength="50" placeholder="..." required>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="email">Correo electronico:</label>
                                          <input type="email" class="form-control" name="email"  id="email" maxlength="50" placeholder="...@gmail.com" required>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="contrasenia">Contraseña:</label>
                                          <input type="password" class="form-control" name="contrasenia"  id="contrasenia" maxlength="50" placeholder="" required>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="imagen">Foto:</label>
                                          <div class="custom-file">
                                              <input type="file" class="custom-file-input" id="imagen" name="imagen">
                                              <label class="custom-file-label" for="customFile">Choose file</label>
                                          </div>
                                          <input type="hidden" name="fotoActual" id="fotoActual"><br>
                                      </div>
                                  </div>
                                  <div class="col-sm-6" id="divMatch">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <label for="NameMatch" id="MostrarMatch"></label>
                                          <input type="hidden" name="match" id="match">
                                          <input type="text" class="form-control" name="NameMatch"  id="NameMatch" maxlength="50" placeholder="Seleccionar en la tabla..." required readonly>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <img alt="" src="../vistas/files/1583591854.jpg" class="img-profile rounded-circle"  width="150px" height="150px" id="imagenMostrar">
                                  </div>
                                  <div class="col-sm-12" id="listadoMatchPsicologo">
                                      <div class="table-responsive">
                                          <table id="tbUsuariosMatchPiscologo" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                              <thead>
                                              <tr>
                                                  <th>Menú</th>
                                                  <th>Nombre</th>
                                                  <th>Institucion</th>
                                                  <th>Email</th>
                                                  <th>Foto</th>
                                              </tr>
                                              </thead>
                                              <tbody>

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <!-- Select multiple-->
                                      <div class="form-group">
                                          <button class="btn btn-outline-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>

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
  <script src="../scripts/sUsuarios.js"></script>

</body>

</html>
<?php } }
ob_end_flush();?>