<?php require 'phplibrary.php' ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="no-cache" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Inventario para la libreria diego">
        <meta name="author" content="Alexander 'inaudit0' Escarate">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <title>Inventario - Libreria Diego</title>
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/fontawesome.css">
        <link rel="stylesheet" href="assets/css/templatemo-style.css">
        <link rel="stylesheet" href="assets/css/owl.css">
    </head>
    <body>
        <?php 
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
                unset($_SESSION['logged']);
            }
            if(isset($_SESSION['logged'])){
                if($_SESSION['logged']){
                    echo "<script>location.href='home.php';</script>";
                }else{
                    echo "<script>location.href='loginfiles/index.html';</script>";
                }
            }else{
                echo "<script>location.href='loginfiles/index.html';</script>";
            }
            
        ?>
        
    </body>
</html>