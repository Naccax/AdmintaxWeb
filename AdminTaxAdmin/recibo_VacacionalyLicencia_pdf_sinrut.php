<?php
//include 'index.php';
session_start();

$colores[43]="F1C2B7";
$colores[44]="ffffff";
$colores[45]="F1C2B7";
$colores[46]="ffffff";

include 'funciones.php';
//print_r($_POST);

$sql="SELECT * FROM empresa WHERE id=".$_POST["EmpresaID"];
$EmpresaDatos=ejecutarConsulta($sql);
$sql="SELECT * FROM chofer WHERE id=".$_POST["ChoferID"];
$datos=ejecutarConsulta($sql);
$nomDeChofer=explode(",",$datos[0]["Nombre"]);

$sql="SELECT * FROM planilladetrabajo WHERE Fecha='".$_POST["fecha"]."' AND Concepto='Licencia SR' AND ChoferID='".$_POST["ChoferID"]."' AND EmpresaID='".$_POST["EmpresaID"]."';";
$recibo=ejecutarConsulta($sql);

$sql="SELECT count(Id) as cant FROM recibodetallerw WHERE IdRs=".$recibo[0]["Id"].";";
$rsrw=ejecutarConsulta($sql);  

$rsid=$recibo[0]["Id"];
$values="";
if($rsrw[0]["cant"]==0)
{
  $sql="INSERT INTO `recibodetallerw`(`IdRs`, `Detalle`, `Cantidad`, `Valor`, `Monto`) VALUES 
  ('".$rsid."','Aguinaldo','0','0','0'),
  ('".$rsid."','Viáticos','0','0','0'),
  ('".$rsid."','Horas no trabajadas','0','0','0'),
  ('".$rsid."','Sobretasa Ley 19313','0','0','0'),
  ('".$rsid."','Licencia','0','0','0'),
  ('".$rsid."','Salario Vacacional','1','1','1'),
  ('".$rsid."','Descansos','0','0','0'),
  ('".$rsid."','Jornales no trab. por causas no imputables al trabajador','0','0','0'),
  ('".$rsid."','Participación Comisión','0','0','0'),
  ('".$rsid."','Descuentos Obligatorios','-1','0','0'),
  ('".$rsid."','Diferencia FO.NA.SA','-1','0','0'),
  ('".$rsid."','Retención Sueldo','-1','0','0'),
  ('".$rsid."','Retención Viático','-1','0','0');";
  Insert($sql);
}

$descuntoJuvilatorio=$datos[0]["tipoAporte"];


$sql="UPDATE recibodetallerw SET 
Valor='".$_POST["TotalBruto"]."', Monto='".$_POST["TotalBruto"]."' 
where Detalle='Salario Vacacional' and IdRs='".$rsid."'";
Insert($sql);

$sql="UPDATE recibodetallerw SET 
Valor='".$_POST["Licencia"]."', Monto='".$_POST["Licencia"]."' 
where Detalle='Licencia' and IdRs='".$rsid."'";
Insert($sql);

$temp=$_POST["Licencia"]*($descuntoJuvilatorio/100);
$temp=round($temp,2);

$SueldoParaAportacion=$_POST["Licencia"];

if($_POST["Gosada"]=="No")
{
  $temp=0;
  $SueldoParaAportacion=0;
}

$sql="UPDATE recibodetallerw SET 
Valor='".$temp."', Monto='".$temp."' 
where Detalle='Descuentos Obligatorios' and IdRs='".$rsid."'";
Insert($sql);

$totalRecibido=$_POST["TotalBruto"]+$_POST["Licencia"]-$temp;
$retencion=$totalRecibido*($datos[0]["Retención"]/100);
$totalRecibido=$totalRecibido-$retencion;

$sql="UPDATE planilladetrabajo set TotalRecibido='".$totalRecibido."' where Id='".$rsid."'";
Insert($sql);

$sql = "SELECT * FROM `recibodetallerw` WHERE `IdRs` = '".$rsid."';";
$reciboRW=ejecutarConsulta($sql);

$descJubilatorio=$SueldoParaAportacion*0.15;
$descFonasa=$datos[0]["tipoAporte"]-15.1;
$descFonasaMonto=round(($SueldoParaAportacion*($descFonasa/100)),2);
$descFrl=$SueldoParaAportacion*0.001;

$totalDescuentos=$temp;

$totalRetenido=$retencion;

$totalDescuentos=$totalDescuentos+$retencion;
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
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTEA SALARIO VACACIONAL Y LICENCIA</td><td class="cons"><b>RECIBO DE SUELDO</td>
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
        <b>Nombre:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $nomDeChofer[1]; ?>
        <br><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $nomDeChofer[0]; ?>
        <br><b>Cédula de Identidad:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $datos[0]['ci']; ?>
        <br><b>Fecha de Ingreso: </b><?php echo $datos[0]['FechaDeIngreso']; ?><b>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<br>Antigüedad: </b><?php echo $datos[0]['FechaDeIngreso']; ?>
        <br><b>Cargo:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; CHOFER
        
    </td>
    </tr></tr>
    <tr>
    <td><table>
        <?php
        foreach($reciboRW as $row)
        {
          if ($row["Cantidad"]>=0)
          { 
            echo "<tr>";
            echo "<td>";
            echo $row['Detalle'];
            if ($row['Detalle']=="Licencia")
            {
              echo " (".$_POST['Jornales']." Días)";
            }
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
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $_POST["TotalBruto"]+$_POST["Licencia"];?></b>
        </p>
        <!--
        <table>
          <tr><td colspan='2'></td><td><b>Total Bruto:</td><td><?php echo $totalDeHaberes;?></td></tr>
        </table>-->
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $SueldoParaAportacion; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo 0; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $SueldoParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONSA</td><td>0</td><td>0</td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $28.696)</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            <tr><td>IRPF </td><td>0</td><td>0</td></tr>
            <tr><td>Retencion P.A. </td><td></td><td>$ <?php echo $totalRetenido; ?></td></tr>
            <tr><td colspan="2">Total de descuentos:</td><td>$ <?php echo $totalDescuentos; ?></td></tr>
        </table>
        <br><br>
        <b>Adelantos: . . . . . . . . $ 00,00 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        Total Recibido: . . . . . $ <?php echo $totalRecibido; ?></td>

    </td>
    </tr>
    <tr>
    <td colspan="2">Montevideo,  1 de </td>
    </tr></tr>
    <tr>
    <td><p align="center">Declaro: Haber efectuado los aportes a la Seguridad Social Correspondiente al mes anterior según Dto. 113/96.<br> 
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.
  </td><td colspan="3"><p align="center">Recibí duplicado del precente recibo<br> 
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
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTEA SALARIO VACACIONAL Y LICENCIA</td><td class="cons"><b>RECIBO DE SUELDO</td>
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
        <b>Nombre:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $nomDeChofer[1]; ?>
        <br><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $nomDeChofer[0]; ?>
        <br><b>Cédula de Identidad:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $datos[0]['ci']; ?>
        <br><b>Fecha de Ingreso: </b><?php echo $datos[0]['FechaDeIngreso']; ?><b>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<br>Antigüedad: </b><?php echo $datos[0]['FechaDeIngreso']; ?>
        <br><b>Cargo:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; CHOFER
        
    </td>
    </tr></tr>
    <tr>
    <td><table>
        <?php
        foreach($reciboRW as $row)
        {
          if ($row["Cantidad"]>=0)
          { 
            echo "<tr>";
            echo "<td>";
            echo $row['Detalle'];
            if ($row['Detalle']=="Licencia")
            {
              echo " (".$_POST['Jornales']." Días)";
            }
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
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $_POST["TotalBruto"]+$_POST["Licencia"];?></b>
        </p>
        <!--
        <table>
          <tr><td colspan='2'></td><td><b>Total Bruto:</td><td><?php echo $totalDeHaberes;?></td></tr>
        </table>-->
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $SueldoParaAportacion; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo 0; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $SueldoParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONSA</td><td>0</td><td>0</td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $28.696)</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            <tr><td>IRPF </td><td>0</td><td>0</td></tr>
            <tr><td>Retencion P.A. </td><td></td><td>$ <?php echo $totalRetenido; ?></td></tr>
            <tr><td colspan="2">Total de descuentos:</td><td>$ <?php echo $totalDescuentos; ?></td></tr>
        </table>
        <br><br>
        <b>Adelantos: . . . . . . . . $ 00,00 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        Total Recibido: . . . . . $ <?php echo $totalRecibido; ?></td>

    </td>
    </tr>
    <tr>
    <td colspan="2">Montevideo,  1 de </td>
    </tr></tr>
    <tr>
    <td><p align="center">Declaro: Haber efectuado los aportes a la Seguridad Social Correspondiente al mes anterior según Dto. 113/96.<br> 
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.
  </td><td colspan="3"><p align="center">Recibí duplicado del precente recibo<br> 
        <br>Firma: _____________________________________________
        <br><br>Aclaración: ____________________ C.I: _________________<br>.</td>
    </tr>
</table>
<br>
<?php
?>
</table>
