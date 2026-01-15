<?php
include 'index.php';
?>

<?php
 
if((isset($_GET['plate'])))
{
  $movil=$_GET['plate'];
    
  $consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
  $todosLosMoviles=ejecutarConsulta($consulta);

 
  $inicio = date("Y-m-01");
  $fin = date("Y-m-t");

  if(isset($_POST["desde"]))
  {
    $inicio = $_POST["desde"];
    $fin = $_POST["hasta"];
  }
  
  $sql="SELECT * FROM recaudaciones WHERE `Movil`='$movil' and Mantenimiento=".'"True"'." ORDER BY `recaudaciones`.`HoraEntrada` desc;";
  //echo "$sql";
  $movimientos=ejecutarConsulta($sql);
  //print_r($movimientos);

  
  $sql="SELECT max(`KmSalida`) FROM recaudaciones WHERE `Movil`='$movil';";
  $kilometrajeactual=ejecutarConsulta($sql);


  ?>
  <div class="container text-center abs-center">
  <h1>Mantenimientos de M&oacute;vil <?php echo $_GET['plate']; ?></h1>
  </div>


  <?php


  
  
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

  foreach($movimientos as $row)
  {

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

//print_r($choferes[6]['Nombre']);

  foreach($listarecaudaciones as $row)
  {
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

  ?>
  


  <div class="container text-center abs-center">
    <h3>Kilometraje actual: <?php echo $kilometrajeactual[0][0]; ?></h3>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</th> <th>Detalle</th> <th>Monto</th><th>Kilometros</th><th>Prox.(KM)</th>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    //KmDuracion
  if(isset($movimientos))
    foreach ($movimientos as $row) 
    {
      if(($row['KmDuracion'] < $kilometrajeactual[0][0]) and ($row['KmDuracion']>0) and ($row['Alarma']=="True"))
      {
        echo '<tr class="filaRoja">';
      }
      else
      {
        echo "<tr>";
      }
      echo "<td>";
      $sep = explode(" ", $row['fecha']);
      echo $sep[0];
      echo "</td>";
      echo "<td  class='dts'>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td class='kms'>";
      echo $row['Gastos'];
      echo "</td>";
      echo "<td class='kms'>";
      echo $row['KmEntrada'];
      echo "</td>";
      echo "<td class='kms'>";
      echo $row['KmDuracion'];
      echo "</td>";


      echo "</tr>";
    }

    ?>
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