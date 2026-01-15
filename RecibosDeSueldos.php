<?php
include 'index.php';

if(!(isset($_SESSION['empresa'])))
{
  header('Location: login.php');
}

$consulta='SELECT * FROM `empresa` WHERE `NumeroDeRUT`="'.$_SESSION['empresa'].'"';
$EmpresaDatos = ejecutarConsulta($consulta);


$consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
$todosLosMoviles=ejecutarConsulta($consulta);

$inicio = date("Y-m-01");
$fin = date("Y-m-t");
//$fecha=explode("-",date("Y-m-d",$inicio));
/*
    $_SESSION["desde"]=$inicio;
    $_SESSION["hasta"]=$fin;*/

if(isset($_SESSION["desde"]))
{
  $inicio = $_SESSION["desde"];
  $fin = $_SESSION["hasta"];
  
  //$fecha=explode("-",date("Y-m-d",$inicio));
  
  $inicio = strtotime($inicio."- 1 days");
  $fin = strtotime($fin."+ 1 days");
}

$empresaID=$EmpresaDatos[0]["id"];
$sql = "SELECT * FROM `planilladetrabajo` WHERE Fecha > '".date("Y-m-d",$inicio)." 23:59:59' AND Fecha < '".date("Y-m-d",$fin)." 00:00:00' AND EmpresaID ='$empresaID' AND Concepto = 'Recibo Sueldo'";
//echo "$sql";
$PlanillaDeTrabajo=ejecutarConsulta($sql);
$inicio= date("Y-m-d",strtotime(date("d-m-Y",$inicio)."+ 1 days"));
$fin= date("Y-m-d",strtotime(date("d-m-Y",$fin)."- 1 days"));
//echo "<br>";
//print_r($inicio);
$fecha=explode("-",$inicio);
//print_r($fecha);
//echo " " . $fecha[0];
$meces["01"]="Enero";
$meces["02"]="Febrero";
$meces["03"]="Marzo";
$meces["04"]="Abril";
$meces["05"]="Mayo";
$meces["06"]="Junio";
$meces["07"]="Julio";
$meces["08"]="Agosto";
$meces["09"]="Septiembre";
$meces["10"]="Octubre";
$meces["11"]="Noviembre";
$meces["12"]="Diciembre";
$recaudacion=0;
echo "<br>";
$cont=0;

?>

<html>
<head>
<style>
table {
  
    font-family: 'Overpass', sans-serif;
    font-weight: normal;
    font-size: 12px;
    color: #1b262c;
    border-collapse: collapse;
    padding: 0px;
    background-color: rgba(255, 255, 255, 0.7);
    
}
td {
  padding: 3px;
  height: 20px;
  vertical-align: middle;
}

.td2{
  vertical-align: top;
}


div.relative {
  position: relative;
  border: 3px solid #000000;
  padding: 5px;
}

div.relative2 {
  position: relative;
  border: 3px solid #000000;
  padding: 5px;
  width: 430px;
  height: 40px;
  font-size: 12px;
}

.titulo
{
  font-size:40px;
  border: 1px;
  border-style: solid;
  text-align: center;
  width:420px;
}
.emp
{
  font-size:40px;
  border: 1px;
  border-style: solid;
  text-align: center;
  width:130px;
}

.tot
{
  text-align: center;
  height:25px;
}


.firma
{
  text-align: center;
  height:45px;
}



</style>
</head>
<body>

<div class="container text-center abs-center">
  <?php 
      foreach($PlanillaDeTrabajo as $row)
      {
          echo '<a href="ReciboSueldo.php?RSID=',$row['Id'],'&CHID=',$row['ChoferID'],'">';
          echo $choferes[$row['ChoferID']]['Nombre'];
          echo "</a><br>";
          $cont++;
      }
  ?>
</div>

  <table class="table" border="1">
    

</table>
