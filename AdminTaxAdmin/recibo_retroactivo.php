<?php
//include 'index.php';
session_start();

$colores[43]="F1C2B7";
$colores[44]="ffffff";
$colores[45]="F1C2B7";
$colores[46]="ffffff";

include 'funciones.php';
$sql="SELECT * FROM empresa WHERE id=".$_POST["EmpresaID"];
$EmpresaDatos=ejecutarConsulta($sql);
$sql="SELECT * FROM chofer WHERE id=".$_POST["ChoferID"];
$datos=ejecutarConsulta($sql);
$nomDeChofer=explode(",",$datos[0]["Nombre"]);

$sql="SELECT
chofer.id as ChoferID,
chofer.Nombre,
COUNT(recaudaciones.id) as Cantidad,
min(HoraEntrada) as Desde,
max(HoraEntrada) as Hasta,
ROUND(max(ViaticoCobrado+ViaticoNoCobrado),2) as 'Viatico Cobrado',
ViaticoCorrespondiente,
DiferenciaDeViatico,
ROUND(sum(DiferenciaDeViatico),2) as 'Diferencia Bruta',
ROUND(sum(DiferenciaDeViaticoNeta),2) as 'Diferencia Neta',
movil.NumRut as RUT,
BPS,
periodosaguinaldo.id,
periodosaguinaldo.desde,
periodosaguinaldo.hasta,
recaudaciones.RetencionDeRetroactividad as retencion
FROM `recaudaciones`,periodosaguinaldo,chofer,movil
WHERE HoraEntrada>'2022-07-01 00:00:00' and Kilometros>0
AND recaudaciones.HoraEntrada>=periodosaguinaldo.desde 
AND recaudaciones.HoraEntrada<=periodosaguinaldo.hasta
AND chofer.id=recaudaciones.Chofer
and recaudaciones.MovilId=movil.Id
AND chofer.id=".$datos[0]['id']." 
AND movil.NumRut=".$EmpresaDatos[0]['NumeroDeRUT']." 
GROUP BY Chofer,`DiferenciaDeViatico`,`ViaticoCorrespondiente`,periodosaguinaldo.id
ORDER BY chofer.Nombre,`HoraEntrada` ASC;";
$recibo=ejecutarConsulta($sql);
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
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE A RETROACTIVO DE VIATICOS</td><td class="cons"><b>RECIBO DE SUELDO</td>
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
        <tr>
          <td>Cantidad</td>
          <td>Desde</td>
          <td>Hasta</td>
          <td>Viatico Cobrado</td>
          <td>Viático Correspondiente</td>
          <td>Diferencia de Viático</td>
          <td>Diferencia Bruta</td>
        </tr>
        <?php
        $aguis=[];
        $sumaDeViaticos=0;
        $sumaDeViaticosNeta=0;
        $sumaDeViaticosRetencion=0;
        foreach($recibo as $row)
        {
          if($row['Diferencia Bruta']!=0)
          {
            $i=0;
            echo '<tr>';
            echo "<td>";
            echo $row["Cantidad"];
            $i++;
            echo "</td>";
            echo "<td>";
            $temp0=explode(" ",$row["Desde"]);
            $temp=explode("-",$temp0[0]);
            echo $temp[2]."/".$temp[1]."/".$temp[0];
            $i++;
            echo "</td>";
            echo "<td>";
            $temp0=explode(" ",$row["Hasta"]);
            $temp=explode("-",$temp0[0]);
            echo $temp[2]."/".$temp[1]."/".$temp[0];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row['Viatico Cobrado'];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row["ViaticoCorrespondiente"];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row["DiferenciaDeViatico"];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row['Diferencia Bruta'];
            $i++;
            echo "</td>";
            echo "</tr>";
            $sumaDeViaticos=$sumaDeViaticos+$row['Diferencia Bruta'];
            $sumaDeViaticosNeta=$sumaDeViaticosNeta+$row['Diferencia Neta'];
            $sumaDeViaticosRetencion=$sumaDeViaticosRetencion+$row['retencion'];

            @$aguis[$row['id']]["Monto"]=$aguis[$row['id']]["Monto"]+$row['Diferencia Bruta'];
            $aguis[$row['id']]["id"]=$row['id'];
            $aguis[$row['id']]["desde"]=$row['desde'];
            $aguis[$row['id']]["hasta"]=$row['hasta'];
          }
        }
        ?>
        </table>
        <hr>
        <table>
          <?php
          $sumaDeAguinaldos=0;
          foreach($aguis as $row)
          {
            echo "<tr>";
            echo "<td>";
            echo "Aguinaldo: ";
            echo "</td>";
            echo "<td>";
            $temp=explode(" ",$row["desde"]);
            echo $temp[0];
            echo "</td>";
            echo "<td>";
            $temp=explode(" ",$row["hasta"]);
            echo $temp[0];
            echo "</td>";
            echo "<td>";
            echo round(($row["Monto"]/12),2);
            $sumaDeAguinaldos=$sumaDeAguinaldos+($row["Monto"]/12);
            echo "</td>";
            echo "<tr>";
          }
          $totalDeHaberes=$sumaDeViaticos+$sumaDeAguinaldos;
          $totalDeHaberes=round($totalDeHaberes,2);
          $sumaDeViaticos=round(($sumaDeViaticos/2),2);
          $totalParaAportacion=round($sumaDeAguinaldos+$sumaDeViaticos,2);
          $descJubilatorio= round($totalParaAportacion*(15/100),2);
          $descFonasa=$datos[0]["tipoAporte"]-15.1;
          $descFonasaMonto=round($totalParaAportacion*($descFonasa/100),2);
          $descFrl=round($totalParaAportacion*(0.1),3);

          $retencionViaticos=$sumaDeViaticos*($datos[0]["tipoAporte"]/100);
          $retencionViaticos=($sumaDeViaticos*2)-$retencionViaticos;
          $retencionViaticos=$retencionViaticos*0.35;
          $retencionViaticos=$retencionViaticos*($datos[0]["Retención"]/100);
          $retencionViaticos=round($retencionViaticos,2);

          $retencionSueldo=$sumaDeAguinaldos-($sumaDeAguinaldos*($datos[0]["tipoAporte"]/100));
          $retencionSueldo=$retencionSueldo*($datos[0]["Retención"]/100);
          $totalRetenido=$retencionSueldo+$retencionViaticos;
          $totalRetenido=round($totalRetenido,2);

          $totalDescuentos=$totalRetenido+$descFrl+$descFonasaMonto+$descJubilatorio;
          $totalDescuentos=round($totalDescuentos,2);

          $totalRecibido=$totalDeHaberes-$totalDescuentos;
          $totalRecibido=$totalDeHaberes-$totalDescuentos;
          $totalRecibido=round($totalRecibido,2);
          
          $AguinaldoNeto=$sumaDeAguinaldos-($sumaDeAguinaldos*($datos[0]["tipoAporte"]/100));
          $retencionAguinaldo=$AguinaldoNeto*($datos[0]["Retención"]/100);

          $totalRetenido=$sumaDeViaticosRetencion+$retencionAguinaldo;
          $totalDeHaberes=($sumaDeViaticos*2)+$sumaDeAguinaldos;
          $totalRecibido=$sumaDeViaticosNeta+$AguinaldoNeto-$sumaDeViaticosRetencion-$retencionAguinaldo;
          $totalDescuentos=$totalDeHaberes-$totalRecibido;

          $totalRetenido=round($totalRetenido,2);
          $totalDeHaberes=round($totalDeHaberes,2);
          $totalRecibido=round($totalRecibido,2);
          $totalDescuentos=round($totalDescuentos,2);
          

          ?>
        </table>
        <hr>
        <p align='right'>
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $totalDeHaberes;?></b>
        </p>
        <!--
        <table>
          <tr><td colspan='2'></td><td><b>Total Bruto:</td><td><?php echo $totalDeHaberes;?></td></tr>
        </table>-->
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo round($sumaDeAguinaldos,2); ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo $sumaDeViaticos; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $totalParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONSA</td><td>0</td><td>0</td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $28.696)</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            <tr><td>IRPF Corresp. a reliq. viáticos</td><td>0</td><td>0</td></tr>
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
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE A RETROACTIVO DE VIATICOS</td><td class="cons"><b>RECIBO DE SUELDO</td>
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
        <tr>
          <td>Cantidad</td>
          <td>Desde</td>
          <td>Hasta</td>
          <td>Viatico Cobrado</td>
          <td>Viático Correspondiente</td>
          <td>Diferencia de Viático</td>
          <td>Diferencia Bruta</td>
        </tr>
        <?php
        $aguis=[];
        $sumaDeViaticos=0;
        $sumaDeViaticosNeta=0;
        $sumaDeViaticosRetencion=0;
        foreach($recibo as $row)
        {
          if($row['Diferencia Bruta']!=0)
          {
            $i=0;
            echo "<tr>";
            echo "<td>";
            echo $row["Cantidad"];
            $i++;
            echo "</td>";
            echo "<td>";
            $temp0=explode(" ",$row["Desde"]);
            $temp=explode("-",$temp0[0]);
            echo $temp[2]."/".$temp[1]."/".$temp[0];
            $i++;
            echo "</td>";
            echo "<td>";
            $temp0=explode(" ",$row["Hasta"]);
            $temp=explode("-",$temp0[0]);
            echo $temp[2]."/".$temp[1]."/".$temp[0];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row['Viatico Cobrado'];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row["ViaticoCorrespondiente"];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row["DiferenciaDeViatico"];
            $i++;
            echo "</td>";
            echo "<td>";
            echo $row['Diferencia Bruta'];
            $i++;
            echo "</td>";
            echo "</tr>";
            $sumaDeViaticos=$sumaDeViaticos+$row['Diferencia Bruta'];
            $sumaDeViaticosNeta=$sumaDeViaticosNeta+$row['Diferencia Neta'];
            $sumaDeViaticosRetencion=$sumaDeViaticosRetencion+$row['retencion'];

            @$aguis[$row['id']]["Monto"]=$aguis[$row['id']]["Monto"]+$row['Diferencia Bruta'];
            $aguis[$row['id']]["id"]=$row['id'];
            $aguis[$row['id']]["desde"]=$row['desde'];
            $aguis[$row['id']]["hasta"]=$row['hasta'];
          }
        }
        ?>
        </table>
        <hr>
        <table>
          <?php
          $sumaDeAguinaldos=0;
          foreach($aguis as $row)
          {
            echo "<tr>";
            echo "<td>";
            echo "Aguinaldo: ";
            echo "</td>";
            echo "<td>";
            $temp=explode(" ",$row["desde"]);
            echo $temp[0];
            echo "</td>";
            echo "<td>";
            $temp=explode(" ",$row["hasta"]);
            echo $temp[0];
            echo "</td>";
            echo "<td>";
            echo round(($row["Monto"]/12),2);
            $sumaDeAguinaldos=$sumaDeAguinaldos+($row["Monto"]/12);
            echo "</td>";
            echo "<tr>";
          }
          $totalDeHaberes=$sumaDeViaticos+$sumaDeAguinaldos;
          $totalDeHaberes=round($totalDeHaberes,2);
          $sumaDeViaticos=round(($sumaDeViaticos/2),2);
          $totalParaAportacion=round($sumaDeAguinaldos+$sumaDeViaticos,2);
          $descJubilatorio= round($totalParaAportacion*(15/100),2);
          $descFonasa=$datos[0]["tipoAporte"]-15.1;
          $descFonasaMonto=round($totalParaAportacion*($descFonasa/100),2);
          $descFrl=round($totalParaAportacion*(0.1),3);

          $retencionViaticos=$sumaDeViaticos*($datos[0]["tipoAporte"]/100);
          $retencionViaticos=($sumaDeViaticos*2)-$retencionViaticos;
          $retencionViaticos=$retencionViaticos*0.35;
          $retencionViaticos=$retencionViaticos*($datos[0]["Retención"]/100);
          $retencionViaticos=round($retencionViaticos,2);

          $retencionSueldo=$sumaDeAguinaldos-($sumaDeAguinaldos*($datos[0]["tipoAporte"]/100));
          $retencionSueldo=$retencionSueldo*($datos[0]["Retención"]/100);
          $totalRetenido=$retencionSueldo+$retencionViaticos;
          $totalRetenido=round($totalRetenido,2);

          $totalDescuentos=$totalRetenido+$descFrl+$descFonasaMonto+$descJubilatorio;
          $totalDescuentos=round($totalDescuentos,2);

          $totalRecibido=$totalDeHaberes-$totalDescuentos;
          $totalRecibido=$totalDeHaberes-$totalDescuentos;
          $totalRecibido=round($totalRecibido,2);
          
          $AguinaldoNeto=$sumaDeAguinaldos-($sumaDeAguinaldos*($datos[0]["tipoAporte"]/100));
          $retencionAguinaldo=$AguinaldoNeto*($datos[0]["Retención"]/100);

          $totalRetenido=$sumaDeViaticosRetencion+$retencionAguinaldo;
          $totalDeHaberes=($sumaDeViaticos*2)+$sumaDeAguinaldos;
          $totalRecibido=$sumaDeViaticosNeta+$AguinaldoNeto-$sumaDeViaticosRetencion-$retencionAguinaldo;
          $totalDescuentos=$totalDeHaberes-$totalRecibido;

          $totalRetenido=round($totalRetenido,2);
          $totalDeHaberes=round($totalDeHaberes,2);
          $totalRecibido=round($totalRecibido,2);
          $totalDescuentos=round($totalDescuentos,2);
          

          ?>
        </table>
        <hr>
        <p align='right'>
        <b>Total Bruto:&nbsp;&nbsp;&nbsp; $<?php echo $totalDeHaberes;?></b>
        </p>
        <!--
        <table>
          <tr><td colspan='2'></td><td><b>Total Bruto:</td><td><?php echo $totalDeHaberes;?></td></tr>
        </table>-->
         
    </td>
    <td colspan="3" calss="td2">
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo round($sumaDeAguinaldos,2); ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo $sumaDeViaticos; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $totalParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td>$ <?php echo $descJubilatorio; ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $descFonasa; ?>%</td><td>$ <?php echo $descFonasaMonto; ?></td></tr>
            <tr><td>Diferencias FONSA</td><td>0</td><td>0</td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $28.696)</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td>$ <?php echo $descFrl; ?></td></tr>
            <tr><td>IRPF Corresp. a reliq. viáticos</td><td>0</td><td>0</td></tr>
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