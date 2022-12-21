<?php require 'boxes-design.php';?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <title>Inventario - Libreria Diego</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" media="all">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/templatemo-style.css">

  </head>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper">

      <!-- Main -->
        <div id="main">
          <div class="inner">

            <!-- Header -->
            <header id="header">
              <div class="logo">
                <a href="index.php">Libreria Diego</a>
              </div>
            </header>
          
            <!-- Services -->
            <section class="simple-post">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="text-align: center; text-decoration: underline;">Inventario - Productos</h2>                    
                    
                    <!-- Modal Form Productos -->
                    <!-- Button trigger modal -->
                    <button style="margin-bottom: 10px;" type="button" id="btnNuevo" class="btn btn-primary" data-toggle="modal tooltip" data-placement="top" title="Agregar Producto" data-target="#modalFormProductos">
                                                                                
                      <i class="material-icons">library_add</i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalFormProductos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form id="formUsuarios">    
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Codigo:</label>
                                    <input type="text" class="form-control" id="codigo" required>
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" required>
                                    </div> 
                                    </div>    
                                </div>
                                <div class="row"> 
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Precio Publico</label>
                                    <input type="number" class="form-control" id="precio_venta" required>
                                    </div>               
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Precio Comerciante</label>
                                    <input type="number" class="form-control" id="precio_mayor" required>
                                    </div>
                                    </div>  
                                </div>
                                <label for="" class="col-form-label">Stock Actual</label>
                                <div class="row">
                                  <div class="col-lg-12">
                                  <div class="input-group mb-3">
																			<div class="input-group-prepend">
																				<button class="btn btn-outline-danger btnstockmenos" type="button" value="50">-50</button>
																				<button class="btn btn-outline-danger btnstockmenos" type="button" value="25">-25</button>
																				<button class="btn btn-outline-danger btnstockmenos" type="button" value="10">-10</button>
																			</div>
																			<input type="number" class="form-control form-control-sm" style="text-align: center; color: darkgreen" placeholder="Stock actual" id="stock" aria-label="" aria-describedby="basic-addon1" required>
																			<div class="input-group-append">
																				<button class="btn btn-outline-primary btnstockmas" type="button" value="10">+10</button>
																				<button class="btn btn-outline-primary btnstockmas" type="button" value="25">+25</button>
																				<button class="btn btn-outline-primary btnstockmas" type="button" value="50">+50</button>
																			</div>
																		</div>
                                  </div>   
                                </div>
                                <label for="" class="col-form-label">Stock Critico</label>
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                        <button class="btn btn-outline-danger btnstockminmenos" type="button" value="50">-50</button>
                                        <button class="btn btn-outline-danger btnstockminmenos" type="button" value="25">-25</button>
                                        <button class="btn btn-outline-danger btnstockminmenos" type="button" value="10">-10</button>
                                      </div>
                                      <input type="number" class="form-control form-control-sm" style="text-align: center; color: red" placeholder="Stock critico" id="stock_min" aria-label="" aria-describedby="basic-addon1" required>
                                      <div class="input-group-append">
                                        <button class="btn btn-outline-primary btnstockminmas" type="button" value="10">+10</button>
                                        <button class="btn btn-outline-primary btnstockminmas" type="button" value="25">+25</button>
                                        <button class="btn btn-outline-primary btnstockminmas" type="button" value="50">+50</button>
                                      </div>
                                    </div>
                                  </div>   
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                        <label for="" class="col-form-label">Descripcion</label>
                                        <input type="text" class="form-control" id="descripcion">
                                        </div>
                                    </div>      
                                </div>          
                            </div> 
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                            </div>
                        </form>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Form Productos -->
                    <!-- Tabla de Productos -->
                    <div class="table-responsive">
                      <table class="table table-striped display" id="tablaProductos" style="width:100%">
                        <thead>
                          <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio Publico</th>
                            <th>Precio Comerciante</th>
                            <th>Stock</th>
                            <th>Stock Critico</th>
                            <th class="lastth">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio Publico</th>
                            <th>Precio Comerciante</th>
                            <th>Stock</th>
                            <th>Stock Critico</th>
                            <th class="lastth">Acciones</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
              
                    <!-- Tabla de Productos -->
                    
                  </div>
                </div>
              </div>
            </section>
            <!-- Services -->


          </div>
        </div>
      <!--Modal para CRUD-->

      <!-- Toast notification push up -->

      <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div id="pushNotificationToast" class="toast" data-delay="5000" style="z-index: 7000 !important ;margin: 30px; position: fixed; top: 0; right: 0; background: white !important;">
          <div class="toast-header" style="text-align: center !important">
            <strong class="mr-auto">Notificacion</strong>
            </button>
          </div>
          <div class="toast-body">
            <span id="pushNotificationToastBody"></span>
          </div>
        </div>
      </div>

      <!-- Toast notification push up -->

      <!-- Sidebar -->
      <?php execMenu() ?>
      <!-- Footer -->
        <footer id='footer'>
            <div class='footermenu'>
              <button onclick="window.open('https://www.facebook.com/libreriadiegoarica','_blank')" type='button' data-toggle='tooltip' data-placement='top' title='Facebook'><i class='material-icons facebook'>facebook</i></a>︁</button>
              <button onclick="window.open('https://www.instagram.com/libreriadiego/', '_blank')" type='button' data-toggle='tooltip' data-placement='top' title='Instagram'><i class='instagrambtn'>instagram</i></button>
              <button onclick="window.open('http://www.libreriadiegoarica.cl', '_blank')" type=button' data-toggle='tooltip' data-placement='top' title='Pagina Web'><i class='material-icons public'>public</i></button>
              <button onclick="window.open('https://web.nubox.com/Login/Account/Login', '_blank')" type='button' data-toggle='tooltip' data-placement='top' title='Nubox'><i class='material-icons filter_drama'>filter_drama</i></button>
              <form method='POST' action='index.php'><button type='submit' name='logout' data-toggle='tooltip' data-placement='top' title='Cerrar Sesion'><i class='material-icons logout'>logout</i>︁</button></form>
            </div>
            <p class='copyright'>Copyright &copy; 2021 Libreria Diego
            <br>Designed by <a rel='nofollow' href='https://github.com/alxndrep'>Alexander Escarate</a></p>
            <hr>
            <div style="text-align: center">
              <button class="btn-danger" style="border-radius: 10px; font-size: 12px; font-weight: bold;" onclick='window.location.href=`new_ventas.php`' type='button' data-toggle='tooltip' data-placement='top' title='Crear una nueva Venta'>Nueva Venta</button>
              <button class="btn-danger" style="border-radius: 10px; font-size: 12px; font-weight: bold;" onclick='window.location.href=`all_ventas.php`' type='button' data-toggle='tooltip' data-placement='top' title='Ver todas las ventas'>Ver Ventas</button>
              <button class="btn-danger" style="border-radius: 10px; font-size: 12px; font-weight: bold;" onclick='window.location.href=`productos.php`' type='button' data-toggle='tooltip' data-placement='top' title='Ver el Inventario'>Inventario</button>
            </div>
            </footer>
        </div>
      </div>
    </div>


<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.1.2/css/bootstrap-toaster.min.css" integrity="sha512-kYPLvO+Bu+xttOhbQvxs9nx7XSdxrb2JexRxQ3CpJQ7EtmlkBsWyOjlinLgiLWeLxuupFYB4cPqLOo0gnBnzeQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/transition.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/custom.js"></script>
<script src="main.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>



    <script>
      $(document).ready(function(){
      $("#closebutton").on( "click", function() {
      if ($("#display-panel").hasClass("hidden")) {
          $("#display-panel").removeClass("hidden").addClass("visible");
      }
      else {
          $("#display-panel").removeClass("visible").addClass("hidden");
      }
      });
      });
      $("button").hover(function(){
        $(this).tooltip('show');
      });
    </script>
    <?php 
      showNotifications();
    ?>

  </body>
</html>
