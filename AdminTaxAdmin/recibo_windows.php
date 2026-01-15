<?php
//include 'index.php';
session_start();

$colores[43]="F1C2B7";
$colores[44]="ffffff";
$colores[45]="F1C2B7";
$colores[46]="ffffff";

$meses["01"]="Enero";
$meses["02"]="Febrero";
$meses["03"]="Marzo";
$meses["04"]="Abril";
$meses["05"]="Mayo";
$meses["06"]="Junio";
$meses["07"]="Julio";
$meses["08"]="Agosto";
$meses["09"]="Septiembre";
$meses["10"]="Octubre";
$meses["11"]="Noviembre";
$meses["12"]="Diciembre";
$meses["13"]="Enero";

include 'funciones.php';
$leyenda1="Declaro: Haber efectuado los aportes a la Seguridad Social Correspondiente al mes anterior según Dto. 113/96.<br>";
$leyenda2="La empresa a solicitud expresa del Trabajador, se deslinda de efectuar los aportes correspondientes a la Seguridad Social, quedando los mismos bajo su propia responsabilidad<br>";
$leyenda3="";
$leyenda4=": solicitando al empleador, no realizar los aportes correspondientes a la Seguridad Social, quedando los mismos bajo mi propia responsabilidad.<br>";
$leyenda=$leyenda1;


if (isset($_GET["rsid"]))
{
  $sql="SELECT *  FROM planilladetrabajo WHERE Id='".$_GET["rsid"]."'";
  $planillaDeTrabajo=ejecutarConsulta($sql);
}
//echo $sql;
if($planillaDeTrabajo[0]["Concepto"]=="Licencia Aportación")
{
  $planillaDeTrabajo[0]["Concepto"]="Salario Vacacional y Licencia";
}
elseif($planillaDeTrabajo[0]["Concepto"]=="Aguinaldo Aportación")
{
  $planillaDeTrabajo[0]["Concepto"]="Aguinaldo";
}
/*
if ((isset($_GET["f"])) AND ($planillaDeTrabajo[0]["FonasaAplicado"]=="0"))
{
  $planillaDeTrabajo[0]["FonasaAplicado"]=$_GET["f"];
  $update="UPDATE planilladetrabajo SET  FonasaAplicado = '".$_GET["f"]."' WHERE Id='".$_GET["rsid"]."'";
  update($update);
}*/

//EmpresaDatos
$sql="SELECT * FROM empresa WHERE id='".$planillaDeTrabajo[0]["EmpresaID"]."';";
$EmpresaDatos=ejecutarConsulta($sql);

//ChoferDatos
$sql="SELECT * FROM chofer WHERE Id='".$planillaDeTrabajo[0]["ChoferID"]."';";
$ChoferDatos=ejecutarConsulta($sql);

$fechaArray = explode('-',$planillaDeTrabajo[0]["Fecha"]);
$fechaLiquidacion=$meses[$fechaArray[1]].' / '.$fechaArray[0];
$fechaLiquidacion2=$fechaLiquidacion;

if($planillaDeTrabajo[0]["Concepto"]=="Salario Vacacional y Licencia")
{
  $fechaArray2 = explode('-',$planillaDeTrabajo[0]["Fecha"]);
  $fechaLiquidacion2=$fechaArray2[0];
}


$fechaArray3 = explode('-',$planillaDeTrabajo[0]["GozadaFecha"]);
@$fechaLiquidacion3=$meses[$fechaArray3[1]].' / '.$fechaArray3[0];


if($planillaDeTrabajo[0]["Concepto"]=="Aguinaldo")
{
  $fechaLiquidacion2=$fechaLiquidacion3;
}

//Detalles de Recibo 
$sql="SELECT * FROM `recibodetallerw` WHERE `IdRs`=".$_GET["rsid"]." order BY `Orden`;";
$recibodetallerw=ejecutarConsulta($sql);

//Suma de haberes
$sumaDeHaberes=0;
$viaticos=0;
$difFonasa=0;
$retSueldo=0;
$retViatico=0;
$totalDescuentos=0;

foreach($recibodetallerw as $row)
{
  if ($row["Cantidad"]>=0)
  {
    $sumaDeHaberes=$sumaDeHaberes+$row["Monto"];
  }
  if ($row["Detalle"]=="Viáticos")
  {
    $viaticos=$row["Monto"];
  }
  if ($row["Detalle"]=="Diferencia FO.NA.SA")
  {
    $difFonasa=$row["Monto"];
  }
  if ($row["Detalle"]=="Retención Viático")
  {
    $retViatico=$row["Monto"];
  }
  if ($row["Detalle"]=="Retención Sueldo")
  {
    $retSueldo=$row["Monto"];
  }
  if ($row["Cantidad"]<0)
  {
    $totalDescuentos=$totalDescuentos+$row["Monto"];
  }

}

$suledoBaseParaAportacion=$sumaDeHaberes-$viaticos;
$totalParaAportacion=$suledoBaseParaAportacion+($viaticos/2);
$totalParaAportacion=round($totalParaAportacion,2);

//descuentos
$descJubilatorio=$totalParaAportacion*(0.15);
$descJubilatorio=round($descJubilatorio,2);
$descFonasa=$planillaDeTrabajo[0]["FonasaAplicado"]-15.1;
$descFonasaMonto=$totalParaAportacion*($descFonasa/100);
$descFonasaMonto=round($descFonasaMonto,2);

$descFrl=$totalParaAportacion*(0.100/100);
$descFrl=round($descFrl,2);
$retTotal=$retSueldo+$retViatico;
$retTotal=$retTotal*(-1);
$totalDescuentos=$totalDescuentos*(-1);
$totalDescuentos=$totalDescuentos;

$totalRecibido=$sumaDeHaberes-$totalDescuentos;

$liquidoPorViaticos=0;
$liquidoPorViaticos=$viaticos/2;
$liquidoPorViaticos=$liquidoPorViaticos*($planillaDeTrabajo[0]["FonasaAplicado"]/100);
$liquidoPorViaticos=$viaticos-$liquidoPorViaticos;
$liquidoPorViaticos=round($liquidoPorViaticos,2);

$sql="UPDATE planilladetrabajo SET Descuentos='".$totalDescuentos-$retTotal."',TotalBruto='".$sumaDeHaberes."',RemuneracionTotal='".$suledoBaseParaAportacion."' WHERE Id='".$_GET["rsid"]."';";//RemuneracionTotal
Insert($sql);

?>

<html>
<head>
<style>
table {
  
    font-family: 'Overpass', sans-serif;
    font-weight: normal;
    font-size: 11px;
    color: #1b262c;
    width: 100%;
    border-collapse: collapse;
  background-color: rgba(255, 255, 255, 0.7);   
}
table.ex
{
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
  height:50px;
}
.cons
{
    background: #000;
    height:25px;
    color : #fff;
    width:130px;
}
.logo
{
  height: 10;
  width: 10;
}
.interlineado { line-height: 150%;} 

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


</style>
</head>
<body>


</table>

<table border="1" calss="ex">
    <tr>
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE:  <?php echo $planillaDeTrabajo[0]["Concepto"]." (".$fechaLiquidacion2.")";?></td><td class="cons"><b><?php echo $planillaDeTrabajo[0]["Concepto"];?></td>
    </tr>
    <tr>
    <td width='48%'>
        <p align="center"><b>EMPRESA</b></p>
        <p class="interlineado"> 
        <b>Nombre:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["Nombre"]; ?>
        <br><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["Domicilo"]; ?>
        <br><b>N° de Afiliación B.P.S.:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroAfiliacionBPS"]; ?>
        <br><b>N° de R.U.T .................:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroDeRUT"]; ?>
        <br><b>N° De Carpeta B.S.E.:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroDeRUT"]; ?>
        <br><b>N° Planilla De Control de Trabajo:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroDePlanillaDeControl"]; ?>
        <br><?php echo $EmpresaDatos[0]["OTROS"]; ?></p>
    </td>
    <td width='1px'></td>
    <td colspan="2">
        <p align="center"><b>TRABAJADOR</b></p>
        <p class="interlineado"> 
        <b>Nombre:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $ChoferDatos[0]["Nombre"]; ?>
        <br><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $ChoferDatos[0]["direccion"]; ?>
        <br><b>Cédula de Identidad:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $ChoferDatos[0]['ci']; ?>
        <br><b>Fecha de Ingreso: </b><?php echo $ChoferDatos[0]['FechaDeIngreso']; ?><b>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<br>Antigüedad: </b><?php echo $ChoferDatos[0]['FechaDeIngreso']; ?>
        <br><b>Cargo:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; CHOFER
        
    </td>
    </tr></tr>
    <tr>
    <td><table>
        <?php
        foreach($recibodetallerw as $row)
        {
          if ($row["Cantidad"]>=0)
          { 
            echo "<tr>";
            echo "<td>";
            echo $row['Detalle'];
            
            if($row['Cantidad']!="0")
              echo " ( ".$row['Cantidad']." )";
            echo "</td>";
            echo "<td>";
            echo $row['Monto'];
            echo "</td>";
            echo "</tr>";
          }
        }
        ?>
        </table>
        <p align='right'>
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $sumaDeHaberes;?></b>
        </p>
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $suledoBaseParaAportacion; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo round(($viaticos/2),2); ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $totalParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONSA</td><td></td><td><?php echo "$ ".$difFonasa; ?></td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $<?php echo $totalParaAportacion; ?>)</td><td>0</td><td>$ <?php echo $planillaDeTrabajo[0]["IRPF"]; ?></td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            <tr><td>Retencion P.A. </td><td></td><td>$ <?php echo $retTotal; ?></td></tr>
            <tr><td colspan="2">Total de descuentos:</td><td>$ <?php echo $totalDescuentos; ?></td></tr>
        </table>
        <br><br>
        <b>Adelantos: . . . . . . . . $ 00,00 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        Total Recibido: . . . . . $ <?php echo $totalRecibido; ?></td>

    </td>
    </tr>
    <tr>
    <td colspan="2">Montevideo,  1 de <?php echo $fechaLiquidacion3;?></td>
    <td colspan="2">Total recibido incluye el líquido por viáticos: $ <?php echo $liquidoPorViaticos;?></td>
    </tr></tr>
    <tr>
    <td><p align="center"><?php echo $leyenda;?>
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.
  </td><td colspan="3"><p align="center">Recibí duplicado del precente recibo<?php echo $leyenda3;?><br> 
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.</td>
    </tr>
</table>
<br>
<?php
?>
</table>


<table border="1" calss="ex">
    <tr>
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE:  <?php echo $planillaDeTrabajo[0]["Concepto"]." (".$fechaLiquidacion2.")";?></td><td class="cons"><b><?php echo $planillaDeTrabajo[0]["Concepto"];?></td>
    </tr>
    <tr>
    <td width='48%'>
        <p align="center"><b>EMPRESA</b></p>
        <p class="interlineado"> 
        <b>Nombre:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["Nombre"]; ?>
        <br><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["Domicilo"]; ?>
        <br><b>N° de Afiliación B.P.S.:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroAfiliacionBPS"]; ?>
        <br><b>N° de R.U.T .................:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroDeRUT"]; ?>
        <br><b>N° De Carpeta B.S.E.:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroDeRUT"]; ?>
        <br><b>N° Planilla De Control de Trabajo:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $EmpresaDatos[0]["NumeroDePlanillaDeControl"]; ?>
        <br><?php echo $EmpresaDatos[0]["OTROS"]; ?></p>
    </td>
    <td width='1px'></td>
    <td colspan="2">
        <p align="center"><b>TRABAJADOR</b></p>
        <p class="interlineado"> 
        <b>Nombre:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $ChoferDatos[0]["Nombre"]; ?>
        <br><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $ChoferDatos[0]["direccion"]; ?>
        <br><b>Cédula de Identidad:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $ChoferDatos[0]['ci']; ?>
        <br><b>Fecha de Ingreso: </b><?php echo $ChoferDatos[0]['FechaDeIngreso']; ?><b>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<br>Antigüedad: </b><?php echo $ChoferDatos[0]['FechaDeIngreso']; ?>
        <br><b>Cargo:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; CHOFER
        
    </td>
    </tr></tr>
    <tr>
    <td><table>
        <?php
        foreach($recibodetallerw as $row)
        {
          if ($row["Cantidad"]>=0)
          { 
            echo "<tr>";
            echo "<td>";
            echo $row['Detalle'];
            
            if($row['Cantidad']!="0")
              echo " ( ".$row['Cantidad']." )";
            echo "</td>";
            echo "<td>";
            echo $row['Monto'];
            echo "</td>";
            echo "</tr>";
          }
        }
        ?>
        </table>
        <p align='right'>
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $sumaDeHaberes;?></b>
        </p>
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $suledoBaseParaAportacion; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo round(($viaticos/2),2); ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $totalParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONSA</td><td></td><td><?php echo "$ ".$difFonasa; ?></td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $<?php echo $totalParaAportacion; ?>)</td><td>0</td><td>$ <?php echo $planillaDeTrabajo[0]["IRPF"]; ?></td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            <tr><td>Retencion P.A. </td><td></td><td>$ <?php echo $retTotal; ?></td></tr>
            <tr><td colspan="2">Total de descuentos:</td><td>$ <?php echo $totalDescuentos; ?></td></tr>
        </table>
        <br><br>
        <b>Adelantos: . . . . . . . . $ 00,00 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        Total Recibido: . . . . . $ <?php echo $totalRecibido; ?></td>

    </td>
    </tr>
    <tr>
    <td colspan="2">Montevideo,  1 de <?php echo $fechaLiquidacion3;?></td>
    <td colspan="2">Total recibido incluye el líquido por viáticos: $ <?php echo $liquidoPorViaticos;?></td>
    </tr></tr>
    <tr>
    <td><p align="center"><?php echo $leyenda;?>
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.
  </td><td colspan="3"><p align="center">Recibí duplicado del precente recibo<?php echo $leyenda3;?><br> 
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.</td>
    </tr>
</table>
<br>
<?php
?>
</table>

