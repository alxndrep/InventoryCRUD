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
            <section class="services">
              <div class="container-fluid">
                  <button style="margin-bottom: 10px;" type="button" class="btn btn-primary" onClick="location.href='new_ventas.php';" data-toggle="tooltip" data-placement="right" title="Crear nueva venta">
                    <i class="material-icons">library_add</i> <strong>Nueva venta</strong>
                  </button>
                <div class="row">
                    <div class="col-md-3">
                        <label for="spVendedor"><strong>Vendedor</strong></label><br/>
                        <select class="selectpicker show-tick" id="spVendedor" data-width="100%" title="Seleccionar Vendedor">
                            <option style="font-weight: bold" value="allventas">TODAS LAS VENTAS</option>
                            <option data-divider="true"></option>  
                            <option value="Carlos Avila Humire">Carlos Avila Humire</option>
                            <option data-divider="true"></option>    
                            <option value="William Vasquez Leon">William Vasquez Leon</option>
                            <option value="Magdiel Zumelzu de la Jara">Magdiel Zumelzu de la Jara</option>
                            <option value="Carmen Andrea Libre Santiago">Carmen Andrea Libre Santiago</option>
                            <option value="Maria Fernanda Guerra Guerrero">Maria Fernanda Guerra Guerrero</option>
                            <option value="Romina Campos Miranda">Romina Campos Miranda</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="spFechaInicio"><strong>Fecha desde</strong></label>
                        <input type="date" class="form-control" id="spFechaInicio" disabled> 
                    </div>
                    <div class="col-md-3">
                        <label for="spFechaTermino"><strong>hasta</strong></label>
                        <input type="date" class="form-control" id="spFechaTermino" disabled> 
                    </div>
                    <div class="col-md-4" style="display: none">
                        <label for="spCliente"><strong>Cliente</strong></label><br/>
                        <select class="selectpicker" id="spCliente" multiple data-actions-box="true" data-live-search="true" data-width="100%" data-size="10" disabled>
                        </select>   
                    </div>
                    <div class="col-md-1" style="text-align:center">
                    </div>
                    <div class="col-md-1" style="text-align:center">
                        <br/>
                        <button type="button" id="spbtnBuscar" class="btn btn-outline-primary" disabled>Buscar</button>
                    </div>
                </div>
                <hr>
                <!-- Div Row para la tabla, arrojando los resultados de la busqueda. -->
                <div class="row" style='display: none' id="contentBusqueda">
                    <table class="table table-sm table-hover" id="tablaBusqueda" style="width:100%">
                      <thead class="thead-dark">
                        <tr>
                          <th></th>
                          <th>Folio</th>
                          <th>Cliente</th>
                          <th>Fecha</th>
                          <th>Total</th>
                          <th class="lastth">Estado</th>
                        </tr>
                      </thead>
                      <tbody id="tablaventas">
                      </tbody>
                      <tfoot class="thead-dark">
                        <tr>
                          <th></th>
                          <th>Folio</th>
                          <th>Cliente</th>
                          <th>Fecha</th>
                          <th>Total</th>
                          <th class="lastth">Estado</th>
                        </tr>
                      </tfoot>
                    </table>
                </div>               
                
              </div>
            </section>
            <!-- Services -->
          </div>
        </div>
        <!-- Main -->


        <!-- Modal para productos -->
        <div class="modal fade" id="modalProductosVentas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" id="modalprintid">
              <div class="modal-header">
                <h5 class="modal-title">Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modalProductosContent">
              </div>
              <div class="modal-footer">
                <button estadoventa ="0" ventaid="0" class="btn btn-outline-primary btn-sm btnActualizarEstadoVenta">Actualizar Estado</button>
                <form action="edit_ventas.php" method="POST">
                  <button ventaid="0" class="btn btn-outline-primary btn-sm btnEditarVenta">Editar Venta</button>
                  <input type="hidden" class="tagventa_id" name="venta_id" value="0">
                </form>
                <button id="printBTN" ventaid="0" class="btn btn-outline-success btn-sm btnVerPDF">Imprimir</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal para productos -->


         <!-- Contenido para la impresion del DIV Borrador -->
        <div class="printable">
          <div class="row">
            <div class="col-sm-7">
              <p>
                <dt class="col-sm-12">
                  <img src="https://libreriadiegoarica.cl/wp-content/uploads/2021/02/cropped-logoLDA.png" width="135px" height="120px" style="float: left; border: 2px solid grey; margin-right: 10px">
                  <span style="font-weight: bolder; font-size: 12pt;">Carlos Omar Ávila Humire<br/>
                  10.335.767-5<br/></span>
                  <p style="line-height: 12pt; font-size: 8pt; font-weight: bold;">
                  Distribuidora de Articulos de librería, perfumería y aseo personal.<br/>
                  Casa Matriz: Lastarrias #1320<br/>
                  Fono: 9 96895212 - Whatsapp: 9 31715469<br/>
                  Arica - Chile
                </p>
                </dt>
                
              </p>
            </div>
            <div class="col-sm-4">
              <br/>
              <div class="d-flex flex-column" style="border: 2px solid red; text-align: center; font-weight: bold;">
                <small><strong>
                  <div class="p-2">RUT 10.335.767-5</div>
                  <div class="p-2" id="tipoVenta" isborrador=""></div>
                  <div class="p-2">Nº <span id="borradorFolio"></span></div>
                </small></strong>
              </div>
              <p style="text-align: center; font-size: 10pt">S.I.I. - ARICA Y PARINACOTA</p>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-11">
              <table class="table table-sm table-bordered" id="borradorDatos" style="width:98%">
                <tbody>
                  <tr>
                    <th class="table-active">Señor(es)</th>
                    <td class="second" id="borradorNombre"></td>
                    <th class="table-active">RUT</th>
                    <td class="fourth" id="borradorRut"></td>
                  </tr>
                  <tr>
                    <th class="table-active">Giro</th>
                    <td class="second" id="borradorGiro"></td>
                    <th class="table-active">Fecha Emisión</th>
                    <td class="fourth" id="borradorFecha"></td>
                  </tr>
                  <tr>
                    <th class="table-active">Dirección</th>
                    <td class="second" id="borradorDireccion"></td>
                    <th class="table-active">Comuna</th>
                    <td class="fourth" id="borradorComuna"></td>
                  </tr>
                  <tr>
                    <th class="table-active">Contacto</th>
                    <td class="second" id="borradorContacto"></td>
                    <th class="table-active">Vendedor</th>
                    <td class="fourth" id="borradorVendedor"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 tablaborrador">
              <table class="table table-sm table-bordered" id="borradorProductos" style="width:90%">
                <thead style="text-align:center;" class="table-active">
                    <th colspan="5">DETALLES</th>
                  <tr>
                    <th style="width: 13%"><small>Código</small></th>
                    <th style="width: 41%"><small>Descripción</small></th>
                    <th style="width: 10%"><small>Cantidad</small></th>
                    <th style="width: 18%"><small>Precio Unitario</small></th>
                    <th style="width: 18%"><small>Total</small></th>
                  </tr>
                </thead>
                <tbody id="borradorProductosBody">
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
           <div class="col-sm-12">
              <p style="text-align:left">
                <table class="table table-sm table-bordered" style="width:90%">
                  <tbody style="text-align:center;">
                      <th class="table-active" colspan="2">Notas de la venta</th>
                    <tr>
                      <td><span id="borradorNotaTexto" style="width:90%"></span></th>
                    </tr>
                  </tbody>
                </table>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-7">
            </div>
            <div class="col-sm-2">
              <p style="text-align:right">
                <table class="table table-sm table-bordered" id="borradorTotales" style="width:250px">
                  <tbody style="text-align:center;">
                      <th class="table-active" colspan="2">Totales</th>
                    <tr>
                      <th class="table-active" style="text-align: left">Monto Neto</th>
                      <td style="width: 50%"><span id="borradorNeto"></span></th>
                    </tr>
                    <tr>
                      <th class="table-active" style="text-align: left">IVA 19%</th>
                      <td style="width: 50%"><span id="borradorIVA"></span></th>
                    </tr>
                    <tr>
                      <th class="table-active" style="text-align: left">Total</th>
                      <td style="width: 50%"><span id="borradorTotal"></span></th>
                    </tr>
                  </tbody>
                </table>
              </p>
            </div>
          </div>


        </div>
        <!-- Contenido para la impresion del DIV Borrador -->

        <!-- Toast notification push up -->

        <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
          <div id="pushNotificationToast" class="toast" data-delay="5000" style="margin: 30px; position: fixed; top: 0; right: 0; background: white !important;">
            <div class="toast-header">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.1.2/css/bootstrap-toaster.min.css" integrity="sha512-kYPLvO+Bu+xttOhbQvxs9nx7XSdxrb2JexRxQ3CpJQ7EtmlkBsWyOjlinLgiLWeLxuupFYB4cPqLOo0gnBnzeQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/transition.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/custom.js"></script>
<script src="allventas2.js"></script>
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
