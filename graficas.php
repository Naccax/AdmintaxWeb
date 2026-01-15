<?php
include 'index.php';


$consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
$todosLosMoviles=ejecutarConsulta($consulta);

$ides="";
foreach($todosLosMoviles as $row)
{
  $ides=$ides.$row['Id'].",";
}

$ides="(".$ides.")";

$ides = str_replace(",)", ")", $ides);

$movil=$ides;



$inicio = date("Y-m-01");
$fin = date("Y-m-t");

if(isset($_POST["desde"]))
{
  $inicio = $_POST["desde"];
  $fin = $_POST["hasta"];
}

$consulta="SELECT recaudaciones.Movil,round((sum(recaudaciones.Recaudado)/sum(recaudaciones.Kilometros)),2) as km,sum(recaudaciones.Recaudado) as Recaudado,recaudaciones.MovilId,Movil.NumRut from recaudaciones,Movil WHERE HoraEntrada>='$inicio 00:00:00' and  HoraEntrada <= '$fin 23:59:00' and Movil.NumRut='".$_SESSION['empresa']."' AND Movil.id=recaudaciones.MovilId GROUP by recaudaciones.MovilId;";
$dt=ejecutarConsulta($consulta);


$consulta="SELECT recaudaciones.Chofer,chofer.RUT,sum(recaudaciones.Recaudado) as Recaudado,recaudaciones.Chofer,chofer.Nombre from recaudaciones,Movil,chofer WHERE HoraEntrada>='$inicio 00:00:00' and  HoraEntrada <= '$fin 23:59:00' AND recaudaciones.MovilId=movil.Id and movil.NumRut='".$_SESSION['empresa']."' and chofer.id=recaudaciones.Chofer GROUP by recaudaciones.Chofer;";
//echo $consulta;
$dtChoferes=ejecutarConsulta($consulta);
//print_r($dt);


$sql = "Select * from recaudaciones where ((HoraEntrada>='$inicio 00:00:00' and  HoraEntrada <= '$fin 23:59:00') or (fecha>='$inicio 00:00:00' and  fecha <= '$fin 23:59:00')) and recaudaciones.MovilId in $ides order by recaudaciones.HoraEntrada;";
$sql2 = str_replace("from recaudaciones", "from recaudaciones,bauchers", $sql);
$sql2 = str_replace("where", "where recaudaciones.id=bauchers.Recaudacion_Id and ", $sql2);
$sql2 = str_replace("*", "round(sum(bauchers.Descuentos),2)", $sql2);
//echo "$sql" . "<br>";
$movimientos=ejecutarConsulta($sql);
$desc=ejecutarConsulta($sql2);
//print_r($movimientos);


$contador['id']=0;
$contador['fecha']=0;
$contador['KmEntrada']=0;
$contador['KmSalida']=0;
$contador['Chofer']=0;
$contador['Movil']=$movil;
$contador['HoraEntrada']=0;
$contador['HoraSalida']=0;
$contador['Sueldo']=0;
$contador['BPS']=0;
$contador['Recaudado']=0;
$contador['Salario']=0;
$contador['Laudo']=0;
$contador['Comision']=0;
$contador['ViaticoNoCobrado']=0;
$contador['ViaticoCobrado']=0;
$contador['FeriadoNoCobrado']=0;
$contador['FeriadoCobrado']=0;
$contador['AporteSalario']=0;
$contador['AporteViatico']=0;
$contador['AporteFeriado']=0;
$contador['AporteTotales']=0;
$contador['H13Patronal']=0;
$contador['R12Celeritas']=0;
$contador['MerPagoCeleritas']=0;
$contador['H13Especiales']=0;
$contador['MercPago']=0;
$contador['OcaCel']=0;
$contador['Bits']=0;
$contador['Tarjetas']=0;
$contador['GasOilPlata']=0;
$contador['GasOilLitros']=0;
$contador['Lavado']=0;
$contador['Gomeria']=0;
$contador['Cabify']=0;
$contador['Otros']=0;
$contador['Efectivo']=0;
$contador['Gastos']=0;
$contador['Liquido']=0;
$contador['Observaciones']=0;
$contador['Kilometros']=0;
$contador['MercPagoPersonal']=0;
$contador['CabifyTarjetas']=0;
$contador['OtraRetencion']=0;
$contador['AporteReal']=0;
$contador['GasOilCred']=0;
$contador['AceiteCont']=0;
$contador['AceiteCred']=0;
$contador['LaudoNoCobrado']=0;

$pagosElecrtonicos=0;

$contadorGV['id']=0;
$contadorGV['fecha']=0;
$contadorGV['KmEntrada']=0;
$contadorGV['KmSalida']=0;
$contadorGV['Chofer']=0;
$contadorGV['Movil']=$movil;
$contadorGV['HoraEntrada']=0;
$contadorGV['HoraSalida']=0;
$contadorGV['Sueldo']=0;
$contadorGV['BPS']=0;
$contadorGV['Recaudado']=0;
$contadorGV['Salario']=0;
$contadorGV['Laudo']=0;
$contadorGV['Comision']=0;
$contadorGV['ViaticoNoCobrado']=0;
$contadorGV['ViaticoCobrado']=0;
$contadorGV['FeriadoNoCobrado']=0;
$contadorGV['FeriadoCobrado']=0;
$contadorGV['AporteSalario']=0;
$contadorGV['AporteViatico']=0;
$contadorGV['AporteFeriado']=0;
$contadorGV['AporteTotales']=0;
$contadorGV['H13Patronal']=0;
$contadorGV['R12Celeritas']=0;
$contadorGV['MerPagoCeleritas']=0;
$contadorGV['H13Especiales']=0;
$contadorGV['MercPago']=0;
$contadorGV['OcaCel']=0;
$contadorGV['Bits']=0;
$contadorGV['Tarjetas']=0;
$contadorGV['GasOilPlata']=0;
$contadorGV['GasOilLitros']=0;
$contadorGV['Lavado']=0;
$contadorGV['Gomeria']=0;
$contadorGV['Cabify']=0;
$contadorGV['Otros']=0;
$contadorGV['Efectivo']=0;
$contadorGV['Gastos']=0;
$contadorGV['Liquido']=0;
$contadorGV['Observaciones']=0;
$contadorGV['Kilometros']=0;
$contadorGV['MercPagoPersonal']=0;
$contadorGV['CabifyTarjetas']=0;
$contadorGV['OtraRetencion']=0;
$contadorGV['AporteReal']=0;

$contadorGF['id']=0;
$contadorGF['fecha']=0;
$contadorGF['KmEntrada']=0;
$contadorGF['KmSalida']=0;
$contadorGF['Chofer']=0;
$contadorGF['Movil']=$movil;
$contadorGF['HoraEntrada']=0;
$contadorGF['HoraSalida']=0;
$contadorGF['Sueldo']=0;
$contadorGF['BPS']=0;
$contadorGF['Recaudado']=0;
$contadorGF['Salario']=0;
$contadorGF['Laudo']=0;
$contadorGF['Comision']=0;
$contadorGF['ViaticoNoCobrado']=0;
$contadorGF['ViaticoCobrado']=0;
$contadorGF['FeriadoNoCobrado']=0;
$contadorGF['FeriadoCobrado']=0;
$contadorGF['AporteSalario']=0;
$contadorGF['AporteViatico']=0;
$contadorGF['AporteFeriado']=0;
$contadorGF['AporteTotales']=0;
$contadorGF['H13Patronal']=0;
$contadorGF['R12Celeritas']=0;
$contadorGF['MerPagoCeleritas']=0;
$contadorGF['H13Especiales']=0;
$contadorGF['MercPago']=0;
$contadorGF['OcaCel']=0;
$contadorGF['Bits']=0;
$contadorGF['Tarjetas']=0;
$contadorGF['GasOilPlata']=0;
$contadorGF['GasOilLitros']=0;
$contadorGF['Lavado']=0;
$contadorGF['Gomeria']=0;
$contadorGF['Cabify']=0;
$contadorGF['Otros']=0;
$contadorGF['Efectivo']=0;
$contadorGF['Gastos']=0;
$contadorGF['Liquido']=0;
$contadorGF['Observaciones']=0;
$contadorGF['Kilometros']=0;
$contadorGF['MercPagoPersonal']=0;
$contadorGF['CabifyTarjetas']=0;
$contadorGF['OtraRetencion']=0;
$contadorGF['AporteReal']=0;

$contadorMV['id']=0;
$contadorMV['fecha']=0;
$contadorMV['KmEntrada']=0;
$contadorMV['KmSalida']=0;
$contadorMV['Chofer']=0;
$contadorMV['Movil']=$movil;
$contadorMV['HoraEntrada']=0;
$contadorMV['HoraSalida']=0;
$contadorMV['Sueldo']=0;
$contadorMV['BPS']=0;
$contadorMV['Recaudado']=0;
$contadorMV['Salario']=0;
$contadorMV['Laudo']=0;
$contadorMV['Comision']=0;
$contadorMV['ViaticoNoCobrado']=0;
$contadorMV['ViaticoCobrado']=0;
$contadorMV['FeriadoNoCobrado']=0;
$contadorMV['FeriadoCobrado']=0;
$contadorMV['AporteSalario']=0;
$contadorMV['AporteViatico']=0;
$contadorMV['AporteFeriado']=0;
$contadorMV['AporteTotales']=0;
$contadorMV['H13Patronal']=0;
$contadorMV['R12Celeritas']=0;
$contadorMV['MerPagoCeleritas']=0;
$contadorMV['H13Especiales']=0;
$contadorMV['MercPago']=0;
$contadorMV['OcaCel']=0;
$contadorMV['Bits']=0;
$contadorMV['Tarjetas']=0;
$contadorMV['GasOilPlata']=0;
$contadorMV['GasOilLitros']=0;
$contadorMV['Lavado']=0;
$contadorMV['Gomeria']=0;
$contadorMV['Cabify']=0;
$contadorMV['Otros']=0;
$contadorMV['Efectivo']=0;
$contadorMV['Gastos']=0;
$contadorMV['Liquido']=0;
$contadorMV['Observaciones']=0;
$contadorMV['Kilometros']=0;
$contadorMV['MercPagoPersonal']=0;
$contadorMV['CabifyTarjetas']=0;
$contadorMV['OtraRetencion']=0;
$contadorMV['AporteReal']=0;


$contadorPA['id']=0;
$contadorPA['fecha']=0;
$contadorPA['KmEntrada']=0;
$contadorPA['KmSalida']=0;
$contadorPA['Chofer']=0;
$contadorPA['Movil']=$movil;
$contadorPA['HoraEntrada']=0;
$contadorPA['HoraSalida']=0;
$contadorPA['Sueldo']=0;
$contadorPA['BPS']=0;
$contadorPA['Recaudado']=0;
$contadorPA['Salario']=0;
$contadorPA['Laudo']=0;
$contadorPA['Comision']=0;
$contadorPA['ViaticoNoCobrado']=0;
$contadorPA['ViaticoCobrado']=0;
$contadorPA['FeriadoNoCobrado']=0;
$contadorPA['FeriadoCobrado']=0;
$contadorPA['AporteSalario']=0;
$contadorPA['AporteViatico']=0;
$contadorPA['AporteFeriado']=0;
$contadorPA['AporteTotales']=0;
$contadorPA['H13Patronal']=0;
$contadorPA['R12Celeritas']=0;
$contadorPA['MerPagoCeleritas']=0;
$contadorPA['H13Especiales']=0;
$contadorPA['MercPago']=0;
$contadorPA['OcaCel']=0;
$contadorPA['Bits']=0;
$contadorPA['Tarjetas']=0;
$contadorPA['GasOilPlata']=0;
$contadorPA['GasOilLitros']=0;
$contadorPA['Lavado']=0;
$contadorPA['Gomeria']=0;
$contadorPA['Cabify']=0;
$contadorPA['Otros']=0;
$contadorPA['Efectivo']=0;
$contadorPA['Gastos']=0;
$contadorPA['Liquido']=0;
$contadorPA['Observaciones']=0;
$contadorPA['Kilometros']=0;
$contadorPA['MercPagoPersonal']=0;
$contadorPA['CabifyTarjetas']=0;
$contadorPA['OtraRetencion']=0;
$contadorPA['AporteReal']=0;



$contadorOtros['id']=0;
$contadorOtros['fecha']=0;
$contadorOtros['KmEntrada']=0;
$contadorOtros['KmSalida']=0;
$contadorOtros['Chofer']=0;
$contadorOtros['Movil']=$movil;
$contadorOtros['HoraEntrada']=0;
$contadorOtros['HoraSalida']=0;
$contadorOtros['Sueldo']=0;
$contadorOtros['BPS']=0;
$contadorOtros['Recaudado']=0;
$contadorOtros['Salario']=0;
$contadorOtros['Laudo']=0;
$contadorOtros['Comision']=0;
$contadorOtros['ViaticoNoCobrado']=0;
$contadorOtros['ViaticoCobrado']=0;
$contadorOtros['FeriadoNoCobrado']=0;
$contadorOtros['FeriadoCobrado']=0;
$contadorOtros['AporteSalario']=0;
$contadorOtros['AporteViatico']=0;
$contadorOtros['AporteFeriado']=0;
$contadorOtros['AporteTotales']=0;
$contadorOtros['H13Patronal']=0;
$contadorOtros['R12Celeritas']=0;
$contadorOtros['MerPagoCeleritas']=0;
$contadorOtros['H13Especiales']=0;
$contadorOtros['MercPago']=0;
$contadorOtros['OcaCel']=0;
$contadorOtros['Bits']=0;
$contadorOtros['Tarjetas']=0;
$contadorOtros['GasOilPlata']=0;
$contadorOtros['GasOilLitros']=0;
$contadorOtros['Lavado']=0;
$contadorOtros['Gomeria']=0;
$contadorOtros['Cabify']=0;
$contadorOtros['Otros']=0;
$contadorOtros['Efectivo']=0;
$contadorOtros['Gastos']=0;
$contadorOtros['Liquido']=0;
$contadorOtros['Observaciones']=0;
$contadorOtros['Kilometros']=0;
$contadorOtros['MercPagoPersonal']=0;
$contadorOtros['CabifyTarjetas']=0;
$contadorOtros['OtraRetencion']=0;
$contadorOtros['AporteReal']=0;



$ListaGF=[];
$GF=0;
$listaGV=[];
$listaMV=[];
$listaPA=[];
$listarecaudaciones=[];
$listaOtrosGastos=[];
$listaDeKm=[];
$listaDeTipos=[];
$listaDeVarios=[];
$combutibleTipos=[];

foreach($movimientos as $row)
{
  
  $temp = str_replace(": ", ":", $row['Observaciones']);
  $tipo=explode(":", $temp);
  if (isset($tipo[1]))
  {
    $listaDeTipos[$tipo[1]]['tipo']=$tipo[1];
    $listaDeTipos[$tipo[1]]['clase']=$tipo[0];
    @$listaDeTipos[$tipo[1]]['monto']=$listaDeTipos[$tipo[1]]['monto']+($row['Otros']*(-1));
    if($tipo[1]=="VARIOS")
    {
        $listaDeVarios[$row['id']]['Observaciones']=$tipo[1];
    }
  }
    
  if(str_contains($row['Observaciones'],'P.A. Retención: '))
  {
    $listaPA[]=$row;
  }
  else
  {
    if(str_contains($row['Observaciones'],'GF: '))
    {
      $ListaGF[]=$row;
    }
    else
    {
      if(str_contains($row['Observaciones'],'GV: '))
      {
        $ListaGV[]=$row;
      }else
      {
        if((str_contains($row['Observaciones'],'DEP: ')) or (str_contains($row['Observaciones'],'RET: ')))
        {
          $ListaMV[]=$row;
        }else
        {
          $listarecaudaciones[]=$row;
          if($row['Otros']>0)
          {
            $listaOtrosGastos[]=$row;
          }
        }
      }
    }
  }
}

//print_r($listaDeTipos);

foreach($listarecaudaciones as $row)
{
    
  //$contador['id']=$contador['']+$row['id'];
  //$contador['fecha']=$contador['']+$row[''];
  if(($contador['KmEntrada']==0) or ($contador['KmEntrada']>$row['KmEntrada']))
  {
    $contador['KmEntrada']=$row['KmEntrada'];
  }
  if($contador['KmSalida']<$row['KmSalida'])
  {
    $contador['KmSalida']=$row['KmSalida'];
  }

  if(($row['KmEntrada']!=0) or ($row['KmSalida']!=0))
  {
    $listaDeKm[]=$row['KmEntrada'];
    $listaDeKm[]=$row['KmSalida'];
  }

  //$contador['Chofer']=$contador['']+$row[''];
  //$contador['Movil']=$contador['']+$row[''];
  //$contador['HoraEntrada']=$contador['']+$row[''];
  //$contador['HoraSalida']=$contador['']+$row[''];
  //$contador['Sueldo']=$contador['']+$row[''];
  //$contador['BPS']=$contador['']+$row[''];
  $contador['Recaudado']=$contador['Recaudado']+$row['Recaudado'];
  $contador['Salario']=$contador['Salario']+$row['Salario'];
  $contador['Laudo']=$contador['Laudo']+$row['Laudo'];
  $contador['Comision']=$contador['Comision']+$row['Comision'];
  $contador['ViaticoNoCobrado']=$contador['ViaticoNoCobrado']+$row['ViaticoNoCobrado'];
  $contador['ViaticoCobrado']=$contador['ViaticoCobrado']+$row['ViaticoCobrado'];
  $contador['FeriadoNoCobrado']=$contador['FeriadoNoCobrado']+$row['FeriadoNoCobrado'];
  $contador['FeriadoCobrado']=$contador['FeriadoCobrado']+$row['FeriadoCobrado'];
  $contador['AporteSalario']=$contador['AporteSalario']+$row['AporteSalario'];
  $contador['AporteViatico']=$contador['AporteViatico']+$row['AporteViatico'];
  $contador['AporteFeriado']=$contador['AporteFeriado']+$row['AporteFeriado'];
  $contador['AporteTotales']=$contador['AporteTotales']+$row['AporteTotales'];

  $contador['H13Patronal']=$contador['H13Patronal']+$row['H13Patronal'];
  $contador['R12Celeritas']=$contador['R12Celeritas']+$row['R12Celeritas'];
  $contador['MerPagoCeleritas']=$contador['MerPagoCeleritas']+$row['MerPagoCeleritas'];
  $contador['H13Especiales']=$contador['H13Especiales']+$row['H13Especiales'];
  $contador['MercPago']=$contador['MercPago']+$row['MercPago'];
  $contador['OcaCel']=$contador['OcaCel']+$row['OcaCel'];
  $contador['Bits']=$contador['Bits']+$row['Bits'];
  $contador['Tarjetas']=$contador['Tarjetas']+$row['Tarjetas'];
  $contador['MercPagoPersonal']=$contador['MercPagoPersonal']+$row['MercPagoPersonal'];
  $contador['CabifyTarjetas']=$contador['CabifyTarjetas']+$row['CabifyTarjetas'];

  $contador['GasOilPlata']=$contador['GasOilPlata']+$row['GasOilPlata'];
  $contador['GasOilLitros']=$contador['GasOilLitros']+$row['GasOilLitros'];
  $contador['Lavado']=$contador['Lavado']+$row['Lavado'];
  $contador['Gomeria']=$contador['Gomeria']+$row['Gomeria'];
  $contador['Cabify']=$contador['Cabify']+$row['Cabify'];
  $contador['Otros']=$contador['Otros']+$row['Otros'];
  $contador['Efectivo']=$contador['Efectivo']+$row['Efectivo'];
  $contador['Gastos']=$contador['Gastos']+$row['Gastos'];
  $contador['Liquido']=$contador['Liquido']+$row['Liquido'];
  //$contador['Observaciones']=$contador['Observaciones']+$row['Observaciones'];
  $contador['Kilometros']=$contador['Kilometros']+$row['Kilometros'];
  $contador['OtraRetencion']=$contador['OtraRetencion']+$row['OtraRetencion'];
  $contador['AporteReal']=$contador['AporteReal']+$row['AporteReal'];
  $contador['GasOilCred']=$contador['GasOilCred']+$row['GasOilCred'];

  
  $contador['AceiteCont']=$contador['AceiteCont']+$row['AceiteCont'];
  $contador['AceiteCred']=$contador['AceiteCred']+$row['AceiteCred'];
  $contador['LaudoNoCobrado']=$contador['LaudoNoCobrado']+$row['LaudoNoCobrado'];
  @$contador['HoraDeCarga']=$contador['HoraDeCarga']+$row['HoraDeCarga'];
  @$contador['HoraDeCargaNoCobrada']=$contador['HoraDeCargaNoCobrada']+$row['HoraDeCargaNoCobrada'];

  
  $combutibleTipos[$row['Combustible']]['Tipo']=$row['Combustible'];
  @$combutibleTipos[$row['Combustible']]['Monto']=$combutibleTipos[$row['Combustible']]['Monto']+$row['GasOilCred']+$row['GasOilPlata'];
  
}

@$Salarios=$contador['HoraDeCarga']+$contador['HoraDeCargaNoCobrada']+0;
$Salarios=$Salarios+$contador['LaudoNoCobrado']+$contador['Laudo'];
$Salarios=$Salarios+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado'];
$Salarios=$Salarios+$contador['Salario'];

if (count($listaDeKm)>0){
$contador['KmEntrada']= min($listaDeKm);
$contador['KmSalida']= max($listaDeKm);
}

$sumaAceites=$contador['AceiteCont']+$contador['AceiteCred'];

$pagosElecrtonicos=$contador['H13Patronal']+$contador['R12Celeritas']+$contador['MerPagoCeleritas']+$contador['H13Especiales']+$contador['MercPago']+$contador['OcaCel']+$contador['Bits']+$contador['Tarjetas']+$contador['MercPagoPersonal']+$contador['CabifyTarjetas'];


foreach($ListaGF as $row)
{
    
  //$contadorGF['id']=$contadorGF['']+$row['id'];
  //$contadorGF['fecha']=$contadorGF['']+$row[''];
  if(($contadorGF['KmEntrada']==0) or ($contadorGF['KmEntrada']>$row['KmEntrada']))
  {
    $contadorGF['KmEntrada']=$row['KmEntrada'];
  }
  if($contadorGF['KmSalida']<$row['KmSalida'])
  {
    $contadorGF['KmSalida']=$row['KmSalida'];
  }

  //$contadorGF['Chofer']=$contadorGF['']+$row[''];
  //$contadorGF['Movil']=$contadorGF['']+$row[''];
  //$contadorGF['HoraEntrada']=$contadorGF['']+$row[''];
  //$contadorGF['HoraSalida']=$contadorGF['']+$row[''];
  //$contadorGF['Sueldo']=$contadorGF['']+$row[''];
  //$contadorGF['BPS']=$contadorGF['']+$row[''];
  $contadorGF['Recaudado']=$contadorGF['Recaudado']+$row['Recaudado'];
  $contadorGF['Salario']=$contadorGF['Salario']+$row['Salario'];
  $contadorGF['Laudo']=$contadorGF['Laudo']+$row['Laudo'];
  $contadorGF['Comision']=$contadorGF['Comision']+$row['Comision'];
  $contadorGF['ViaticoNoCobrado']=$contadorGF['ViaticoNoCobrado']+$row['ViaticoNoCobrado'];
  $contadorGF['ViaticoCobrado']=$contadorGF['ViaticoCobrado']+$row['ViaticoCobrado'];
  $contadorGF['FeriadoNoCobrado']=$contadorGF['FeriadoNoCobrado']+$row['FeriadoNoCobrado'];
  $contadorGF['FeriadoCobrado']=$contadorGF['FeriadoCobrado']+$row['FeriadoCobrado'];
  $contadorGF['AporteSalario']=$contadorGF['AporteSalario']+$row['AporteSalario'];
  $contadorGF['AporteViatico']=$contadorGF['AporteViatico']+$row['AporteViatico'];
  $contadorGF['AporteFeriado']=$contadorGF['AporteFeriado']+$row['AporteFeriado'];
  $contadorGF['AporteTotales']=$contadorGF['AporteTotales']+$row['AporteTotales'];
  $contadorGF['H13Patronal']=$contadorGF['H13Patronal']+$row['H13Patronal'];
  $contadorGF['R12Celeritas']=$contadorGF['R12Celeritas']+$row['R12Celeritas'];
  $contadorGF['MerPagoCeleritas']=$contadorGF['MerPagoCeleritas']+$row['MerPagoCeleritas'];
  $contadorGF['H13Especiales']=$contadorGF['H13Especiales']+$row['H13Especiales'];
  $contadorGF['MercPago']=$contadorGF['MercPago']+$row['MercPago'];
  $contadorGF['OcaCel']=$contadorGF['OcaCel']+$row['OcaCel'];
  $contadorGF['Bits']=$contadorGF['Bits']+$row['Bits'];
  $contadorGF['Tarjetas']=$contadorGF['Tarjetas']+$row['Tarjetas'];
  $contadorGF['GasOilPlata']=$contadorGF['GasOilPlata']+$row['GasOilPlata'];
  $contadorGF['GasOilLitros']=$contadorGF['GasOilLitros']+$row['GasOilLitros'];
  $contadorGF['Lavado']=$contadorGF['Lavado']+$row['Lavado'];
  $contadorGF['Gomeria']=$contadorGF['Gomeria']+$row['Gomeria'];
  $contadorGF['Cabify']=$contadorGF['Cabify']+$row['Cabify'];
  $contadorGF['Otros']=$contadorGF['Otros']+$row['Otros'];
  $contadorGF['Efectivo']=$contadorGF['Efectivo']+$row['Efectivo'];
  $contadorGF['Gastos']=$contadorGF['Gastos']+$row['Gastos'];
  $contadorGF['Liquido']=$contadorGF['Liquido']+$row['Liquido'];
  //$contadorGF['Observaciones']=$contadorGF['Observaciones']+$row['Observaciones'];
  $contadorGF['Kilometros']=$contadorGF['Kilometros']+$row['Kilometros'];
  $contadorGF['MercPagoPersonal']=$contadorGF['MercPagoPersonal']+$row['MercPagoPersonal'];
  $contadorGF['CabifyTarjetas']=$contadorGF['CabifyTarjetas']+$row['CabifyTarjetas'];
  $contadorGF['OtraRetencion']=$contadorGF['OtraRetencion']+$row['OtraRetencion'];
  $contadorGF['AporteReal']=$contadorGF['AporteReal']+$row['AporteReal'];

}
if(isset($ListaGV))
foreach($ListaGV as $row)
{
    
  //$contadorGV['id']=$contadorGV['']+$row['id'];
  //$contadorGV['fecha']=$contadorGV['']+$row[''];
  if(($contadorGV['KmEntrada']==0) or ($contadorGV['KmEntrada']>$row['KmEntrada']))
  {
    $contadorGV['KmEntrada']=$row['KmEntrada'];
  }
  if($contadorGV['KmSalida']<$row['KmSalida'])
  {
    $contadorGV['KmSalida']=$row['KmSalida'];
  }

  //$contadorGV['Chofer']=$contadorGV['']+$row[''];
  //$contadorGV['Movil']=$contadorGV['']+$row[''];
  //$contadorGV['HoraEntrada']=$contadorGV['']+$row[''];
  //$contadorGV['HoraSalida']=$contadorGV['']+$row[''];
  //$contadorGV['Sueldo']=$contadorGV['']+$row[''];
  //$contadorGV['BPS']=$contadorGV['']+$row[''];
  $contadorGV['Recaudado']=$contadorGV['Recaudado']+$row['Recaudado'];
  $contadorGV['Salario']=$contadorGV['Salario']+$row['Salario'];
  $contadorGV['Laudo']=$contadorGV['Laudo']+$row['Laudo'];
  $contadorGV['Comision']=$contadorGV['Comision']+$row['Comision'];
  $contadorGV['ViaticoNoCobrado']=$contadorGV['ViaticoNoCobrado']+$row['ViaticoNoCobrado'];
  $contadorGV['ViaticoCobrado']=$contadorGV['ViaticoCobrado']+$row['ViaticoCobrado'];
  $contadorGV['FeriadoNoCobrado']=$contadorGV['FeriadoNoCobrado']+$row['FeriadoNoCobrado'];
  $contadorGV['FeriadoCobrado']=$contadorGV['FeriadoCobrado']+$row['FeriadoCobrado'];
  $contadorGV['AporteSalario']=$contadorGV['AporteSalario']+$row['AporteSalario'];
  $contadorGV['AporteViatico']=$contadorGV['AporteViatico']+$row['AporteViatico'];
  $contadorGV['AporteFeriado']=$contadorGV['AporteFeriado']+$row['AporteFeriado'];
  $contadorGV['AporteTotales']=$contadorGV['AporteTotales']+$row['AporteTotales'];
  $contadorGV['H13Patronal']=$contadorGV['H13Patronal']+$row['H13Patronal'];
  $contadorGV['R12Celeritas']=$contadorGV['R12Celeritas']+$row['R12Celeritas'];
  $contadorGV['MerPagoCeleritas']=$contadorGV['MerPagoCeleritas']+$row['MerPagoCeleritas'];
  $contadorGV['H13Especiales']=$contadorGV['H13Especiales']+$row['H13Especiales'];
  $contadorGV['MercPago']=$contadorGV['MercPago']+$row['MercPago'];
  $contadorGV['OcaCel']=$contadorGV['OcaCel']+$row['OcaCel'];
  $contadorGV['Bits']=$contadorGV['Bits']+$row['Bits'];
  $contadorGV['Tarjetas']=$contadorGV['Tarjetas']+$row['Tarjetas'];
  $contadorGV['GasOilPlata']=$contadorGV['GasOilPlata']+$row['GasOilPlata'];
  $contadorGV['GasOilLitros']=$contadorGV['GasOilLitros']+$row['GasOilLitros'];
  $contadorGV['Lavado']=$contadorGV['Lavado']+$row['Lavado'];
  $contadorGV['Gomeria']=$contadorGV['Gomeria']+$row['Gomeria'];
  $contadorGV['Cabify']=$contadorGV['Cabify']+$row['Cabify'];
  $contadorGV['Otros']=$contadorGV['Otros']+$row['Otros'];
  $contadorGV['Efectivo']=$contadorGV['Efectivo']+$row['Efectivo'];
  $contadorGV['Gastos']=$contadorGV['Gastos']+$row['Gastos'];
  $contadorGV['Liquido']=$contadorGV['Liquido']+$row['Liquido'];
  //$contadorGV['Observaciones']=$contadorGV['Observaciones']+$row['Observaciones'];
  $contadorGV['Kilometros']=$contadorGV['Kilometros']+$row['Kilometros'];
  $contadorGV['MercPagoPersonal']=$contadorGV['MercPagoPersonal']+$row['MercPagoPersonal'];
  $contadorGV['CabifyTarjetas']=$contadorGV['CabifyTarjetas']+$row['CabifyTarjetas'];
  $contadorGV['OtraRetencion']=$contadorGV['OtraRetencion']+$row['OtraRetencion'];
  $contadorGV['AporteReal']=$contadorGV['AporteReal']+$row['AporteReal'];

}

if(isset($ListaMV))
foreach($ListaMV as $row)
{
    
  //$contadorMV['id']=$contadorMV['']+$row['id'];
  //$contadorMV['fecha']=$contadorMV['']+$row[''];
  if(($contadorMV['KmEntrada']==0) or ($contadorMV['KmEntrada']>$row['KmEntrada']))
  {
    $contadorMV['KmEntrada']=$row['KmEntrada'];
  }
  if($contadorMV['KmSalida']<$row['KmSalida'])
  {
    $contadorMV['KmSalida']=$row['KmSalida'];
  }

  //$contadorMV['Chofer']=$contadorMV['']+$row[''];
  //$contadorMV['Movil']=$contadorMV['']+$row[''];
  //$contadorMV['HoraEntrada']=$contadorMV['']+$row[''];
  //$contadorMV['HoraSalida']=$contadorMV['']+$row[''];
  //$contadorMV['Sueldo']=$contadorMV['']+$row[''];
  //$contadorMV['BPS']=$contadorMV['']+$row[''];
  $contadorMV['Recaudado']=$contadorMV['Recaudado']+$row['Recaudado'];
  $contadorMV['Salario']=$contadorMV['Salario']+$row['Salario'];
  $contadorMV['Laudo']=$contadorMV['Laudo']+$row['Laudo'];
  $contadorMV['Comision']=$contadorMV['Comision']+$row['Comision'];
  $contadorMV['ViaticoNoCobrado']=$contadorMV['ViaticoNoCobrado']+$row['ViaticoNoCobrado'];
  $contadorMV['ViaticoCobrado']=$contadorMV['ViaticoCobrado']+$row['ViaticoCobrado'];
  $contadorMV['FeriadoNoCobrado']=$contadorMV['FeriadoNoCobrado']+$row['FeriadoNoCobrado'];
  $contadorMV['FeriadoCobrado']=$contadorMV['FeriadoCobrado']+$row['FeriadoCobrado'];
  $contadorMV['AporteSalario']=$contadorMV['AporteSalario']+$row['AporteSalario'];
  $contadorMV['AporteViatico']=$contadorMV['AporteViatico']+$row['AporteViatico'];
  $contadorMV['AporteFeriado']=$contadorMV['AporteFeriado']+$row['AporteFeriado'];
  $contadorMV['AporteTotales']=$contadorMV['AporteTotales']+$row['AporteTotales'];
  $contadorMV['H13Patronal']=$contadorMV['H13Patronal']+$row['H13Patronal'];
  $contadorMV['R12Celeritas']=$contadorMV['R12Celeritas']+$row['R12Celeritas'];
  $contadorMV['MerPagoCeleritas']=$contadorMV['MerPagoCeleritas']+$row['MerPagoCeleritas'];
  $contadorMV['H13Especiales']=$contadorMV['H13Especiales']+$row['H13Especiales'];
  $contadorMV['MercPago']=$contadorMV['MercPago']+$row['MercPago'];
  $contadorMV['OcaCel']=$contadorMV['OcaCel']+$row['OcaCel'];
  $contadorMV['Bits']=$contadorMV['Bits']+$row['Bits'];
  $contadorMV['Tarjetas']=$contadorMV['Tarjetas']+$row['Tarjetas'];
  $contadorMV['GasOilPlata']=$contadorMV['GasOilPlata']+$row['GasOilPlata'];
  $contadorMV['GasOilLitros']=$contadorMV['GasOilLitros']+$row['GasOilLitros'];
  $contadorMV['Lavado']=$contadorMV['Lavado']+$row['Lavado'];
  $contadorMV['Gomeria']=$contadorMV['Gomeria']+$row['Gomeria'];
  $contadorMV['Cabify']=$contadorMV['Cabify']+$row['Cabify'];
  $contadorMV['Otros']=$contadorMV['Otros']+$row['Otros'];
  $contadorMV['Efectivo']=$contadorMV['Efectivo']+$row['Efectivo'];
  $contadorMV['Gastos']=$contadorMV['Gastos']+$row['Gastos'];
  $contadorMV['Liquido']=$contadorMV['Liquido']+$row['Liquido'];
  //$contadorMV['Observaciones']=$contadorMV['Observaciones']+$row['Observaciones'];
  $contadorMV['Kilometros']=$contadorMV['Kilometros']+$row['Kilometros'];
  $contadorMV['MercPagoPersonal']=$contadorMV['MercPagoPersonal']+$row['MercPagoPersonal'];
  $contadorMV['CabifyTarjetas']=$contadorMV['CabifyTarjetas']+$row['CabifyTarjetas'];
  $contadorMV['OtraRetencion']=$contadorMV['OtraRetencion']+$row['OtraRetencion'];
  $contadorMV['AporteReal']=$contadorMV['AporteReal']+$row['AporteReal'];

}

foreach($listaPA as $row)
{
    
  //$contadorPA['id']=$contadorPA['']+$row['id'];
  //$contadorPA['fecha']=$contadorPA['']+$row[''];
  if(($contadorPA['KmEntrada']==0) or ($contadorPA['KmEntrada']>$row['KmEntrada']))
  {
    $contadorPA['KmEntrada']=$row['KmEntrada'];
  }
  if($contadorPA['KmSalida']<$row['KmSalida'])
  {
    $contadorPA['KmSalida']=$row['KmSalida'];
  }

  //$contadorPA['Chofer']=$contadorPA['']+$row[''];
  //$contadorPA['Movil']=$contadorPA['']+$row[''];
  //$contadorPA['HoraEntrada']=$contadorPA['']+$row[''];
  //$contadorPA['HoraSalida']=$contadorPA['']+$row[''];
  //$contadorPA['Sueldo']=$contadorPA['']+$row[''];
  //$contadorPA['BPS']=$contadorPA['']+$row[''];
  $contadorPA['Recaudado']=$contadorPA['Recaudado']+$row['Recaudado'];
  $contadorPA['Salario']=$contadorPA['Salario']+$row['Salario'];
  $contadorPA['Laudo']=$contadorPA['Laudo']+$row['Laudo'];
  $contadorPA['Comision']=$contadorPA['Comision']+$row['Comision'];
  $contadorPA['ViaticoNoCobrado']=$contadorPA['ViaticoNoCobrado']+$row['ViaticoNoCobrado'];
  $contadorPA['ViaticoCobrado']=$contadorPA['ViaticoCobrado']+$row['ViaticoCobrado'];
  $contadorPA['FeriadoNoCobrado']=$contadorPA['FeriadoNoCobrado']+$row['FeriadoNoCobrado'];
  $contadorPA['FeriadoCobrado']=$contadorPA['FeriadoCobrado']+$row['FeriadoCobrado'];
  $contadorPA['AporteSalario']=$contadorPA['AporteSalario']+$row['AporteSalario'];
  $contadorPA['AporteViatico']=$contadorPA['AporteViatico']+$row['AporteViatico'];
  $contadorPA['AporteFeriado']=$contadorPA['AporteFeriado']+$row['AporteFeriado'];
  $contadorPA['AporteTotales']=$contadorPA['AporteTotales']+$row['AporteTotales'];
  $contadorPA['H13Patronal']=$contadorPA['H13Patronal']+$row['H13Patronal'];
  $contadorPA['R12Celeritas']=$contadorPA['R12Celeritas']+$row['R12Celeritas'];
  $contadorPA['MerPagoCeleritas']=$contadorPA['MerPagoCeleritas']+$row['MerPagoCeleritas'];
  $contadorPA['H13Especiales']=$contadorPA['H13Especiales']+$row['H13Especiales'];
  $contadorPA['MercPago']=$contadorPA['MercPago']+$row['MercPago'];
  $contadorPA['OcaCel']=$contadorPA['OcaCel']+$row['OcaCel'];
  $contadorPA['Bits']=$contadorPA['Bits']+$row['Bits'];
  $contadorPA['Tarjetas']=$contadorPA['Tarjetas']+$row['Tarjetas'];
  $contadorPA['GasOilPlata']=$contadorPA['GasOilPlata']+$row['GasOilPlata'];
  $contadorPA['GasOilLitros']=$contadorPA['GasOilLitros']+$row['GasOilLitros'];
  $contadorPA['Lavado']=$contadorPA['Lavado']+$row['Lavado'];
  $contadorPA['Gomeria']=$contadorPA['Gomeria']+$row['Gomeria'];
  $contadorPA['Cabify']=$contadorPA['Cabify']+$row['Cabify'];
  $contadorPA['Otros']=$contadorPA['Otros']+$row['Otros'];
  $contadorPA['Efectivo']=$contadorPA['Efectivo']+$row['Efectivo'];
  $contadorPA['Gastos']=$contadorPA['Gastos']+$row['Gastos'];
  $contadorPA['Liquido']=$contadorPA['Liquido']+$row['Liquido'];
  //$contadorPA['Observaciones']=$contadorPA['Observaciones']+$row['Observaciones'];
  $contadorPA['Kilometros']=$contadorPA['Kilometros']+$row['Kilometros'];
  $contadorPA['MercPagoPersonal']=$contadorPA['MercPagoPersonal']+$row['MercPagoPersonal'];
  $contadorPA['CabifyTarjetas']=$contadorPA['CabifyTarjetas']+$row['CabifyTarjetas'];
  $contadorPA['OtraRetencion']=$contadorPA['OtraRetencion']+$row['OtraRetencion'];
  $contadorPA['AporteReal']=$contadorPA['AporteReal']+$row['AporteReal'];
  echo "<br>";
  //print_r($row);

}

foreach($listaOtrosGastos as $row)
{
    
  //$contadorOtros['id']=$contadorOtros['']+$row['id'];
  //$contadorOtros['fecha']=$contadorOtros['']+$row[''];
  if(($contadorOtros['KmEntrada']==0) or ($contadorOtros['KmEntrada']>$row['KmEntrada']))
  {
    $contadorOtros['KmEntrada']=$row['KmEntrada'];
  }
  if($contadorOtros['KmSalida']<$row['KmSalida'])
  {
    $contadorOtros['KmSalida']=$row['KmSalida'];
  }

  //$contadorOtros['Chofer']=$contadorOtros['']+$row[''];
  //$contadorOtros['Movil']=$contadorOtros['']+$row[''];
  //$contadorOtros['HoraEntrada']=$contadorOtros['']+$row[''];
  //$contadorOtros['HoraSalida']=$contadorOtros['']+$row[''];
  //$contadorOtros['Sueldo']=$contadorOtros['']+$row[''];
  //$contadorOtros['BPS']=$contadorOtros['']+$row[''];
  $contadorOtros['Recaudado']=$contadorOtros['Recaudado']+$row['Recaudado'];
  $contadorOtros['Salario']=$contadorOtros['Salario']+$row['Salario'];
  $contadorOtros['Laudo']=$contadorOtros['Laudo']+$row['Laudo'];
  $contadorOtros['Comision']=$contadorOtros['Comision']+$row['Comision'];
  $contadorOtros['ViaticoNoCobrado']=$contadorOtros['ViaticoNoCobrado']+$row['ViaticoNoCobrado'];
  $contadorOtros['ViaticoCobrado']=$contadorOtros['ViaticoCobrado']+$row['ViaticoCobrado'];
  $contadorOtros['FeriadoNoCobrado']=$contadorOtros['FeriadoNoCobrado']+$row['FeriadoNoCobrado'];
  $contadorOtros['FeriadoCobrado']=$contadorOtros['FeriadoCobrado']+$row['FeriadoCobrado'];
  $contadorOtros['AporteSalario']=$contadorOtros['AporteSalario']+$row['AporteSalario'];
  $contadorOtros['AporteViatico']=$contadorOtros['AporteViatico']+$row['AporteViatico'];
  $contadorOtros['AporteFeriado']=$contadorOtros['AporteFeriado']+$row['AporteFeriado'];
  $contadorOtros['AporteTotales']=$contadorOtros['AporteTotales']+$row['AporteTotales'];
  $contadorOtros['H13Patronal']=$contadorOtros['H13Patronal']+$row['H13Patronal'];
  $contadorOtros['R12Celeritas']=$contadorOtros['R12Celeritas']+$row['R12Celeritas'];
  $contadorOtros['MerPagoCeleritas']=$contadorOtros['MerPagoCeleritas']+$row['MerPagoCeleritas'];
  $contadorOtros['H13Especiales']=$contadorOtros['H13Especiales']+$row['H13Especiales'];
  $contadorOtros['MercPago']=$contadorOtros['MercPago']+$row['MercPago'];
  $contadorOtros['OcaCel']=$contadorOtros['OcaCel']+$row['OcaCel'];
  $contadorOtros['Bits']=$contadorOtros['Bits']+$row['Bits'];
  $contadorOtros['Tarjetas']=$contadorOtros['Tarjetas']+$row['Tarjetas'];
  $contadorOtros['GasOilPlata']=$contadorOtros['GasOilPlata']+$row['GasOilPlata'];
  $contadorOtros['GasOilLitros']=$contadorOtros['GasOilLitros']+$row['GasOilLitros'];
  $contadorOtros['Lavado']=$contadorOtros['Lavado']+$row['Lavado'];
  $contadorOtros['Gomeria']=$contadorOtros['Gomeria']+$row['Gomeria'];
  $contadorOtros['Cabify']=$contadorOtros['Cabify']+$row['Cabify'];
  $contadorOtros['Otros']=$contadorOtros['Otros']+$row['Otros'];
  $contadorOtros['Efectivo']=$contadorOtros['Efectivo']+$row['Efectivo'];
  $contadorOtros['Gastos']=$contadorOtros['Gastos']+$row['Gastos'];
  $contadorOtros['Liquido']=$contadorOtros['Liquido']+$row['Liquido'];
  //$contadorOtros['Observaciones']=$contadorOtros['Observaciones']+$row['Observaciones'];
  $contadorOtros['Kilometros']=$contadorOtros['Kilometros']+$row['Kilometros'];
  $contadorOtros['MercPagoPersonal']=$contadorOtros['MercPagoPersonal']+$row['MercPagoPersonal'];
  $contadorOtros['CabifyTarjetas']=$contadorOtros['CabifyTarjetas']+$row['CabifyTarjetas'];
  $contadorOtros['OtraRetencion']=$contadorOtros['OtraRetencion']+$row['OtraRetencion'];
  $contadorOtros['AporteReal']=$contadorOtros['AporteReal']+$row['AporteReal'];

}

 
$aux0=$contador["Lavado"];
$aux0=$aux0+$contador["Gomeria"];
$aux0=$aux0+$contador["Cabify"];
foreach ($listaOtrosGastos as $row) 
{
  $aux0=$aux0+$row['Otros'];
}

$tempGanaciaNeta= $contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']);
//$tempGanaciaNeta= $contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']);
  //echo "$ ".$contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']); 
$tempGanaciaNeta=$tempGanaciaNeta-$contador['AceiteCred']-$desc[0][0]-$contador['LaudoNoCobrado'];
$tempGanaciaNeta=round($tempGanaciaNeta,2);

/*
$tempGanaciaNeta= $contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']);
//echo "$ ".$contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']); 
$tempGanaciaNeta=$tempGanaciaNeta-$contador['AceiteCred']-$desc[0][0];
echo "$ ".round($tempGanaciaNeta,2);*/

?>

<div class="container text-center abs-center">
  <h1>Resumen</h1>
  <hr>
  <form action="?plate=" method="post">
  Desde : 
  <input type='date' id='desde' name="desde" value='<?php echo $inicio;?>'>
  Hasta: 
  <input type='date' id='hasta' name="hasta" value='<?php echo $fin;?>'>&nbsp;&nbsp;&nbsp;
  <button type="sumit" class="btn btn-primary">Buscar</button>
</form>
  <hr>


<div id="columnchart_values" style="width: 100%; height: 600px;" class="container text-center abs-center"></div>

<div id="columnchart_values2" style="width: 100%; height: 600px;" class="container text-center abs-center"></div>

<div id="columnchart_values3" style="width: 100%; height: 600px;" class="container text-center abs-center"></div>

<div id="piechart" style="width: 900px; height: 500px;"></div>

</p>
  </div>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = google.visualization.arrayToDataTable([
        ["Element", "Monto", { role: "style" } ],
        <?php
        foreach($listaDeTipos as $row)
        {
            if($row['monto']<0)
                echo "[\"".$row['tipo']."\", ".$row['monto'].", '#ff0000'],";
            else
                echo "[\"".$row['tipo']."\", ".$row['monto'].", '#00ff00'],";
        }
        $Salarios=-1*$Salarios;
        //echo "[\"Salarios\", ".$Salarios.", '#0000ff'],";

        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

                       var options = {
        title: "Resumen de gastos",
        //width: 600,
        //height: 400,
        bar: {groupWidth: "50%"},
        legend: { position: "none" },
      };

        //var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        //chart.draw(view, google.charts.Bar.convertOptions(options));

        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values3"));
        chart.draw(view, options);
      };
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = google.visualization.arrayToDataTable([
        ["Element", "Recaudado", { role: "style" } ],
        <?php
        foreach($dt as $row)
        {
            echo "[\"".$row['Movil']." | ".$row['km']." $/km\", ".$row['Recaudado'].", '#b87333'],";
        }
        echo "[\"0\", 0, '#b87333'],";
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

                       var options = {
        title: "Recaudaciones por Móviles",
        //width: 600,
        //height: 400,
        bar: {groupWidth: "50%"},
        legend: { position: "none" },
      };

        //var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        //chart.draw(view, google.charts.Bar.convertOptions(options));

        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
      };
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        <?php
        foreach($dtChoferes as $row)
        {
            if($_SESSION['empresa']==$row['RUT'])
                echo "[\"".$row['Nombre']."\", ".$row['Recaudado'].", '#000000'],";
            else
                echo "[\"".$row['Nombre']."\", ".$row['Recaudado'].", '#ffff00'],";

        }
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

       var options = {
        title: "Recaudaciones por choferes",
        //width: 600,
        //height: 400,
        bar: {groupWidth: "50%"},
        legend: { position: "none" },
      };

        //var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        //chart.draw(view, google.charts.Bar.convertOptions(options));

        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
        chart.draw(view, options);
      };
    </script>
    <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart2);
    google.charts.setOnLoadCallback(drawChart3);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Móvil", "Recaudado", { role: "style" } ],
        <?php
        foreach($dt as $row)
        {
            echo "['".$row['Movil']."', ".$row['Recaudado'].", '#6ADAD3'],";
        }
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Recaudaciones por Móvil",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
    }
    function drawChart2() {
      var data = google.visualization.arrayToDataTable([
        ["Chofer", "Recaudado", { role: "style" } ],
        <?php
        foreach($dtChoferes as $row)
        {
            echo "['".$row['Nombre']."', ".$row['Recaudado'].", '#6ADAD3'],";
        }
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Recaudaciones por Chofer",
        width: 1000,
        height: 1300,
        bar: {groupWidth: "50%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values2"));
      chart.draw(view, options);
    }
    
    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart3);
      function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['Detalle', 'Monto'],
          ['Gastos Fijos: <?php echo "$ ".$contadorGF['Liquido']; ?>', <?php echo $contadorGF['Liquido']; ?>],
          ['Gastos Variables: <?php echo "$ ".$contadorGV['Liquido']*(-1); ?>', <?php echo $contadorGV['Liquido']*(-1); ?>],
          ['Salarios y Laudos:<?php echo "$ ".$contador['Salario']+$contador['Laudo']+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado']+$contador['LaudoNoCobrado']; ?>', <?php echo $contador['Salario']+$contador['Laudo']+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado']+$contador['LaudoNoCobrado']; ?>],
          ['Viáticos: <?php echo "$ ".$contador['ViaticoCobrado']+$contador['ViaticoNoCobrado']; ?>', <?php echo $contador['ViaticoCobrado']+$contador['ViaticoNoCobrado']; ?>],
          
        ]);
/*

*/
        var options = {
          title: 'Informe de Gastos',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Detalle', 'Monto'],
          ['Gastos Fijos: <?php echo "$ ".$contadorGF['Liquido']; ?>', <?php echo $contadorGF['Liquido']; ?>],
          ['Gastos Variables: <?php echo "$ ".$contadorGV['Liquido']*(-1); ?>', <?php echo $contadorGV['Liquido']*(-1); ?>],
          ['Salarios y Laudos:<?php echo "$ ".$contador['Salario']+$contador['Laudo']+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado']; ?>', <?php echo $contador['Salario']+$contador['Laudo']+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado']; ?>],
          ['Viáticos:<?php echo "$ ".$contador['ViaticoCobrado']+$contador['ViaticoNoCobrado']; ?>', <?php echo $contador['ViaticoCobrado']+$contador['ViaticoNoCobrado']; ?>],
          //['Ganancia Neta: <?php echo "$ ".round($tempGanaciaNeta+$contador['LaudoNoCobrado'],2); ?>', <?php echo round($tempGanaciaNeta+$contador['LaudoNoCobrado'],2); ?>],
          ['Ganancia Neta: <?php echo "$ ".round($tempGanaciaNeta,2); ?>', <?php echo round($tempGanaciaNeta,2); ?>],
          <?php foreach($combutibleTipos as $row)
        {
          echo "['".$row['Tipo'].": ".$row['Monto']."',".$row['Monto']."],";
        } ?>
        ]);

        var options = {
          title: 'Detalles generales'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
<body>
</body>
</html>
</div>