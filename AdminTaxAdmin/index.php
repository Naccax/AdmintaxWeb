<?php
//UPDATE `recaudaciones` SET `Observaciones` = 'Hora de Carga' WHERE `recaudaciones`.`id` = 3318;
//include '../funciones.php';
include './funciones.php';
session_start();
//print_r($_SESSION);
if(isset($_SESSION['usuario']))
{
    //echo"Usuario: " . $_SESSION['usuario'];
    //$todosLosMoviles
    $consulta="SELECT * FROM `movil`";
    $todosLosMoviles=ejecutarConsulta($consulta);
    //print_r($todosLosMoviles);
    
    $consulta="SELECT * FROM `chofer`";
    $todosLosChoferes=ejecutarConsulta($consulta);
    $choferes=[];

    foreach($todosLosChoferes as $chofer)
    {
      $choferes[$chofer['id']]=$chofer;
    }
    
    $consulta="SELECT * FROM `empresa`";
    $todasLasEmpresas=ejecutarConsulta($consulta);
    $empresas=[];

    foreach($todasLasEmpresas as $empresa)
    {
      $empresas[$empresa['id']]=$empresa;
    }
    //print_r($todosLosChoferes);

    
    //$consulta='SELECT * FROM `empresa` WHERE `NumeroDeRUT`="'.$_SESSION['empresa'].'"';
    //$EmpresaDatos = ejecutarConsulta($consulta);
    
    //print_r($EmpresaDatos);


}else
{
    header('Location:../login.php');
}
if(isset($_GET['salir']))
{
    session_destroy();
    header('Location: ../login.php');
}
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="./funciones.js"> </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/index.js"></script>
    <title>AdminTax</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <LINK REL=StyleSheet HREF="css/index.css" TYPE="text/css" MEDIA=screen>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    
</head>

<body class="background-color: red;">
<div id="menu"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">AdminTax</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
        <!--
      <li class="nav-item active">
        <a class="nav-link" href="choferesTodos.php">Choferes<span class="sr-only"></span></a>
      </li>-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choferes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="ChoferesNuevo.php">Agregar Nuevo</a>
            <a class="dropdown-item" href="choferesTodos.php">Ver Todos</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Moviles
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="movilesNuevo.php">Agregar Nuevo</a>
            <a class="dropdown-item" href="movilesMultasYDeducibles.php">Multas y deducibles</a>
            <a class="dropdown-item" href="movilesTodos.php">Ver Todos</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Ajustes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="LaudosTodos.php">Ludos y otros</a>
            <a class="dropdown-item" href="IRPFParametros.php">IRPF Parámetros</a>
            <a class="dropdown-item" href="RetroActivosTodos.php">Retroativos (Parametros)</a>
            <a class="dropdown-item" href="RetroactivosAplicar2.php">Retroativos (Realizar C&aacute;lculos)</a>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../index.php?salir=si"><?php echo"Usuario: " . $_SESSION['usuario'];?><span class="sr-only">(Salir)</span></a>
      </li>
    </ul>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script >
</script>
</body>

</html>