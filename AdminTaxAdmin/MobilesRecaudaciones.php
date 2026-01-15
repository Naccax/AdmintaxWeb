
<?php 
include('index.php');


$inicio = date("Y-m-01");
$fin = date("Y-m-t");

if(isset($_POST["desde"]))
{
  $inicio = $_POST["desde"];
  $fin = $_POST["hasta"];
}

$movilId="";

if (isset($_GET['MovilId']))
{
    $movilId=$_GET['MovilId'];
}

if (isset($_POST['MovilId']))
{
    $movilId=$_POST['MovilId'];
}

foreach($todosLosMoviles as $row)
{
    if($row["Id"]==$movilId)
    {
        $plate=$row["Matricula"];
    }
}


print_r($_POST);

$consulta="Select * from `recaudaciones` where MovilId in (".$movilId.") and HoraEntrada>='".$inicio."' and HoraEntrada<='".$fin."' and Kilometros>0 order by HoraEntrada desc";
$Recaudaciones=ejecutarConsulta($consulta);

$consulta="Select * from chofer order by Nombre ASC;";
$todosLosChoferes=ejecutarConsulta($consulta);

?>
<style>
    td
    {
        font-size:75%;
        border: black 1px solid;
    }
    th
    {
        font-size:60%;
        border: black 1px solid;
    }
</style>
<div class="container text-center abs-center">
    <br>
  <form action="MobilesRecaudaciones.php" method="post">
    Movil :
    <select name="MovilId" id="MovilId">
            <?php
            //echo '<option value="'.$chofer[0]['RUT'].'">'.$chofer[0]['RUT'].'</option>';
            echo "<option value='".$movilId."'>".$plate."</option>";
            
            foreach($todosLosMoviles as $row)
            {
                echo "<option value='".$row['Id']."'>".$row['Matricula']."</option>";
            }
            ?>
    </select>
    &nbsp;&nbsp; Desde : 
    <input type='date' id='desde' name="desde" value='<?php echo $inicio;?>'>
    &nbsp;&nbsp; Hasta: 
    <input type='date' id='hasta' name="hasta" value='<?php echo $fin;?>'>&nbsp;&nbsp;&nbsp;
    <button type="sumit" class="btn btn-primary">Buscar</button>
</form>
</div>
<br>      
<br>      


<table class="table table-striped">
        <thead class="thead-dark">
            <th>Fecha</th>
            <th>Chofer</th>
            <th>Recaudado</th>
            <th>Salario</th>
            <th>Laudo Cobrado</th>
            <th>Laudo No Cobrado</th>
            <th>Comisión</th>
            <th>Viático Cobrado</th>
            <th>Viático No Cobrado</th>
            <th>Feriado No Cobrado</th>
            <th>Feriado Cobrado</th>
            <th>Ap. Sueldo</th>
            <th>Ap. Viático</th>
            <th>Ap. Total</th>
            <th>H13 Patronal</th>
            <th>R12 Celeritas</th>
            <th>Merc. Celeritas</th>
            <th>Desc. M.P. Cel.</th>
            <th>H13 Especial </th>
            <th>Merc. Pago</th>
            <th>Desc. M.P. Pat.</th>
            <th>Oca Cel</th>
            <th>Desc. O.C.</th>
            <th>Bits</th>
            <th>Desc. Bits</th>
            <th>Pagos Pos</th>
            <th>Desc. Pos</th>
            <th>Pagos Transfer.</th>
            <th>Cabify Tarjeta</th>
            <th>Desc. Cabify Ef.</th>
            <th>Uber Tarj.</th>
            <th>Desc. Uber Ef.</th>
            <th>Elect. Crédito</th>
            <th>Elect. Contado</th>
            <th>KW/H</th>
            <th>Comb. Crédito</th>
            <th>Bonificación</th>
            <th>Comb. Contado</th>
            <th>Litros</th>
            <th>Aceite Crédito</th>
            <th>Aceite Contado</th>
            <th>Lavado</th>
            <th>Gomería</th>
            <th>Recarga Cabify</th>
            <th>Otros</th>
            <th>Hora de Carga</th>
            <th>Peajes Pagos</th>
            <th>Peajes a Pagar</th>
            <th>$ Efectivo</th>
            <th>Especificaciones</th>





            
        </thead>
        <tbody>
            <?php
                foreach($Recaudaciones as $row)
                {
                    echo '<tr>';
                    echo '<td>';
                    //echo $row['HoraEntrada'];
                    $porciones = explode(" ", $row['HoraEntrada']);
                    $porciones[0] = date("d/m/Y", strtotime($porciones[0]));                    
                    $porciones[0] = str_replace("-", "/", $porciones[0]);
                    echo $porciones[0]."";
                    echo '</td>';
                    echo '<td>';
                    echo $choferes[$row['Chofer']]["Nombre"];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Recaudado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Salario'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Laudo'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['LaudoNoCobrado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Comision'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['ViaticoNoCobrado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['ViaticoCobrado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['FeriadoNoCobrado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['FeriadoCobrado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['AporteSalario'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['AporteViatico'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['AporteTotales'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['H13Patronal'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['R12Celeritas'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['MerPagoCeleritas'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['H13Especiales'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['MercPago'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['OcaCel'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['Bits'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['Tarjetas'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['MercPagoPersonal'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['CabifyTarjetas'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['GasOilCred'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['GasOilPlata'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['GasOilLitros'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['AceiteCred'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['AceiteCont'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Lavado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Gomeria'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Cabify'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Otros'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['HoraDeCarga'];
                    echo '</td>';
                    echo '<td>';
                    echo '0';
                    echo '</td>';
                    echo '<td>';
                    echo $row['Peajes'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Efectivo'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Observaciones'];
                    echo '</td>';
                    echo '</tr>';                    
                }
            ?>
        </tbody>
    </table>