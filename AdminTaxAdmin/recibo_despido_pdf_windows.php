<?php
//include 'index.php';
session_start();

$colores[43]="F1C2B7";
$colores[44]="ffffff";
$colores[45]="F1C2B7";
$colores[46]="ffffff";

include 'funciones.php';
$leyenda1="Declaro: Haber efectuado los aportes a la Seguridad Social Correspondiente al mes anterior según Dto. 113/96.<br>";
$leyenda2="La empresa a solicitud expresa del Trabajador, se deslinda de efectuar los aportes correspondientes a la Seguridad Social, quedando los mismos bajo su propia responsabilidad<br>";
$leyenda3="";
$leyenda4=": solicitando al empleador, no realizar los aportes correspondientes a la Seguridad Social, quedando los mismos bajo mi propia responsabilidad.<br>";
$leyenda=$leyenda1;

if (isset($_GET["rsid"]))
{
  $sql="SELECT *  FROM planilladetrabajo WHERE Id='".$_GET["rsid"]."'";
  $temp=ejecutarConsulta($sql);
}


$_POST["ChoferID"]=$temp[0]["ChoferID"];
$_POST["fecha"]=$temp[0]["Fecha"];
$_POST["EmpresaID"]=$temp[0]["EmpresaID"];
$_POST["TotalBruto"]=$temp[0]["TotalBruto"];
$_POST["SueldoBaseParaAportacion"]=$temp[0]["SueldoBaseParaAportacion"];
$_irpf=$temp[0]["IRPF"];

$sql="SELECT * FROM empresa WHERE id=".$_POST["EmpresaID"];
$EmpresaDatos=ejecutarConsulta($sql);
$sql="SELECT * FROM chofer WHERE id=".$_POST["ChoferID"];
$datos=ejecutarConsulta($sql);
$nomDeChofer=explode(",",$datos[0]["Nombre"]);

$sql="SELECT * FROM planilladetrabajo WHERE Fecha='".$_POST["fecha"]."' AND Concepto like '%Despido%' AND ChoferID='".$_POST["ChoferID"]."' AND EmpresaID='".$_POST["EmpresaID"]."' and Id='".$_GET["rsid"]."';";
$recibo=ejecutarConsulta($sql);

//obtener el valor de la BPC
$sql="SELECT round((laudos.Monto*2.5),2) FROM `laudos` WHERE `Detalle`='Valor de BPC' and `Fecha`<='".$_POST["fecha"]."' ORDER by Fecha DESC;";

$BPC=ejecutarConsulta($sql);

$sql="SELECT count(Id) as cant FROM recibodetallerw WHERE IdRs=".$recibo[0]["Id"].";";
$rsrw=ejecutarConsulta($sql);  

$rsid=$recibo[0]["Id"];
$concepto=$recibo[0]["Concepto"];
$diasDeLicencia=$recibo[0]["Comunes_Jornales"];
if (str_contains($concepto, 'Real'))
{
  $leyenda=$leyenda2;
  $leyenda3=$leyenda4;
}
$values="";
if($rsrw[0]["cant"]==0)
{
  $sql="INSERT INTO `recibodetallerw`(`IdRs`, `Detalle`, `Cantidad`, `Valor`, `Monto`) VALUES 
  ('".$rsid."','Aguinaldo','1','1','1'),
  ('".$rsid."','Viáticos','0','0','0'),
  ('".$rsid."','Horas no trabajadas','0','0','0'),
  ('".$rsid."','Sobretasa Ley 19313','0','0','0'),
  ('".$rsid."','Licencia','0','0','0'),
  ('".$rsid."','Salario Vacacional','0','0','0'),
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
$temp2=$_POST["TotalBruto"]-($_POST["TotalBruto"]*0.231);




$sql="UPDATE recibodetallerw SET 
Valor='".$_POST["TotalBruto"]."', Monto='".$_POST["TotalBruto"]."' 
where Detalle='Aguinaldo' and IdRs='".$rsid."'";
Insert($sql);

$temp=$_POST["SueldoBaseParaAportacion"]*($descuntoJuvilatorio/100);
$temp=round($temp,2);
$sql="UPDATE recibodetallerw SET 
Valor='".$temp."', Monto='".$temp*(-1)."' 
where Detalle='Descuentos Obligatorios' and IdRs='".$rsid."'";
Insert($sql);

$totalRecibido=$_POST["TotalBruto"]-$temp-$_irpf;
$retencion=$totalRecibido*($datos[0]["Retención"]/100);
$totalRecibido=$totalRecibido-$retencion;

$sql="UPDATE planilladetrabajo set TotalRecibido='".$totalRecibido."' where Id='".$rsid."'";
//Insert($sql);

$sql = "SELECT * FROM `recibodetallerw` WHERE `IdRs` = '".$rsid."';";

$reciboRW=ejecutarConsulta($sql);

$descJubilatorio=round(($_POST["SueldoBaseParaAportacion"]*0.15),2);
$descFonasa=$descuntoJuvilatorio-15.1;
$descFonasaMonto=round(($_POST["SueldoBaseParaAportacion"]*($descFonasa/100)),2);
$descFrl=round(($_POST["SueldoBaseParaAportacion"]*(0.001)),3);

$totalDescuentos=round( $_POST["SueldoBaseParaAportacion"]*($descuntoJuvilatorio/100)+$_irpf,2);

$totalRetenido=$retencion;

$totalDescuentos=$totalDescuentos+$retencion;


$temp=explode("-",$_POST["fecha"]);
$reciboFecha="(".$temp[0].")";
if($temp[01]<10)
{
  $aux=$temp[01]+1;
  $aux="0".$aux;
  $reciboFecha2=$meces[$aux]." de ".$temp[0];
}
else
  $reciboFecha2=$meces[$temp[01]+1]." de ".$temp[0];


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
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE A: Despido</td><td class="cons"><b>RECIBO DE AGUINALDO</td>
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
            if(($row['Detalle']=="Licencia") OR ($row['Detalle']=="Salario Vacacional"))
            {
              echo ": ".$diasDeLicencia . " días" ;
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
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $_POST["TotalBruto"];?></b>
        </p>
        <!--
        <table>
          <tr><td colspan='2'></td><td><b>Total Bruto:</td><td><?php echo $totalDeHaberes;?></td></tr>
        </table>-->
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $_POST["SueldoBaseParaAportacion"]; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo 0; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $_POST["SueldoBaseParaAportacion"]; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONASA</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            
            <?php
            echo '<tr><td>IRPF </td><td></td><td>$'.$_irpf.'</td></tr>'; 
            ?>

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
    <td colspan="2">Montevideo,  1 de <?php echo $reciboFecha2;?></td>
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
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE A: Despido</td><td class="cons"><b>RECIBO DE AGUINALDO</td>
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
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $_POST["TotalBruto"];?></b>
        </p>
        <!--
        <table>
          <tr><td colspan='2'></td><td><b>Total Bruto:</td><td><?php echo $totalDeHaberes;?></td></tr>
        </table>-->
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $_POST["SueldoBaseParaAportacion"]; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo 0; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $_POST["SueldoBaseParaAportacion"]; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONASA</td><td>0</td><td>0</td></tr>
            
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            
            <?php
            echo '<tr><td>IRPF </td><td></td><td>$'.$_irpf.'</td></tr>'; 
            ?>

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
    <td colspan="2">Montevideo,  1 de <?php echo $reciboFecha2;?></td>
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
