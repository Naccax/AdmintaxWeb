<?php
include 'index.php';

  
$consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
$todosLosMoviles=ejecutarConsulta($consulta);


$inicio = date("Y-m-01");
$fin = date("Y-m-t");

$definido=false;

if(isset($_POST["desde"]))
{
  $inicio = $_POST["desde"];
  $fin = $_POST["hasta"];
  $_SESSION["desde"]=$inicio;
  $_SESSION["hasta"]=$fin;
  $definido=true;
}

$resumenMoviles="(";
foreach($todosLosMoviles as $row)
{
  $resumenMoviles=str_replace(")"," or ", $resumenMoviles);
  $movil=$row['Matricula'];
  $resumenMoviles=$resumenMoviles."`Movil`='$movil')";

}
$sep=explode("-",$inicio);
$sep2=explode("-",$fin);
?>



<?php
 
if(true)
{
  //$movil=$_GET['plate'];
  ?>
  <div class="container text-center abs-center">
  <h1>Resumen de estado de  <?php echo $_SESSION['empresa']; ?></h1>
  <hr>
  <form action="?plate=" method="post">
  Desde :
   <input type='date' id='desde' name="desde" value='<?php echo "$sep[0]-$sep[1]-$sep[2]";?>'>
  Hasta: 
  <input type='date' id='hasta' name="hasta" value='<?php echo "$sep2[0]-$sep2[1]-$sep2[2]";?>'>&nbsp;&nbsp;&nbsp;
  <button type="sumit" class="btn btn-primary">Buscar</button>
</form>
  <hr>
    <a href="PlanillaDeTrabajo.php"><button type="sumit" class="btn btn-secondary">Obtener Planilla de Trabajo</button></a>
  </div>


  <?php

  //echo $resumenMoviles;



  $sql="SELECT * FROM recaudaciones WHERE `fecha` BETWEEN '$inicio 00:00:00' AND '$fin 23:59:00' AND $resumenMoviles   ORDER BY `recaudaciones`.`HoraEntrada` ASC;";
  //$sql="SELECT * FROM recaudaciones WHERE `fecha` BETWEEN '$inicio 00:00:00' AND '$fin 23:59:00' AND `Movil`='$movil'  ORDER BY `recaudaciones`.`HoraEntrada` ASC;";
  //echo "$sql";
  $movimientos=ejecutarConsulta($sql);
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

  
  
  $ListaGF=[];
  $GF=0;
  $listaGV=[];
  $listaMV=[];
  $listarecaudaciones=[];
  $listaOtrosGastos=[];
  $listaDeKm=[];
  
  $listaPA=[];

  foreach($movimientos as $row)
  {
    
    if(str_contains($row['Observaciones'],'P.A. Retención: '))
    {
      $listaPA[]=$row;
      print_r($row);
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

//print_r($choferes[6]['Nombre']);

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
      $listaDeKm[$row['Movil']][]=$row['KmEntrada'];
      $listaDeKm[$row['Movil']][]=$row['KmSalida'];
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

  }
  $contador['KmEntrada']= 0;
  $kilometrosTotalesDeEmpresa=0;
  foreach($listaDeKm as $row)
  {
    $kilometrosTotalesDeEmpresa=$kilometrosTotalesDeEmpresa+max($row)-min($row);
    /*echo "<br>";//.(max($row['Matricula']))-(min($row['Matricula']));
    echo min($row)."<br>";
    echo max($row)."<br>";
    print_r($row);*/
  }
  $contador['KmSalida']= $kilometrosTotalesDeEmpresa;
  
  
  
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






















  ?>


<div class="container text-center abs-center">
  <h2>Informe general</h1>
  <hr>

  <table class="table">
    <thead>
    <tr>
      <th>Detalle</td> <th>Monto</td>
    </tr></thead>
    <tr>
      <td> Total Recaudado </td><td><?php echo "$ ".$contador['Recaudado']; ?></td>
    </tr>
    <tr>
      <td> Efectivo Recaudado</td><td><?php echo "$ ".$contador['Efectivo']; ?></td>
    </tr>
    <tr>
      <td> Pagos electrónicos</td><td><?php echo "$ ".$pagosElecrtonicos; ?></td>
    </tr>
    <tr>
      <td> Gastos Variables</td><td><?php echo "$ ".$contadorGV['Liquido']*(-1); ?></td>
    </tr>
    <tr>
      <td> Efectivo Depositado o Retirado</td><td><?php echo "$ ".$contadorMV['Liquido']; ?></td>
    </tr>
    
    <tr class="Neutral">
      <td> Efectivo Real en el móvil</td><td><?php echo "$ ".$contador['Efectivo']+$contadorMV['Liquido']+$contadorGV['Liquido']; ?></td>
    </tr>
    <tr>
      <td> EFECTIVO A ENTREGAR (Descontando Viáticos y Feriados)</td><td><?php echo "$ ".$contador['Efectivo']+$contadorMV['Liquido']+$contadorGV['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']); ?></td>
    </tr>
    <tr>
      <td> Gastos Fijos</td><td><?php echo "$ ".$contadorGF['Liquido']; ?></td>
    </tr>
    <tr>
      <td> Otros Gastos en Boletas</td><td><?php echo "$ ".$contadorGF['Liquido']; ?></td>
    </tr>
    <tr>
      <td> Gas-Oil Contado</td><td><?php echo "$ ".$contador['GasOilPlata']; ?></td>
    </tr>
    <?php if($contador['GasOilCred']>0){?>
    <tr>
      <td> Gas-Oil Crédito</td><td><?php echo "$ ".round($contador['GasOilCred'],2); ?></td>
    </tr>
    <?php }?>
    <tr class="Neutral">
      <td> Ganancia Neta:</td>
      <td>
        <?php
        $tempGanaciaNeta= $contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']);
        //echo "$ ".$contador['Recaudado']-$contador['GasOilCred']-$contador['Gastos']-($contadorGV['Liquido']*(-1))-$contadorGF['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']); 
        echo "$ ".round($tempGanaciaNeta,2);
        ?></td>
    </tr>

  </table>

  </div>

  <div class="container text-center abs-center">
  <h3>Detalle de pagos electrónicos</h3>
  <hr>

  <table class="table">
    <thead>
    <tr>
      <th>Detalle</td> <th>Monto</td>
    </tr></thead><?php if($contador['Tarjetas']>0){ ?>
    <tr>
      <td> Tarjetas</td><td><?php echo $contador['Tarjetas']; ?></td>
    </tr><?php } if($contador['MercPago']>0){ ?>
    <tr>
      <td> Merc. Pagos</td><td><?php echo $contador['MercPago']; ?></td>
    </tr><?php } if($contador['H13Patronal']>0){ ?>
    <tr>
      <td> H13 Patronal</td><td><?php echo $contador['H13Patronal']; ?></td>
    </tr><?php } if($contador['R12Celeritas']>0){ ?>
    <tr>
      <td> R12 Celeritas</td><td><?php echo $contador['R12Celeritas']; ?></td>
    </tr><?php } if($contador['MerPagoCeleritas']>0){ ?>
    <tr>
      <td> Merc. Pagos Celeritas</td><td><?php echo $contador['MerPagoCeleritas']; ?></td>
    </tr><?php } if($contador['H13Especiales']>0){ ?>
    <tr>
      <td> H13 Especiales</td><td><?php echo $contador['H13Especiales']; ?></td>
    </tr><?php } if($contador['OcaCel']>0){ ?>
    <tr>
      <td> Pagos OCA Cel</td><td><?php echo $contador['OcaCel']; ?></td>
    </tr><?php } if($contador['Bits']>0){ ?>
    <tr>
      <td> Pagos Bits</td><td><?php echo $contador['Bits']; ?></td>
    </tr><?php } if($contador['MercPagoPersonal']>0){ ?>
    <tr>
      <td> Mer. Pagos Personal</td><td><?php echo $contador['MercPagoPersonal']; ?></td>
    </tr><?php } if($contador['CabifyTarjetas']>0){ ?>
    <tr>
      <td> Cabify Tarjetas</td><td><?php echo $contador['CabifyTarjetas']; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td></td><td><b><?php echo "$ ".$pagosElecrtonicos; ?></td>
    </tr>

  </table>

  </div>


  <div class="container text-center abs-center">
  <h2>Detalle de Gastos Variables</h1>
  <hr>

  <table class="table" style='width:100%;'>
    <thead>
    <tr>
    <th>Fecha</td> <th>Móvil</th> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    foreach ($ListaGV as $row) 
    {
      echo "<tr>";
      echo "<td style='width:15%;'>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td style='width:8%;'>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td style='width:8%;'>";
      echo $row['Otros'];
      echo "</td>";
      echo "</tr>";
    }
    echo "<tr>";
    echo "<td>";
    echo "</td>";
    echo "<td>";
    echo "</td>";
    echo "<td>";
    echo "</td>";
    echo "<td>";
    echo "<b>$ ".$contadorGV['Otros'];
    echo "</td>";
    echo "</tr>";

    ?>
  </table>

  </div>

  <div class="container text-center abs-center">
  <h2>Efectivo retirado o depositado</h1>
  <hr>

  <table class="table" style='width:100%;'>
    <thead>
    <tr>
    <th>Fecha</td> <th>Móvil</th> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    foreach ($ListaMV as $row) 
    {
      echo "<tr>";
      echo "<td style='width:15%;'>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td style='width:8%;'>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td style='width:8%;'>";
      echo $row['Liquido'];
      echo "</td>";
      echo "</tr>";
    }
      echo "<tr>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "<b>$ ".$contadorMV['Liquido'];
      echo "</td>";
      echo "</tr>";

    ?>
  </table>

  </div>


  
  <div class="container text-center abs-center">
  <h2>Detalle de Gastos Fijos</h1>
  <hr>

  <table class="table"  style='width:100%;'>
    <thead>
    <tr>
    <th>Móvil</th><th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    foreach ($ListaGF as $row) 
    {
      echo "<tr>";
      echo "<td style='width:8%;'>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td style='width:8%;'>";
      echo $row['Liquido'];
      echo "</td>";
      echo "</tr>";
    }
      echo "<tr>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "<b>$ ".$contadorGF['Liquido'];
      echo "</td>";
      echo "</tr>";

    ?>
  </table>

  </div>




  <div class="container text-center abs-center">
  <h2>Paramétricas del Movil</h1>
  <hr>

  <table class="table">
    <thead>
    <tr>
      <th>Detalle</td> <th>Cantidad</td>
    </tr></thead>
    <tr>
      <td> Kilómetros recorridos incluído relevos</td><td><?php echo $contador['KmSalida']-$contador['KmEntrada']; ?></td>
    </tr>
    <tr>
      <td> Kilómetros recorridos en turnos</td><td><?php echo $contador['Kilometros']; ?></td>
    </tr>
    <tr>
      <td> Litros consumidos de combustible</td><td><?php echo $contador['GasOilLitros']; ?></td>
    </tr>
    <tr>
      <td > Kilómetros por Litro</td><td><?php $number=($contador['KmSalida']-$contador['KmEntrada'])/$contador['GasOilLitros']; $number=round($number, 2); echo $number; ?></td>
    </tr>
    <tr>
      <td> Pesos por Kilómetro</td><td><?php $number = $contador['Recaudado']/$contador['Kilometros']; $number=round($number, 2); echo $number;?></td>
    </tr>

  </table>

  </div>



<?php

//EFECTIVO A ENTREGAR (Descontando Viáticos y Feriados)



/*
  echo "<br><br><br>";
  print_r($ListaGF);
  echo "<br><br><br>";
  print_r($ListaGV);
  echo "<br><br><br>";
  print_r($ListaMV);
  echo "<br><br><br>";
  print_r($listaOtrosGastos);*/













}
?>