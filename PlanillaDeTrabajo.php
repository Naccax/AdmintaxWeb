<?php
//include 'index.php';
session_start();
if(!(isset($_SESSION['empresa'])))
{
  if(!(isset($_GET['Token'])))
  {
    header('Location: login.php');
  }
}
include 'funciones.php';
if((isset($_GET['Token'])))
{
  $consulta="SELECT * FROM tokens WHERE token='".$_GET['Token']."';";
  //echo $consulta;
  $token=ejecutarConsulta($consulta);
  if(isset($token[0]['token']))
  {
    $_SESSION['empresa']=$token[0]['empresa'];
    
    $_SESSION["desde"]=$token[0]['desde'];
    $_SESSION["hasta"]=$token[0]['hasta'];
    $consulta="Select NumEmpresa from movil where NumRut='".$token[0]['empresa']."';";
    $arraySQL=ejecutarConsulta($consulta);
@    $_SESSION["EmpresaPatronal"]= $arraySQL[0][0];

  }
  else
  {
    header('Location: login.php');
  }
  //ejecutarConsulta($consulta);
}
$consulta='SELECT * FROM `empresa` WHERE `NumeroDeRUT`="'.$_SESSION['empresa'].'"';
$EmpresaDatos = ejecutarConsulta($consulta);
//echo $consulta;

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
//print_r($PlanillaDeTrabajo);
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


body {
    background: linear-gradient(#ff0000, #000000);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-image: url("./img/favicon.png");
    background-repeat: no-repeat, repeat;
    background-color: #cccccc;
    background-size:contain;
    background-position: center;
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




<table>
<tr>
<td width='80'>
</td>
<td>
<table class="table" border="1" width='205'>
<tr>
<td><b>Mes</td><td><?php echo $meces[$fecha[1]]; ?></td>
</tr>
<tr>
<td><b>Año</td><td><?php echo $fecha[0]; ?></td>
</tr>
</table>
<td width='25'></td>
  <td class="titulo" border="1" aling="center"><b>
    <p> <a href="ResumenDeEmpresa.php">C.P.A.T.U</a> 
  </td>
<td width='15'>
</td>
<td class="emp" border="1">
<?php
if(isset($_SESSION["EmpresaPatronal"]))
{
  $_SESSION["EmpresaID"]=$_SESSION["EmpresaPatronal"];
} 
if (isset($_SESSION["EmpresaID"]))
{
  echo $_SESSION["EmpresaID"]; 
}
?>
</td>
</tr>  
</table>


<br>




  <table class="table" border="1">
    <tr>
    <td rowspan='3' width='65'><b>Cédula</td>
    <td rowspan='3' width='187'><b>Nombre Completo</td>
            <td rowspan='3'><b>Remun-<br>eración<br>Total</b></td>
      <td rowspan='3'><b>Recau-<br>dación<br>Total</td>
        <th colspan="8">Jornales Horas y Montos por tipo de día </td>
          <td colspan="2" rowspan='2'><b>Feriados<br>No laborable<br>No trabajados </td>
            <td rowspan='2' colspan="2"><b>Jornales no trab. <br>por causas no<br>imputables al<br>trabajador</b></td>
            <td rowspan='3'><b>Partici-<br>pación</b></td>
            <td rowspan='3'><b>Monto<br>Bruto</b></td>
    
    </tr>
    <tr>
      <th  colspan="4">Comúnes</b></td><th  colspan="4">Feriados</b></td>
      
    </tr>
    <tr>
      <td><b>Jornales</b></td> <td><b>Horas <br>Comúnes</b></td><td><b>Horas <br>Extra</td> <td><b>Monto <br>Abonado</b></td>
      <td><b>Jornales</b></td> <td><b>Horas <br>Comúnes</b></td><td><b>Horas <br>Extra</b></td> <td><b>Monto <br>Abonado</b></td>
      <td><b>Jornales</b></td><td><b>Monto</b></td>
      <td><b>Jornales</b></td><td><b>Monto</b></td>
    </tr>
    <?php 
		$SumaMontoBruto=0;
        foreach($PlanillaDeTrabajo as $row)
        {
          if($row['Comunes_Jornales']!=0)
          {
            echo "<tr>";
            echo "<td>";
            echo $choferes[$row['ChoferID']]['ci'];
            echo "</td>";
            echo "<td>";
            echo $choferes[$row['ChoferID']]['Nombre'];
            echo "</td>";
            echo "<td>";
            echo $row['RemuneracionTotal'];//RemuneracionTotal
            echo "</td>";
            echo "<td>";
            echo $row['Recaudacion'];
            $recaudacion=$recaudacion+$row['Recaudacion'];
            echo "</td>";

            echo "<td>";
            echo $row['Comunes_Jornales'];
            echo "</td><td>";
            echo $row['Comunes_HsComunes'];
            echo "</td><td>";
            echo $row['Comunes_HsExtra'];
            echo "</td><td>";
            echo $row['Comunes_MontoAbonado'];
            echo "</td><td>";
            echo "0";
            echo "</td><td>";
            echo "0";
            echo "</td><td>";
            echo "0";
            echo "</td><td>";
            echo "0";
            echo "</td><td>";
            echo $row['FeriadosNoLaborables_Cant'];
            echo "</td><td>";
            echo $row['FeriadosNoLaborables_Monto'];
            echo "</td><td>";
            echo $row['No_imponible'];
            echo "</td><td>";
            echo $row['No_imponible_val'];
            echo "</td><td>";
            echo $row['participacion_monto'];
            echo "</td><td>";
            echo $row['TotalBruto'];
			$SumaMontoBruto=$SumaMontoBruto+$row['TotalBruto'];
            echo "</td>";
            echo "</tr>";
            $cont++;
            
          }
        }
        while($cont < 15)
        {
          echo"<tr>";
          $cols=0;
          while ($cols < 18)
          {
            if(true)
            {
              echo "<td></td>";
            }
            $cols++;
          }
          echo"</tr>";
          $cont++;
        }
        echo "<tr><td colspan='2' class='tot'></td><td></td><td>".$recaudacion."</td><td colspan='13'></td><td>".$SumaMontoBruto."</td></tr>";
    ?>

</table>
<br>
<table border="0">
<tr>
  <td width='140'>
  </td>
  <td>
<table border="1" class="tot"><tr><td width='137'><b>Razón Social: </td>
<td width='520'><?php echo $EmpresaDatos[0]["Nombre"]; ?></td>
</tr>
</table>
  </td>
</tr>
</table>
<table border="0"><tr><td width='40'></td>
<td class="td2">
<div class="relative"><b>
  CONSUMO DE LITROS COMBUSTIBLE <BR>
  Ley N° 19168 del 25/11/2023
</div>
</td>
<td width='40'></td>
<td>
  
<div class="relative2"><b>
  <?php
    $xx=0;
    $ii=0;
    foreach($todosLosMoviles as $movil)
    {
      if($ii < 2)
      {
        echo " Mat. <u><b>".$movil["Matricula"]. "</u></b> Lts.<u><b>___________</u></b>&nbsp;&nbsp;&nbsp;";
      }
      $ii++;
      if($ii==2)
      {
        echo "<br>";
        $ii=0;
      }
      $xx++;
    }
    
    while($xx<5)
    {
      if($ii < 2)
      {
        echo " Mat. <u><b>"."___________". "</u></b> Lts.<u><b>___________</u></b>&nbsp;&nbsp;&nbsp;";
      }
      $ii++;
      if($ii==2)
      {
        echo "<br>";
        $ii=0;
      }
      $xx++;
    }
  ?>
</div>

</td></tr></table>

<table border="0">
<tr>
  <td width='140'>
  </td>
  <td>
<table border="3" class="tot"><tr><td class="firma"></td></tr><tr>
<td width='250'><b>Firma</td></tr></table>

  </td>
  <td width='80'></td>
  <td>
<table border="3" class="tot"><tr><td class="firma"></td></tr><tr>
<td width='350'><b>Aclaración</td></tr></table> 
</td>
</tr>
</table>
<?php
$consulta="DELETE FROM tokens WHERE token='".$_GET['Token']."';";
//ejecutarConsulta($consulta);
?>