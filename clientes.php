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
                    <h2 style="text-align: center; text-decoration: underline;" class="text-danger">Clientes Registrados</h2>                    
                    
                    <!-- Modal Form Productos -->
                    <!-- Button trigger modal -->
                    <button style="margin-bottom: 10px;" type="button" id="btnNuevo" class="btn btn-primary" data-toggle="modal tooltip" data-placement="top" title="Nuevo Cliente" data-target="#modalFormClientes">
                      <i class="material-icons">library_add</i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalFormClientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form id="formClientes">    
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                      <label for="" class="col-form-label">Rut:</label>
                                      <input type="text" class="form-control" id="rut" required>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Razon Social</label>
                                    <input type="text" class="form-control" id="razon_social" required>
                                    </div> 
                                    </div>    
                                </div>
                                <div class="row"> 
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Giro</label>
                                    <input type="text" class="form-control" id="giro" required>
                                    </div>               
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="" class="col-form-label">Correo</label>
                                    <input type="email" class="form-control" id="email">
                                    </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="" class="col-form-label">Contacto</label>
                                        <input type="text" class="form-control" id="contacto">
                                        </div>
                                    </div>    
                                    <div class="col-lg-6">    
                                        <div class="form-group">
                                        <label for="" class="col-form-label">Comuna</label> <!-- Cambiar a select type -->
                                        <input type="text" class="form-control" id="comuna">
                                        </div>     
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                        <label for="" class="col-form-label">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" required>
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
                    <!-- Modal Form Clientes -->

                    <!-- Modal para aceptar crear la venta y mostrar Borrador -->
                    <div class="modal fade" id="modalNotificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="alert alert-success" role="alert" id="modalNotificacionBody">
                              <strong>Cliente creado con exito.</strong> <br/><small>Ahora es posible asignar nuevas ventas al cliente registrado.</small>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btnCerrarVentaGuardada" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal para aceptar crear la venta y mostrar Borrador -->

                    <!-- Tabla de Clientes -->
                    <div class="table-responsive">
                      <table class="table table-striped display" id="tablaClientes" style="width:100%">
                        <thead>
                          <tr>
                            <th style="min-width:10%; width:10%">Rut</th>
                            <th>Razon Social</th>
                            <th>Giro</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <th>Direcciones</th>
                            <th>Comuna</th>
                            <th class="lastth">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Rut</th>
                            <th>Razon Social</th>
                            <th>Giro</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <th>Direcciones</th>
                            <th>Comuna</th>
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
        <!-- Main -->

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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/transition.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/custom.js"></script>
<script type="text/javascript" src="clientes.js"></script>  
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
