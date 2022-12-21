<?php require 'boxes-design.php';?>
<?php isUserVendedor() ?>

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-style.css">
    <link rel="stylesheet" href="assets/css/owl.css">

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
                    <h2 style="text-align: center; text-decoration: underline;" class="text-danger">Inventario - Productos criticos</h2>                    
                    
                    <!-- Tabla de Productos -->
                    <div class="table-responsive">
                      <table class="table table-striped display" id="bajostock" style="width:100%">
                        <thead>
                          <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
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
                            <th>Stock</th>
                            <th>Stock Critico</th>
                            <th class="lastth">Acciones</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
              

                    <!-- Modal Form Producto -->
                    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
													<form id="bajostockForm">  
                            <div class="modal-body">
                              <div class="row">
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label for="codigo" class="col-form-label">Codigo:  </label>
                                      <input type="text" class="form-control" id="codigo" required>
                                    </div>
                                  </div>
                                  <div class="col-lg-9">
                                    <div class="form-group">
                                      <label for="nombre" class="col-form-label">Nombre:  </label>
                                      <input type="text" class="form-control" id="nombre" required>
                                    </div> 
                                  </div>    
                                </div>
																<div class="alert alert-success" role="alert">
                                <div class="row">
                                  <div class="col-lg-3">  
                                    <label class="col-form-label"><strong>Stock Actual:</strong></label>
                                  </div>
                                  <div class="col-lg-9">
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
                                    <div class="input-group mb-1">
                                      <input type="number" class="form-control form-control-sm" style="text-align: center; color: darkgreen" placeholder="Agregar al stock" id="plusStock" aria-label="" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                        <button class="btn btn-outline-success btnplusstock" type="button">+</button>
                                      </div>
                                    </div>
                                    
                                  </div>
                                </div>
																</div>

																<div class="alert alert-danger" role="alert">
                                <div class="row">
                                  <div class="col-lg-3">  
                                    <label class="col-form-label"><strong>Stock Critico:</strong></label>
                                  </div>
                                  <div class="col-lg-9">
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
																</div>

                            </div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
															<button type="submit" class="btn btn-success">Guardar cambios</button>
														</div>
													</form>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Form Clientes -->


                    <!-- Tabla de Productos -->
                    
                  </div>
                </div>
              </div>
            </section>
            <!-- Services -->


          </div>
        </div>
      <!--Modal para CRUD-->

      <!-- Sidebar -->
      <?php execMenu() ?>
      <!-- Footer -->
        <footer id='footer'>
            <div class='footermenu'>
              <button onclick="window.open('https://www.facebook.com/libreriadiegoarica','_blank')" type='button' data-toggle='tooltip' data-placement='top' title='Facebook'><i class='material-icons facebook'>facebook</i></a>︁</button>
              <button onclick="window.open('https://www.instagram.com/libreriadiego/', '_blank')" type='button' data-toggle='tooltip' data-placement='top' title='Instagram'><i class='instagrambtn'>instagram</i></button>
              <button onclick="window.open('http://www.libreriadiegoarica.cl', '_blank')" type='button' data-toggle='tooltip' data-placement='top' title='Pagina Web'><i class='material-icons public'>public</i></button>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/transition.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/custom.js"></script>
<script type="text/javascript" src="bajostock.js"></script>  
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>


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
  </body>
</html>
