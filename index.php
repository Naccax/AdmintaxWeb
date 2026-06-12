<?php
include 'funciones.php';
session_start();
//session_start() crea la variable de sesion $_SESSION, que es como un hashmap, 
//donde se pueden guardar datos que se mantendrán a lo largo de la sesión del usuario.
include 'utils/navbarData.php';
?>

<!DOCTYPE html>
<html lang="es">
  <?php include 'utils/head.php';?>
  <body>
    <div id="menu"></div>
    <?php include 'utils/navbar.php';?>
    <?php include 'utils/scriptsBootstrap.php';?>
  </body>
</html>