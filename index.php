<?php
//UPDATE `recaudaciones` SET `Observaciones` = 'Hora de Carga' WHERE `recaudaciones`.`id` = 3318;
include 'funciones.php';
session_start();
//print_r($_SESSION);
if(isset($_SESSION['usuario']))
{
    //echo"Usuario: " . $_SESSION['usuario'];
    //$todosLosMoviles
    $consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
    $todosLosMoviles=ejecutarConsulta($consulta);
    //print_r($todosLosMoviles);
    
    $consulta="SELECT * FROM `chofer` WHERE RUT='".$_SESSION['empresa']."'";
    $todosLosChoferes=ejecutarConsulta($consulta);
    $choferes=[];

    foreach($todosLosChoferes as $chofer)
    {
      $choferes[$chofer['id']]=$chofer;
    }
    //print_r($todosLosChoferes);

    
    $consulta='SELECT * FROM `empresa` WHERE `NumeroDeRUT`="'.$_SESSION['empresa'].'"';
    $EmpresaDatos = ejecutarConsulta($consulta);
    
    //print_r($EmpresaDatos);


}else
{
    header('Location: login.php');
}
if(isset($_GET['salir']))
{
    session_destroy();
    header('Location: login.php');
}


$empresaID=$EmpresaDatos[0]["id"];

$sql = 'SELECT * FROM `chofer` WHERE RUT="'.$EmpresaDatos[0]["NumeroDeRUT"].'"';
//echo "$sql";
$ListaDeChoferes=ejecutarConsulta($sql);

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
    <script>
    $(document).ready(function(){
      $("#hide").click(function(){
        $(".cat1").hide();
      });
      $("#show").click(function(){
        $(".cat1").show();
      });
    });
    
    $(document).ready(function(){
      $("#hide2").click(function(){
        $(".cat2").hide();
      });
      $("#show2").click(function(){
        $(".cat2").show();
      });
    });
    
    $(document).ready(function(){
      $("#hide3").click(function(){
        $(".cat3").hide();
      });
      $("#show3").click(function(){
        $(".cat3").show();
      });
    });

    
    $(document).ready(function(){
      $("#hide4").click(function(){
        $(".cat4").hide();
      });
      $("#show4").click(function(){
        $(".cat4").show();
      });
    });

    $(document).ready(function(){
      $("#hide5").click(function(){
        $(".cat5").hide();
      });
      $("#show5").click(function(){
        $(".cat5").show();
      });
    });

    $(document).ready(function(){
      $("#hide6").click(function(){
        $(".cat6").hide();
      });
      $("#show6").click(function(){
        $(".cat6").show();
      });
    });

    $(document).ready(function(){
      $("#hide7").click(function(){
        $(".cat7").hide();
      });
      $("#show7").click(function(){
        $(".cat7").show();
      });
    });

    $(document).ready(function(){
      $("#hide8").click(function(){
        $(".cat8").hide();
      });
      $("#show8").click(function(){
        $(".cat8").show();
      });
    });
    
    $(document).ready(function(){
      $("#hide9").click(function(){
        $(".cat9").hide();
      });
      $("#show9").click(function(){
        $(".cat9").show();
      });
    });

    </script>
</head>

<body class="background-color: red;">
<div id="menu"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="graficas.php">AdminTax</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          M&oacute;viles
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
          
            echo '<a class="dropdown-item" href="movilesMultasYDeducibles.php">';
            echo 'Multas y deducibles','</a>';
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="moviles2.php?plate=',$movil['Id'],'">';
              echo $movil['Matricula'],'</a>';
              $_SESSION["EmpresaID"]=$movil['NumEmpresa'];
            }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Choferes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosChoferes as $chofer)
            {
              echo '<a class="dropdown-item" href="Choferes.php?Id=',$chofer['id'],'">';
              echo $chofer['Nombre'],'</a>';
            }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Recaudaciones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="recaudaciones2.php?plate=',$movil['Matricula'],'">';
              echo $movil['Matricula'],'</a>';
            }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Reportes de Varela
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="moviles.php?plate=',$movil['Matricula'],'">';
              echo $movil['Matricula'],'</a>';
            }
          ?>
        </div>
      </li><!--
      <li class="nav-item active">
        <a class="nav-link" href="ResumenFinalDeEmpresa.php">Resumen de Empresa<span class="sr-only"></span></a>
      </li>-->
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Resumen de Empresa
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="ResumenFinalDeEmpresa.php">Balance mensual</a>
          <a class="dropdown-item" href="#">Estado General</a>
        </div>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="Vinculos.php">Vínculos<span class="sr-only"></span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Mantenimientos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="movilesMantenimientos.php?plate=',$movil['Matricula'],'">';
              echo $movil['Matricula'],'</a>';
              $_SESSION["EmpresaID"]=$movil['NumEmpresa'];
            }
          ?>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?salir=si"><?php echo"Usuario: " . $_SESSION['usuario'];?><span class="sr-only">(Salir)</span></a>
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