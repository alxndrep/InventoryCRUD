<?php 
    require 'phplibrary.php';

    function showNotifications(){
    //  echo "<div class='notificationbox visible' id='display-panel'>
    //    <button class='closeBox' id='closebutton'>X</button>
    //    <h3>Notificaciones</h3>
    //    <p>Productos bajo stock critico: <b><u><span class='bajostock'></span></b></u><br/> Para ver los productos haga <a href='productos_bajostock.php'>click aqui</a></p>
    //    <hr>
    //    <button onclick='window.location.href=`new_ventas.php`' type='button' data-toggle='tooltip' data-placement='top' title='Pagina Web'>Nueva Venta</button>
    //    <button onclick='window.location.href=`allventas2.php`' type='button' data-toggle='tooltip' data-placement='top' title='Pagina Web'>Ver Ventas</button>
    //    <button onclick='window.location.href=`productos.php`' type='button' data-toggle='tooltip' data-placement='top' title='Pagina Web'>Inventario</button>
    //  </div>";
    //  echo "<script src='notifications/main.js'></script>";
    }

    function execMenu(){           
      echo "       <div id='sidebar'>
      <div class='inner'>
        <!-- Search Box -->
        <section id='search' class='alt'>
          <p><img src='https://libreriadiegoarica.cl/wp-content/uploads/2021/02/cropped-logoLDA.png'> <span><b> Fecha: <br/></b><u>"; getFecha(); echo "</u></span></p>
          <p><b>Bienvenido nuevamente</b><br/> <u id='user_username' usertype='". $_SESSION['usertype'] ."'>". $_SESSION['username']. "</u></p>
        </section>
        <!-- Menu -->
        <nav id='menu'>
          <ul>
            <li><a href='home.php'>Inicio</a></li>
            <li>
              <span class='opener'>Inventario</span>
              <ul>
                <li><a href='productos.php'>Lista de Productos</a></li>
                <li><a href='productos_bajostock.php'>Productos criticos</a></li>
              </ul>
            </li>
            <li>
              <span class='opener'>Ventas</span>
              <ul>
                <li><a href='new_ventas.php'>Nueva Venta</a></li>
                <li><a href='tus_ventas.php'>Tus Ventas</a></li>
                <li><hr style='color: black; border: 1px solid black'></li>
                <li><a href='import_ventas.php'>Importar Ventas</a></li>
                <li><a href='allventas2.php'>Todas las Ventas</a></li>
              </ul>
            </li>
            <li><a href='informes.php'>Ver Informes</a></li>
            <li><a href='clientes.php'>Clientes</a></li>
            <li></li>
          </ul>
        </nav>
        ";
    }
?>