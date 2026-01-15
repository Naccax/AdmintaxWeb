<?php
//include 'index.php';
session_start();

include 'funciones.php';
//Id
$sql="SELECT planilladetrabajo.Id from planilladetrabajo,empresa where ChoferId='".$_GET['Chofer']."' and empresa.NumeroDeRUT='".$_GET['Empresa']."' and `Concepto`='Retroactivo 2023' and EmpresaId=empresa.Id;";
$ids=ejecutarConsulta($sql);
$rsid=$ids[0]['Id'];

$sql = "SELECT * FROM planilladetrabajo,empresa,chofer WHERE empresa.id=planilladetrabajo.EmpresaID and chofer.id=planilladetrabajo.ChoferID and `planilladetrabajo`.`Id`='".$rsid."';";
$datos=ejecutarConsulta($sql);
$aportacionCorreccion = $datos[0]["tipoAporte"]-15.1;

if(true)
{
    $_SESSION['empresa']=$datos[0]["NumeroDeRUT"];
    
    $consulta="Select NumEmpresa from movil where NumRut='".$_SESSION['empresa']."';";
    $arraySQL=ejecutarConsulta($consulta);
@    $_SESSION["EmpresaPatronal"]= $arraySQL[0][0];

}

$consulta='SELECT * FROM `empresa` WHERE `NumeroDeRUT`="'.$_SESSION['empresa'].'"';
$EmpresaDatos = ejecutarConsulta($consulta);


$consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
$todosLosMoviles=ejecutarConsulta($consulta);

$inicio = date("Y-m-01");
$fin = date("Y-m-t");

/*
if(isset($_SESSION["desde"]))
{
  $inicio = $_SESSION["desde"];
  $fin = $_SESSION["hasta"];
  
  //$fecha=explode("-",date("Y-m-d",$inicio));
  
  $inicio = strtotime($inicio."- 1 days");
  $fin = strtotime($fin."+ 1 days");
}
*/

$empresaID=$EmpresaDatos[0]["id"];

$sql = "SELECT * FROM `planilladetrabajo` WHERE Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:00' AND EmpresaID ='$empresaID' AND Concepto = 'Recibo Sueldo'";
//echo "$sql";
$PlanillaDeTrabajo=ejecutarConsulta($sql);

//print_r($inicio);
$fecha=explode("-",$inicio);


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



if((isset($_GET['Token'])))
{
  "SELECT * FROM `recibodetallerw` WHERE `recibodetallerw`.`IdRs`='".$rsid."'";
}
else
{
  $sql = "SELECT * FROM `recibodetallerw` WHERE `recibodetallerw`.`IdRs`='".$rsid."'";
  $rsid=$rsid;
}

//echo "$sql";
$reciboSueldo=ejecutarConsulta($sql);

//print_r($reciboSueldo);
if (isset($reciboSueldo[0])){}
else{
  $sql="INSERT INTO `recibodetallerw`(`IdRs`, `Detalle`, `Cantidad`, `Valor`, `Monto`) VALUES 
  ('".$rsid."','Aguinaldo 1/6/22 hasta 30/11/22','0','0','0'),
  ('".$rsid."','Aguinaldo 1/12/22 hasta 31/5/23','0','0','0'),
  ('".$rsid."','Aguinaldo 1/06/23 hasta 3/11/23','0','0','0'),
  ('".$rsid."','Viáticos','0','0','0'),
  ('".$rsid."','Horas no trabajadas','0','0','0'),
  ('".$rsid."','Sobretasa Ley 19313','0','0','0'),
  ('".$rsid."','Licencia','0','0','0'),
  ('".$rsid."','Salario Vacacional','0','0','0'),
  ('".$rsid."','Aguinaldo','0','0','0'),
  ('".$rsid."','Descansos','0','0','0'),
  ('".$rsid."','Jornales no trab. por causas no imputables al trabajador','0','0','0'),
  ('".$rsid."','Participación Comisión','0','0','0'),
  ('".$rsid."','Descuentos Obligatorios','-1','0','0'),
  ('".$rsid."','Diferencia FO.NA.SA','-1','0','0'),
  ('".$rsid."','Retención Sueldo','-1','0','0'),
  ('".$rsid."','Retención Viático','-1','0','0');";
  Insert($sql);//"Horas no trabajadas"
}
$sql="UPDATE `recibodetallerw` SET `Cantidad`='".$datos[0]['Comunes_Jornales']."',
Valor='".$datos[0]['TotalBruto']."/".$datos[0]['Comunes_Jornales']."',
Monto='".$datos[0]['TotalBruto']."' 
WHERE IdRs='".$rsid."' AND Detalle='Viáticos'";
Insert($sql);

$sql="UPDATE `recibodetallerw` SET `Cantidad`='-1',
Valor='".$datos[0]['TotalBruto']-$datos[0]['TotalRecibido']+$_GET['Retencion']."',
Monto='".($datos[0]['TotalBruto']-$datos[0]['TotalRecibido']+$_GET['Retencion'])*(-1)."' 
WHERE IdRs='".$rsid."' AND Detalle='Descuentos Obligatorios'";
Insert($sql);


$sql="UPDATE `recibodetallerw` SET `Cantidad`='-1',
Valor='".$_GET['Retencion']*(-1)."',
Monto='".($_GET['Retencion'])."' 
WHERE IdRs='".$rsid."' AND Detalle='Retención Viático'";
Insert($sql);


$consulta="SELECT 
chofer.id as id,
chofer.Nombre as Nombre,
TRUNCATE(sum(DiferenciaDeViaticoNeta/2/6),2) as DiferenciaDeViaticoNeta,
TRUNCATE(sum(DiferenciaDeViatico/2/6),2) as DiferenciaDeViatico,
TRUNCATE(sum(RetencionDeRetroactividad/2/6),2) as RetencionDeRetroactividad,
COUNT(recaudaciones.id) as Cantidad,
TRUNCATE(sum(ViaticoNoCobrado/2/6),2) as ViaticoCobrado,
TRUNCATE(sum(ViaticoCorrespondiente/2/6),2) as ViaticoCorrespondiente,
movil.NumRut as NumRut,
periodosaguinaldo.id as P_id,
periodosaguinaldo.desde,
periodosaguinaldo.hasta
FROM `recaudaciones`,movil,periodosaguinaldo,chofer
where 
chofer.id=recaudaciones.Chofer
and chofer.id='".$_GET['Chofer']."'
and `movil`.`NumRut`='".$_GET['Empresa']."'
and `HoraEntrada`>'2022-07-01 00:00:00'
and Kilometros>0
and ViaticoNoCobrado>0
and HoraEntrada>=periodosaguinaldo.desde
and HoraEntrada<=periodosaguinaldo.hasta
and movil.Matricula=recaudaciones.Movil
GROUP BY periodosaguinaldo.id 
ORDER BY periodosaguinaldo.hasta DESC;";
$aguinaldos=ejecutarConsulta($consulta);
//echo $consulta;

$retencionRetroactividad=0; 
try{

  @$sql="UPDATE `recibodetallerw` SET `Cantidad`='1',
  Valor='".$aguinaldos[0]['DiferenciaDeViatico']."',
  Monto='".$aguinaldos[0]['DiferenciaDeViatico']."' 
  WHERE IdRs='".$rsid."' AND Detalle='Aguinaldo 1/06/23 hasta 3/11/23'";
  Insert($sql);
  @$retencionRetroactividad=$retencionRetroactividad+$aguinaldos[0]['RetencionDeRetroactividad'];


  @$sql="UPDATE `recibodetallerw` SET `Cantidad`='1',
  Valor='".$aguinaldos[1]['DiferenciaDeViatico']."',
  Monto='".$aguinaldos[1]['DiferenciaDeViatico']."' 
  WHERE IdRs='".$rsid."' AND Detalle='Aguinaldo 1/12/22 hasta 31/5/23'";
  Insert($sql);
  @$retencionRetroactividad=$retencionRetroactividad+$aguinaldos[1]['RetencionDeRetroactividad'];


  @$sql="UPDATE `recibodetallerw` SET `Cantidad`='1',
  Valor='".$aguinaldos[2]['DiferenciaDeViatico']."',
  Monto='".$aguinaldos[2]['DiferenciaDeViatico']."' 
  WHERE IdRs='".$rsid."' AND Detalle='Aguinaldo 1/12/22 hasta 31/5/23'";
  Insert($sql);
  
  @$retencionRetroactividad=$retencionRetroactividad+$aguinaldos[2]['RetencionDeRetroactividad'];
}
catch(Exception $e)
{

}

$sql="UPDATE `recibodetallerw` SET 
Valor='".$retencionRetroactividad."',
Monto='".$retencionRetroactividad."' 
WHERE IdRs='".$rsid."' AND Detalle='Retención Sueldo'";
Insert($sql);

$sql = "SELECT * FROM `recibodetallerw` WHERE `recibodetallerw`.`IdRs`='".$rsid."'";
$reciboSueldo=ejecutarConsulta($sql);

$nomDeChofer=explode(",",$datos[0]['Nombre']);

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

<table hidden>

<?php
$ViaticosTotales=0; 
$porcentajeDeAportesObligatorios=0;
$TotalDescuentos=0;
$Retencion=[];
$totalRecibido=0;
$diferenciaFonasa=0;
foreach($reciboSueldo as $row)
{
  $totalRecibido=$totalRecibido+$row["Monto"];
  echo "<tr>";
  foreach($row as $campo)
  {
    echo "<td>";
    echo $campo;
    echo "</td>";
  }
  if($row["Detalle"]=="Descuentos Obligatorios")
  {
    echo "<td>*****<td>";
    $porcentajeDeAportesObligatorios=$row["Cantidad"]*(-1);
  }
  if($row["Detalle"]=="Viáticos")
  {
    echo "<td>*****<td>";
    $ViaticosTotales=$row["Monto"];
  }
  if($row["Detalle"]=="Diferencia FO.NA.SA")
  {
    echo "<td>000000<td>";
    $diferenciaFonasa=($row["Monto"])*(-1);
  }
  if($row["Monto"]<0)
  {
    echo "<td>----<td>";
    $TotalDescuentos=$TotalDescuentos+$row["Monto"];
  }
  
  if($row["Detalle"]=="Retención Viático")
  {
    echo "<td>Rrr<td>";
    $Retencion["Viatico"]=$row["Monto"]*(-1);
  }
  if($row["Detalle"]=="Retención Sueldo")
  {
    echo "<td>Rrr<td>";
    $Retencion["Sueldo"]=$row["Monto"]*(-1);
  }
  echo "</tr>";
}
$liquidoPorViaticos=$ViaticosTotales-(($ViaticosTotales/2)*($porcentajeDeAportesObligatorios/100));
$descuentoFonasa=$porcentajeDeAportesObligatorios-0.1-15;
$TotalDescuentos=$TotalDescuentos*(-1);

$_SESSION["hasta"]=$datos[0]['Fecha'];
$fff=explode("-",$_SESSION["hasta"]);

?>

</table>

<table border="1" calss="ex">
    <tr>
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE A: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $meces[$fff[1]]." /  ".$fff[0]; ?></td><td class="cons"><b>RECIBO DE SUELDO</td>
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
    <td>
        <table ><tr>
            <?php
            $totalHaberes=0;
            $sueldoBaseParaAportacion=0;
            $viatios=0;
            foreach($reciboSueldo as $row)
            {
                if(($row["Cantidad"]>=0))
                {
                    echo "<td>";
                    echo $row["Detalle"];
                    echo "</td><td>";
                    echo $row["Cantidad"];
                    echo "</td><td>";
                    echo "$&nbsp;".$row["Monto"];
                    $totalHaberes= $totalHaberes+$row["Monto"];
                    echo "</tr><tr>";

                    $sueldoBaseParaAportacion=$sueldoBaseParaAportacion+$row["Monto"];

                    if($row["Detalle"]=="Viáticos")
                    {
                        $viatios=$viatios+$row["Monto"];
                    }


                    
                    if($row["Detalle"]=="Jornales no trab. por causas no imputables al trabajador")
                    {
                        echo "<td>";
                        echo "Diferencia";
                        echo "</td><td>";
                        echo "0";
                        echo "</td><td>";
                        echo "0";
                        echo "</tr><tr>";                    
                    }
                    
                    if($row["Detalle"]=="Participación Comisión")
                    {
                        echo "<td>";
                        echo "Total";
                        echo "</td><td>";
                        echo "";
                        echo "</td><td>";
                        echo "$ ".$totalHaberes;
                        echo "</tr><tr>";                    
                    }        
                    //print_r($row);
                }            
            }
            ?>
        </tr></table>
        
    </td>
    <td colspan="3" calss="td2">
        <?php
        $viatios50=$viatios/2;
        $sueldoBaseParaAportacion=$sueldoBaseParaAportacion-$viatios;
        $totalParaAportacion=$viatios50+$sueldoBaseParaAportacion;        
        ?>
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $sueldoBaseParaAportacion; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo $viatios50; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $totalParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td><?php echo "$&nbsp;".round((15*$totalParaAportacion/100),2); ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $aportacionCorreccion."%"; ?></td><td><?php echo "$&nbsp;".round(($aportacionCorreccion*$totalParaAportacion/100),2); ?></td></tr>
            <tr><td>Diferencias FONSA</td><td>1</td><td><?php echo "$ " . $diferenciaFonasa; ?></td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $28.696)</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td><?php echo "$&nbsp;".round((0.1*$totalParaAportacion/100),2); ?></td></tr>
            <tr><td>IRPF Corresp. a reliq. viáticos</td><td>0</td><td>0</td></tr>
            <tr><td>Retencion P.A. $<?php echo $Retencion["Sueldo"]; ?>(Sueldo) + $<?php echo $Retencion["Viatico"]; ?>(Viático)</td><td><?php echo $datos[0]["Retención"]."%"; ?></td><td>$ <?php echo $Retencion["Viatico"]+$Retencion["Sueldo"]; ?></td></tr>
            <tr><td colspan="2">Total de descuentos:</td><td><?php echo "$ &nbsp;".$TotalDescuentos; ?></td></tr>
        </table>
        <br><br>
        <b>Adelantos: . . . . . . . . $ 00,00 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        Total Recibido: . . . . . $ <?php echo "&nbsp;".$totalRecibido; ?></td>

    </td>
    </tr>
    <tr>
    <td colspan="2">Montevideo,  1 de <?php echo $meces[$fff[1]]." /  ".$fff[0]; ?>
      <?php
        $mesIndex= $fff[1]+1;
        $anio=$fff[0];
        if($mesIndex==13)
        {
          $mesIndex=1;
          $anio=$anio+1;
        }
        if($mesIndex<10)
        {
          $mesIndex="0".$mesIndex;
        }
        
      ?></td>
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

<table border="1" calss="ex">
    <tr>
    <td colspan="3"> <img src="./img/favicon.png" class="logo"> <B>AdminTax | &nbsp; LIQUIDACIÓN CORRESPONDIENTE A: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $meces[$fff[1]]." /  ".$fff[0]; ?></td><td class="cons"><b>RECIBO DE SUELDO</td>
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
    <td>
        <table ><tr>
            <?php
            $totalHaberes=0;
            $sueldoBaseParaAportacion=0;
            $viatios=0;
            foreach($reciboSueldo as $row)
            {
                if(($row["Cantidad"]>=0))
                {
                    echo "<td>";
                    echo $row["Detalle"];
                    echo "</td><td>";
                    echo $row["Cantidad"];
                    echo "</td><td>";
                    echo "$&nbsp;".$row["Monto"];
                    $totalHaberes= $totalHaberes+$row["Monto"];
                    echo "</tr><tr>";

                    $sueldoBaseParaAportacion=$sueldoBaseParaAportacion+$row["Monto"];

                    if($row["Detalle"]=="Viáticos")
                    {
                        $viatios=$viatios+$row["Monto"];
                    }


                    
                    
                    
                    if($row["Detalle"]=="Jornales no trab. por causas no imputables al trabajador")
                    {
                        echo "<td>";
                        echo "Diferencia";
                        echo "</td><td>";
                        echo "0";
                        echo "</td><td>";
                        echo "0";
                        echo "</tr><tr>";                    
                    }
                    
                    if($row["Detalle"]=="Participación Comisión")
                    {
                        echo "<td>";
                        echo "Total";
                        echo "</td><td>";
                        echo "";
                        echo "</td><td>";
                        echo "$" . $totalHaberes;
                        echo "</tr><tr>";                    
                    }        
                    //print_r($row);
                }            
            }
            ?>
        </tr></table>
        
    </td>
    <td colspan="3" calss="td2">
        <?php
        $viatios50=$viatios/2;
        $sueldoBaseParaAportacion=$sueldoBaseParaAportacion-$viatios;
        $totalParaAportacion=$viatios50+$sueldoBaseParaAportacion;        
        ?>
        <table border="0">
            <tr><td>Sueldo base para Aportación</td><td>$ <?php echo $sueldoBaseParaAportacion; ?></td></tr>
            <tr><td>Alicuota Viático 50%</td><td>$ <?php echo $viatios50; ?></td></tr>
            <tr><td>Total Para Aportación</td><td>$ <?php echo $totalParaAportacion; ?></td></tr>
        </table>
        <br>
        <table border="0">
            <tr><td>Desc. Jubilatorio</td><td>15%</td><td><?php echo "$&nbsp;".round((15*$totalParaAportacion/100),2); ?></td></tr>
            <tr><td>FONASA</td><td><?php echo $aportacionCorreccion."%"; ?></td><td><?php echo "$&nbsp;".round(($aportacionCorreccion*$totalParaAportacion/100),2); ?></td></tr>
            <tr><td>Diferencias FONSA</td><td>1</td><td><?php echo "$ " . $diferenciaFonasa; ?></td></tr>
            <tr><td>IRPF (Anticpo)(Imp. $28.696)</td><td>0</td><td>0</td></tr>
            <tr><td>F.R.L</td><td>0.100%</td><td><?php echo "$&nbsp;".round((0.1*$totalParaAportacion/100),2); ?></td></tr>
            <tr><td>IRPF Corresp. a reliq. viáticos</td><td>0</td><td>0</td></tr>
            <tr><td>Retencion P.A. $<?php echo $Retencion["Sueldo"]; ?>(Sueldo) + $<?php echo $Retencion["Viatico"]; ?>(Viático)</td><td><?php echo $datos[0]["Retención"]."%"; ?></td><td>$ <?php echo $Retencion["Viatico"]+$Retencion["Sueldo"]; ?></td></tr>
            <tr><td colspan="2">Total de descuentos:</td><td><?php echo "$ &nbsp;".$TotalDescuentos; ?></td></tr>
        </table>
        <br><br>
        <b>Adelantos: . . . . . . . . $ 00,00 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        Total Recibido: . . . . . $ <?php echo "&nbsp;".$totalRecibido; ?></td>

    </td>
    </tr>
    <tr>
    <td colspan="2">Montevideo,  1 de <?php echo $meces[$fff[1]]." /  ".$fff[0]; ?>
      <?php
        $mesIndex= $fff[1]+1;
        $anio=$fff[0];
        if($mesIndex==13)
        {
          $mesIndex=1;
          $anio=$anio+1;
        }
        if($mesIndex<10)
        {
          $mesIndex="0".$mesIndex;
        }
        
      ?></td>
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

<?php 
$sql="UPDATE planilladetrabajo SET SueldoBaseParaAportacion='".$totalParaAportacion."', RemuneracionTotal='".$sueldoBaseParaAportacion."' WHERE Id='".$rsid."';";
Insert($sql);
?>