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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">

    <title>Inventario - Libreria Diego</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" media="all">

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
                    <div class="down-content">
                      <form id="nventa">
                        <div class="row">
                          <h2>Nueva Venta</h2>
                          <hr>
                          <div class="form-group col-md-6">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary btnBuscarRut" type="button">Buscar</button>
                              </div>
                              <input type="text" class="form-control" id="nvrut" placeholder="Rut Cliente" onkeypress="enterKeyClientesRUT(event)" required>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary btnBuscarNombre" type="button">Buscar</button>
                              </div>
                              <input type="text" class="form-control" id="nvcliente" placeholder="Nombre Cliente" onkeypress="enterKeyClientesRazon(event)" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="alert alert-danger" id="errornvcliente" style="display: none;">
                            </div>
                          </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <label for="nvdireccion">Giro</label>
                            <input type="text" class="form-control" id="nvgiro" placeholder="Giro, ej.: Almacen" disabled>
                          </div>
                          <div class="form-group col-md-3">
                            <label for="nvcomuna">Fecha</label>
                            <input type="date" class="form-control" id="nvfecha"> 
                          </div>
                          <div class="form-group col-md-3">
                            <label for="nvfolio">Folio Venta:</label>
                            <input type="number" class="form-control" id="nvfolio" placeholder="Folio generado al guardar la venta" disabled>
                          </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <label for="nvdireccion">Direccion</label>
                            <input type="text" class="form-control" id="nvdireccion" placeholder="Direccion de despacho, ej.: Lastarrias #1320" disabled>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="nvcomuna">Comuna</label>
                            <input type="text" class="form-control" id="nvcomuna" placeholder="Arica" disabled>
                          </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;"> 
                          <div class="form-group col-md-6">
                            <label for="nvcontacto">Contacto</label>
                            <input type="text" class="form-control" id="nvcontacto" placeholder="Nro. telefono o correo" disabled>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="nvvendedor">Vendedor</label>
                            <input type="text" class="form-control" id="nvvendedor" placeholder="Nombre vendedor" required>
                          </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;"> 
                          <div class="form-group col-md-12">
                            <label for="nvcontacto"><strong>NOTAS DE LA VENTA</strong></label>
                            <input type="text" class="form-control" id="nvnotas" placeholder="Adjuntar alguna nota o especificacion de la venta...">
                          </div>
                        </div>
                        <div class="row"> 
                          <div class="form-group col-md-12" style="text-align: right;">
                            <input class="btn btn-outline-secondary btnReset" type="reset" value="Limpiar">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Tabla de productos en la venta -->
                <div id="divTablaProductos" style="display: none;">
                  <br/>
                  <table class="table" id="nvproductos">
                    <thead>
                      <tr>
                        <th style="width:24px;"></th>
                        <th style="width:100px;">Codigo</th>
                        <th style="width:150px;">Nombre / Descripcion</th>
                        <th style="width:100px;">Cantidad</th>
                        <th style="width:100px;">Precio</th>
                        <th class="lastth" style="width:100px;">Total</th>
                      </tr>
                    </thead>
                    <tbody id="tbodynvproductos">
                      <tr id="rowAddProduct" class="rowAddProduct">
                        <td><button class='btn btn-primary btn-sm btnAddProducto'></button></td>
                        <td></td>
                        <td><b><i>Agregar producto nuevo</b></i></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>Codigo</th>
                        <th>Nombre / Descripcion</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th class="lastth">Total</th>
                      </tr>
                    </tfoot>
                  </table>
                  Limite de productos:
                  <div class="progress" style="height: 25px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" id="barraLimiteProductos" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                  <hr>
                  <div class="form-group col-md-12">
                    <div class="row" style="text-align: right;">
                      <dt class="col-sm-10">Monto neto:</dt>
                      <dd class="col-sm-2"><span id="nvtotalneto"></span></dd>
                      <dt class="col-sm-10">19% IVA</dt>
                      <dd class="col-sm-2"><span id="nviva19"></span></dd>   
                      <dt class="col-sm-10">Total:</dt>
                      <dd class="col-sm-2"><span id="nvtotalmonto"></span></dd>     
                    </div>
                    <br>
                    <div style="text-align: right;">
                      <button class="btn btn-primary" form="nventa">Guardar Venta</button>
                    </div>
                    <div class="alert alert-danger" role="alert" id="diverroralert" style="text-align:center; margin-top:5px; display: none;">
                      Hay productos sin una <strong>cantidad</strong> asignada, rellene los campos faltantes o borre los productos.
                    </div>
                  </div>
                  
                </div>
                
                <!-- Tabla de productos en la venta -->

              </div>
            </section>
            <!-- Services -->
          </div>
        </div>
        <!-- Main -->
        <!-- Modal para la tabla de productos-->
        <div class="modal fade bd-example-modal-lg" id="modalListaProductos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  X
                </button>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                  <table class="display compact" id="tablaClientes" style="width:100%">
                    <thead>
                      <tr>
                        <th class="lastth"></th>
                        <th>Codigo</th>
                        <th>Nombre del Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal para la tabla de productos-->

        <!-- Modal para la tabla de clientes a seleccionar -->
        <div class="modal fade bd-example-modal-lg" id="nvclientesbuscados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Clientes encontrados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  X
                </button>
              </div>
              <div class="modal-body">
                <div class="verticalscroll" id="modal-body-clientes">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal para la tabla de clientes a seleccionar -->

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
                <small>
                  <div class="p-2">RUT 10.335.767-5</div>
                  <div class="p-2" id="tipoVenta">B O R R A D O R</div>
                  <div class="p-2">Nº <span id="borradorFolio"></span></div>
                </small>
              </div>
              <p style="text-align: center; font-size: 10pt">S.I.I. - ARICA Y PARINACOTA</p>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <table class="table table-sm table-bordered" id="borradorDatos" style="width:90%">
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
        
        <!-- Modal para aceptar crear la venta y mostrar Borrador -->
        <div class="modal fade" id="modalCrearVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                  <strong>Esta a punto de crear la venta.</strong> <br/><small> Para confirmar, presione el boton de guardar venta.</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="guardarVentaDB()" class="btn btn-primary">Guardar Venta</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal para aceptar crear la venta y mostrar Borrador -->


        <!-- Modal para aceptar crear la venta y mostrar Borrador -->
        <div class="modal fade" id="modalVerPDFVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="alert alert-success" role="alert">
                  <strong>Venta creada con exito.</strong> <br/><small>Puede visualizar el PDF del borrador generado automaticamente de la venta presionando el boton correspondiente.</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnCerrarVentaGuardada" data-dismiss="modal">Cerrar</button>
                <button onclick="printDocumento()" type="button" class="btn btn-outline-success">Ver Documento PDF</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal para aceptar crear la venta y mostrar Borrador -->

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


        <!-- Modal para crear un nuevo cliente -->
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
        <!-- Modal para crear un nuevo cliente -->


        
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
<script src="ventaproductos.js"></script>
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
      $("input").hover(function(){
        $(this).tooltip('show');
      });
    </script>
    <?php 
      showNotifications();
    ?>

  </body>
</html>
