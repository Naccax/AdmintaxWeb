<?php
include 'index.php';
?>

<?php
 
if(true)
{

  /*
  $movil=$_GET['plate'];
    
  $consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
  $todosLosMoviles=ejecutarConsulta($consulta);*/

 
  $inicio = date("Y-m-01");
  $fin = date("Y-m-t");

  if(isset($_POST["desde"]))
  {
    $inicio = $_POST["desde"];
    $fin = $_POST["hasta"];
    $_SESSION["desde"]=$inicio;
    $_SESSION["hasta"]=$fin;
  }

  
  $resumenMoviles="(";
  foreach($todosLosMoviles as $row)
  {
    $resumenMoviles=str_replace(")"," or ", $resumenMoviles);
    $movil=$row['Matricula'];
    $resumenMoviles=$resumenMoviles."`Movil`='$movil')";

  }

  
  $sql="SELECT * FROM recaudaciones WHERE `fecha` BETWEEN '$inicio 00:00:00' AND '$fin 23:59:00' AND $resumenMoviles   ORDER BY `recaudaciones`.`HoraEntrada` ASC;";
  //$sql="SELECT * FROM recaudaciones WHERE `fecha` BETWEEN '$inicio 00:00:00' AND '$fin 23:59:00' AND `Movil`='$movil'  ORDER BY `recaudaciones`.`HoraEntrada` ASC;";
  //echo "$sql";
  $movimientos=ejecutarConsulta($sql);
  /*
  $sql="SELECT * FROM recaudaciones WHERE `fecha` BETWEEN '$inicio 00:00:00' AND '$fin 23:59:00' AND `Movil`='$movil'  ORDER BY `recaudaciones`.`HoraEntrada` ASC;";
  //echo "$sql";
  $movimientos=ejecutarConsulta($sql);
  //print_r($movimientos);*/

  ?>
  <div class="container text-center abs-center">
  <h1>Resumen de <?php echo $_SESSION['empresa']; ?></h1>
  <hr>
  <form action="#" method="post">
  Desde : 
  <input type='date' id='desde' name="desde" value='<?php echo $inicio;?>'>
  Hasta: 
  <input type='date' id='hasta' name="hasta" value='<?php echo $fin;?>'>&nbsp;&nbsp;&nbsp;
  <button type="sumit" class="btn btn-primary">Buscar</button>
</form>
  <hr>
    <a href="PlanillaDeTrabajo.php"><button type="sumit" class="btn btn-secondary">Obtener Planilla de Trabajo</button></a>
  </div>

  
  </div>


  <?php


  $Leasing=0;
  $Seguro=0;
  $Patronal=0;
  $Celeritas=0;
  $LoJack=0;
  $Administr=0;
  
  
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
  $contador['Electicidad']=0;


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

  $gastosDeGomeria=0;
  $gastosRepuestos=0;
  $gastosManoDeObra=0;

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
          if((str_contains($row['Observaciones'],'GOMERIA:')))
          {
            $listaGomeria[]=$row;
            $gastosDeGomeria=$row["Otros"]+$gastosDeGomeria; 
          }elseif((str_contains($row['Observaciones'],'REPUESTOS:')))
          {
            $ListaRepuesto[]=$row;
            $gastosRepuestos=$row["Otros"]+$gastosRepuestos;  
          }elseif((str_contains($row['Observaciones'],'MANO DE OBRA:')))
          {
            $listaMonoDeObra[]=$row; 
            $gastosManoDeObra=$row["Otros"]+$gastosManoDeObra; 
          }else/*if(!(str_contains($row['Observaciones'],'GV: Administración')))*/{
            $ListaGV[]=$row;
          }
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
    if($row['Combustible']=="Electrico")//$contador['Electicidad']
    {
      $contador['Electicidad']=$contador['Electicidad']+$row['GasOilCred'];
    }
    else
    {
      $contador['GasOilCred']=$contador['GasOilCred']+$row['GasOilCred'];
    }

    
    
    $contador['AceiteCont']=$contador['AceiteCont']+$row['AceiteCont'];
    $contador['AceiteCred']=$contador['AceiteCred']+$row['AceiteCred'];

  }
  $contador['KmEntrada']= min($listaDeKm);
  $contador['KmSalida']= max($listaDeKm);
  
  
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
    if(str_contains($row['Observaciones'], "GV: Administraci"))
    {
      $Administr=$Administr+$row['Efectivo'];
    }else
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
      
    

  }
  $Administr=$Administr*(-1);
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
      <!-- <td> Total Recaudado </td><td><?php echo "$ ".$contador['Recaudado']; ?></td> -->
      <td> Total Recaudado (Mas Aportes) </td><td><?php echo "$ ".$contador['Recaudado']." (".$contador['Recaudado']+$contador['AporteReal'].")"; ?></td>
    </tr>
    <tr>
      <td> Movimientos de Efectivo</td><td><?php echo "$ ".$contadorMV['Liquido']; ?></td>
    </tr>
    <tr>
      <td> Efectivo Ingresado</td><td><?php echo "$ ".$contador['Efectivo']; ?></td>
    </tr>
    <tr>
      <td> Pagos electrónicos</td><td><?php echo "$ ".$pagosElecrtonicos; ?></td>
    </tr>
    
    <tr class="Neutral">
      <td> Efectivo Real en el móvil</td><td><?php echo "$ ".$contador['Efectivo']+$contadorMV['Liquido']+$contadorGV['Liquido']-$contadorPA['Liquido']; ?></td>
    </tr>
    <tr>
      <td> EFECTIVO A ENTREGAR (Descontando Viáticos y Feriados)</td><td>
        <?php
        $aaa= $contador['Efectivo']-$contadorPA['Liquido']+$contadorMV['Liquido']+$contadorGV['Liquido']-($contador['FeriadoNoCobrado']+$contador['ViaticoNoCobrado']);
        echo "$ ".round($aaa,2); ?></td>
    </tr>
    <tr>
      <td> Aportes Dejados Por Choferes</td><td><?php echo "$ ".$contador['AporteReal']; ?></td>
    </tr>
    <tr>
      <td> Gastos Variables</td><td><?php echo "$ ".$contadorGV['Liquido']*(-1); ?></td>
    </tr>
    <tr>
      <td> Gastos Fijos</td><td><?php echo "$ ".$contadorGF['Liquido'] + $Administr;?></td>
    </tr>
    <tr>
      <td> Gastos de Aceite</td><td><?php echo "$ ".$sumaAceites; ?></td>
    </tr>
    <tr>
      <td> Otros Gastos en Boletas</td><td><?php echo "$ ".$contador['Otros']; ?></td>
    </tr>
    <tr>
      <td> Salarios más complementos de laudos, feriados y horas de taller</td>
      <td><?php echo "$ ".$contador['Salario']+$contador['Laudo']+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado']; ?></td>
    </tr>
    <tr>
      <td> Viáticos (Todos)</td><td><?php echo "$ ".$contador['ViaticoCobrado']+$contador['ViaticoNoCobrado']; ?></td>
    </tr>
    <tr>
      <td> Gas-Oil Contado</td><td><?php echo "$ ".$contador['GasOilPlata']; ?></td>
    </tr>
    <?php if($contador['GasOilCred']>0){?>
    <tr>
      <td> Gas-Oil Crédito</td><td><?php echo "$ ".round($contador['GasOilCred'],2); ?></td>
    </tr>
    <tr>
      <td> Electricidad Crédito</td><td><?php echo "$ ".round($contador['Electicidad'],2); ?></td>
    </tr>
    <tr>
      <td> Lavados </td><td><?php echo "$ ".round($contador['Lavado'],2); ?></td>
    </tr>
    <tr>
      <td>Gomerias: </td><td><?php echo "$ ".round($contador['Gomeria']+$gastosDeGomeria,2); ?></td>
    </tr>
    <tr>
      <td>Repuestos: </td><td><?php echo "$ ".round($gastosRepuestos,2); ?></td>
    </tr>
    <tr>
      <td>Mano de obra: </td><td><?php echo "$ ".round($gastosManoDeObra,2); ?></td>
    </tr>
    <tr class="filaAzul">
      <td> Retenciones Judiciales dejadas por los choferes</td><td><?php echo "$ ".$contadorPA['Liquido']; ?></td>
    </tr>
    <?php }?>
    <tr class="Neutral">
      <td> Ganancia Neta:</td><td>
        <?php
        $tempGanaciaNeta=$gastosManoDeObra+$gastosRepuestos+$contador['Gomeria']+$gastosDeGomeria+$contador['Lavado']+$contador['Electicidad']+$contador['GasOilCred']
        +$contador['GasOilPlata']+$contador['ViaticoCobrado']+$contador['ViaticoNoCobrado'];
        $tempGanaciaNeta=$tempGanaciaNeta+$contador['Salario']+$contador['Laudo']+$contador['FeriadoNoCobrado']+$contador['FeriadoCobrado']+$contador['Otros']+$sumaAceites+$contadorGF['Liquido']+$Administr;
        $tempGanaciaNeta=$tempGanaciaNeta+$contadorGV['Liquido']*(-1);
        $tempGanaciaNeta=$contador['Recaudado']-$tempGanaciaNeta;
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
      <td> Tarjetas (POS)</td><td><?php echo $contador['Tarjetas']; ?></td>
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
  <h2>Detalle de Gastos Fijos</h1>
  <hr>
  <?php
    //print_r($ListaGV);
    foreach ($ListaGF as $row) 
    {
      //str_contains(string $row[], string $needle)
      if(str_contains($row['Observaciones'], "Leasing")){$Leasing=$Leasing+$row['Liquido'];}
      elseif(str_contains($row['Observaciones'], "Seguro")){$Seguro=$Seguro+$row['Liquido'];}
      elseif(str_contains($row['Observaciones'], "Patronal")){$Patronal=$Patronal+$row['Liquido'];}
      elseif(str_contains($row['Observaciones'], "Celeritas")){$Celeritas=$Celeritas+$row['Liquido'];}
      elseif(str_contains($row['Observaciones'], "LoJack")){$LoJack=$LoJack+$row['Liquido'];}
      elseif(str_contains($row['Observaciones'], "Administr")){$Administr=$Administr+$row['Liquido'];}
      /*
      echo "<tr>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Liquido'];
      echo "</td>";
      echo "</tr>";*/
    }/*
      echo "<tr>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "<b>$ ".$contadorGF['Liquido']+$Administr;
      echo "</td>";
      echo "</tr>";*/

    ?>


  <table class="table">
    <thead>
    <tr>
    <th>Detalle</th>  <th>Monto</td>
    </tr></thead>
    <tr>
      <td>Cuotas de Leassing</td><td><?php echo "$ ".$Leasing; ?></td>
    </tr>
    <tr>
      <td>Cuotas de Seguro</td><td><?php echo "$ ".$Seguro; ?></td>
    </tr>
    <tr>
      <td>Cuotas de Patronal</td><td><?php echo "$ ".$Patronal; ?></td>
    </tr>
    <tr>
      <td>Cuotas de Celeritas</td><td><?php echo "$ ".$Celeritas; ?></td>
    </tr>
    <tr>
      <td>Cuotas de LoJack</td><td><?php echo "$ ".$LoJack; ?></td>
    </tr>
    <tr>
      <td>Administración</td><td><?php echo "$ ".$Administr; ?></td>
    </tr>
    <tr>
      <td></td><td><?php echo "$ ".$contadorGF['Liquido']+$Administr; ?></td>
    </tr>
    
  </table>

  </div>



  <div class="container text-center abs-center">
  <h2>Detalle de Gastos Variables</h1>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</td> <th>móvil</th> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    $sumaDeGastosVariables=0;
  if(isset($ListaGV))
    foreach ($ListaGV as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Otros'];
      $sumaDeGastosVariables=$sumaDeGastosVariables+$row['Otros'];
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
    echo "<b>$ ".$sumaDeGastosVariables;
    echo "</td>";
    echo "</tr>";

    ?>
  </table>

  <hr>
  <h3>Gomerías no incluídas en boletas</h3>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</td><th>Móvil</th> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php
    $gastosDegomería=0; 
    //print_r($ListaGV);
  if(isset($listaGomeria))
    foreach ($listaGomeria as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Otros'];
      $gastosDegomería=$gastosDegomería+$row['Otros'];
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
    echo "<b>$ ".$gastosDegomería." (Total: $ ".$contador["Gomeria"]+$gastosDegomería.")";
    echo "</td>";
    echo "</tr>";

    ?>
  </table>
  
  <hr>
  <h3>Repuestos</h3>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</td> <th>Móvil</th> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    $gastosDeRepuestos=0;
  if(isset($ListaRepuesto))
    foreach ($ListaRepuesto as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Otros'];
      $gastosDeRepuestos=$gastosDeRepuestos + $row['Otros'];
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
    echo "<b>$ ".$gastosDeRepuestos;
    echo "</td>";
    echo "</tr>";

    ?>
  </table>
  
  <hr>
  <h3>Manos De Obra</h3>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</td><th>Móvil</th> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    $gastosMonoDeObra=0;
  if(isset($listaMonoDeObra))
    foreach ($listaMonoDeObra as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td>";
      echo $row['Movil'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Otros'];
      $gastosMonoDeObra=$gastosMonoDeObra+$row['Otros'];
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
    echo "<b>$ ".$gastosMonoDeObra;
    echo "</td>";
    echo "</tr>";

    ?>
  </table>

  </div>
<!--
  <div class="container text-center abs-center">
  <h2>Detalle de Otros Gastos en Boletas</h1>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</td> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);

    

    
    echo "<tr>";
    echo "<td></td>";
    echo '<td colspan="1">';
    echo "Lavado";
    echo "</td>";
    echo "<td>";
    echo $contador["Lavado"];
    $aux=$contador["Lavado"];
    echo "</td>";
    echo "</tr>";
    

    
    
    echo "<tr>";
    echo "<td></td>";
    echo '<td colspan="1">';
    echo "Aceite Cr&eacute;dito:";
    echo "</td>";
    echo "<td>";
    echo $contador["AceiteCred"];
    $aux=$contador["AceiteCred"];
    echo "</td>";
    echo "</tr>";


    echo "<tr>";
    echo "<td></td>";
    echo '<td colspan="1">';
    echo "Gomería";
    echo "</td>";
    echo "<td>";
    echo $contador["Gomeria"];
    $aux=$aux+$contador["Gomeria"];
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td></td>";
    echo '<td colspan="1">';
    echo "Cabify";
    echo "</td>";
    echo "<td>";
    echo $contador["Cabify"];
    $aux=$aux+$contador["Cabify"];
    echo "</td>";
    echo "</tr>";



    foreach ($listaOtrosGastos as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Otros'];
      $aux=$aux+$row['Otros'];
      echo "</td>";
      echo "</tr>";
    }

    

    echo "<tr>";
    echo "<td>";
    echo "</td>";
    echo "<td>";
    echo "</td>";
    echo "<td>";
    //echo "<b>$ " . $contadorOtros['Otros'] + $contadorOtros['Gomeria'] + $contadorOtros['Lavado'] + $contadorOtros['Cabify'];
    echo "<b>$" . $aux;
    echo "</td>";
    echo "</tr>";

    ?>
  </table>

  </div>
  -->

  <div class="container text-center abs-center">
  <h2>Efectivo retirado o depositado</h1>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Fecha</td> <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    if(isset($ListaMV))
    foreach ($ListaMV as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['fecha'];
      echo "</td>";
      echo "<td>";
      echo $row['Movil'] . ":" . $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Efectivo'];
      echo "</td>";
      echo "</tr>";
    }
      echo "<tr>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "<b>$ ".$contadorMV['Efectivo'];
      echo "</td>";
      echo "</tr>";

    ?>
  </table>

  </div>


  <div class="container text-center abs-center">
  <h2>Detalle de Retenciones Judiciales</h1>
  <hr>

  <table class="table">
    <thead>
    <tr>
    <th>Detalle</th> <th>Monto</td>
    </tr></thead>
    <?php 
    //print_r($ListaGV);
    foreach ($listaPA as $row) 
    {
      echo "<tr>";
      echo "<td>";
      echo $row['Observaciones'];
      echo "</td>";
      echo "<td>";
      echo $row['Liquido'];
      echo "</td>";
      echo "</tr>";
    }
      echo "<tr>";
      echo "<td>";
      echo "</td>";
      echo "<td>";
      echo "<b>$ ".$contadorPA['Liquido'];
      echo "</td>";
      echo "</tr>";

    ?>
  </table>

  </div>












  <div class="container text-center abs-center">
  <h2>Paramétricas</h1>
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