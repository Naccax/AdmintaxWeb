

<?php
 

 include 'funciones.php';
 session_start();



if((isset($_GET['plate'])))
{
  $movil=$_GET['plate'];
  ?>
  <div class="container text-center abs-center">
  <h1>Resumen de estado del M&oacute;vil <?php echo $_GET['plate']; ?></h1>
  <hr>
  <form action="?plate=<?php echo $_GET['plate']; ?>" method="post">
  Desde : 
  <input type='date' id='desde' name="desde" value='<?php echo date("Y-m-01");?>'>
  Hasta: 
  <input type='date' id='hasta' name="hasta" value='<?php echo date("Y-m-t");?>'>&nbsp;&nbsp;&nbsp;
  <button type="sumit" class="btn btn-primary">Buscar</button>
</form>
  <hr>
  </div>


  <?php

  
  $consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
  $todosLosMoviles=ejecutarConsulta($consulta);

 
  $inicio = date("Y-m-01");
  $fin = date("Y-m-t");

  if(isset($_POST["desde"]))
  {
    $inicio = $_POST["desde"];
    $fin = $_POST["hasta"];
  }
  
  $sql="SELECT * FROM recaudaciones,movil,empresa,`chofer` WHERE `fecha` BETWEEN '$inicio' AND '$fin' AND (recaudaciones.Chofer=`chofer`.`id`) and recaudaciones.MovilId=Movil.Id and Movil.Id=6 and Movil.NumRut=empresa.NumeroDeRUT  ORDER BY `recaudaciones`.`HoraEntrada` ASC;";
  echo "$sql".'<br>';
  $movimientos=ejecutarConsulta($sql);

  $sql="Select * from librocontable WHERE `Fecha` BETWEEN '$inicio' AND '$fin' ";
  $libroContable=ejecutarConsulta($sql);




  print_r($libroContable);
  
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
  $contador['GasOilCred']=0;
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
  $listaPA=[];
  $listarecaudaciones=[];
  $listaOtrosGastos=[];
  $listaDeKm=[];

  foreach($movimientos as $row)
  {
    
    if(str_contains($row['Observaciones'],'P.A. Retenci'))
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
    
    $contador['GasOilCred']=$contador['GasOilCred']+$row['GasOilCred'];
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

  }

  $contador['KmEntrada']= min($listaDeKm);
  $contador['KmSalida']= max($listaDeKm);
  /*
  echo "<br><br>";
  print_r($listaDeKm);
  echo "<br><br>";
  echo $contador['KmEntrada'];
  echo "<br><br>";
  echo $contador['KmSalida'];*/
  
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
?>
<a href="index.php">(volver)</a>
<br><br>
<table style="width:4000px;" border='1'>
    <thead>
    <tr style="background-color: black;
    color: white;">
    <th>Id</th> 
    <th>Fecha</th> 
    <th>Fecha entrada</th> 
    <th>Fecha salida</th> 
    <th>Chofer</td> 
    <th>Movil</td> 
    <th>Recaudado</td> 
    <th>Sal. Chofer</td> 
    <th>Comp. Laudo</td> 
    <th>Comision</td> 
    <th>Viático No Cobrado</td> 
    <th>Viático Cobrado</td> 
    <th>Feriados No Cobrados</td> 
    <th>Feriados Cobrados</td> 
    <th>Ap. Sueldo</td> 
    <th>Ap. Viático</td> 
    <th>Ap. Total</td> 
    <th>H13 Patronal</td> 
    <th>R12 Celeritas</td> 
    <th>Merc. Pagos Celeritas</td> 
    <th>H13 Especiales</td> 
    <th>Mec. Pago</td> 
    <th>Ocal Cel</td> 
    <th>Bits</td> 
    <th>Tarjetas</td> 
    <th>Merc. Personal</td> 
    <th>Cabify Tarjetas</td> 
    <th>Gas-Oil (cred.)</td> 
    <th>Gas-Oil</td> 
    <th>Litros</td>
    <th>Kilometros</td>
    <th>Lavado</td>
    <th>Gomería</td>
    <th>Cabify</td>
    <th>Otros</td>
    <th>Efectivo</td>
    <th>Observaciones</td>
    </tr></thead>

    <?php

//print_r ($movimientos);
foreach($movimientos as $row)
{
  echo "<tr>";
  echo "<td width='10'>";
  echo $row[0];
  echo "</td><td width='150'>";
  echo $row['fecha'];
  echo "</td><td width='150'>";
  echo $row['HoraEntrada'];
  echo "</td><td width='150'>";
  echo $row['HoraSalida'];
  echo "</td><td>";
  echo $row['Chofer'];
  echo "</td><td>";
  echo $row['Movil'];
  echo "</td><td>";
  echo $row['Recaudado'];
  echo "</td><td>";
  echo $row['Salario'];
  echo "</td><td>";
  echo $row['Laudo'];
  echo "</td><td>";
  echo $row['Comision'];
  echo "</td><td>";
  echo $row['ViaticoNoCobrado'];
  echo "</td><td>";
  echo $row['ViaticoCobrado'];
  echo "</td><td>";
  echo $row['FeriadoNoCobrado'];
  echo "</td><td>";
  echo $row['FeriadoCobrado'];
  echo "</td><td>";
  echo $row['AporteSalario'];
  echo "</td><td>";
  echo $row['AporteViatico'];
  echo "</td><td>";
  echo $row['AporteReal'];

  echo "</td><td>";
  echo $row['H13Patronal'];
  echo "</td><td>";
  echo $row['R12Celeritas'];
  echo "</td><td>";
  echo $row['MerPagoCeleritas'];
  echo "</td><td>";
  echo $row['H13Especiales'];
  echo "</td><td>";
  echo $row['MercPago'];
  echo "</td><td>";
  echo $row['OcaCel'];
  echo "</td><td>";
  echo $row['Bits'];
  echo "</td><td>";
  echo $row['Tarjetas'];
  echo "</td><td>";
  echo $row['MercPagoPersonal'];
  echo "</td><td>";
  echo $row['CabifyTarjetas'];
//$contador['GasOilCred']
  echo "</td><td>";
  echo $row['GasOilCred'];
  echo "</td><td>";
  echo $row['GasOilPlata'];
  echo "</td><td>";
  echo $row['GasOilLitros'];
  echo "</td><td>";
  echo $row['Kilometros'];
  echo "</td><td>";
  echo $row['Lavado'];
  echo "</td><td>";
  echo $row['Gomeria'];
  echo "</td><td>";
  echo $row['Cabify'];
  echo "</td><td>";
  echo $row['Otros'];
  echo "</td><td>";
  echo $row['Efectivo'];
  echo "</td><td>";
  echo $row['Observaciones'];
  echo "</td></tr>";
  
}
    
    
    
    ?>
  </table>


<?php
}

?>