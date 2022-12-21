<?php 
    session_start();
    if(isset($_SESSION['logged'])){
        if(!$_SESSION['logged']){
            echo "<script>location.href='loginfiles/index.html';</script>";
        }
    }else{
        echo "<script>location.href='loginfiles/index.html';</script>";
    }
    
    function getFecha(){
        date_default_timezone_set('America/Santiago');
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        echo (date('d'))." de ".$meses[date('n')-1]. " del ".date('Y') ;
    }

    function IsNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }

    function isUserVendedor(){
        if($_SESSION['usertype'] == 0){
            echo "<script>location.href='not_access.php';</script>";
        }
    }
    
    function redirectNewAllVentas(){
        echo "<script>location.href='allventas2.php';</script>";
    }


?>