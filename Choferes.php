<?php
include 'index.php';

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

if (isset($_GET['Id'])){
    $id=$_GET['Id'];
    //print_r($todosLosChoferes[$id]);
    $sql="SELECT * FROM chofer WHERE ID='$id'";
    $todosLosChoferes=ejecutarConsulta($sql);
    $id=0;

?>
<div class="container text-center abs-center">
  <h1><?php echo $todosLosChoferes[$id]["Nombre"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;</h1>
  <hr>

<b>C.I: </b> <?php echo $todosLosChoferes[$id]["ci"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Nombre: </b> <?php echo $todosLosChoferes[$id]["Nombre"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Patronal: </b> <?php echo $todosLosChoferes[$id]["patronal"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Celeritas: </b> <?php echo $todosLosChoferes[$id]["celeritas"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><b>Dirección: </b> <?php echo $todosLosChoferes[$id]["direccion"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Contacto: </b> <?php echo $todosLosChoferes[$id]["contacto"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Contacto2: </b> <?php echo $todosLosChoferes[$id]["contacto2"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Multas: </b> <?php echo $todosLosChoferes[$id]["multas"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Sueldo: </b> <?php echo $todosLosChoferes[$id]["Sueldo"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Aporte: </b> <?php echo $todosLosChoferes[$id]["tipoAporte"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Retención: </b> <?php echo $todosLosChoferes[$id]["Retención"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Horas extra: </b> <?php echo $todosLosChoferes[$id]["HsExtra"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Fecha de Nacimiento </b> <?php echo $todosLosChoferes[$id]["FechaNacimiento"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Fecha de Ingreso: </b> <?php echo $todosLosChoferes[$id]["FechaDeIngreso"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>RUT: </b> <?php echo $todosLosChoferes[$id]["RUT"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


</div>

<?php
//ReciboSueldo.php?RSID=6&CHID=11  
$id=$todosLosChoferes[$id]['id'];
$consulta="SELECT * FROM `planilladetrabajo` WHERE `ChoferID`='$id';";
$planillaDeTrabajo=ejecutarConsulta($consulta);

$recibosDeSueldo=[];
$aguinaldos=[];
$salarioVacacionalyLicencia=[];
foreach($planillaDeTrabajo as $row)
{
    if(str_contains($row['Concepto'], "Recibo Sueldo"))
    {
        $recibosDeSueldo[]=$row;
    }else
    {
        if(str_contains($row['Concepto'], "Aguinaldo"))
        {
            $aguinaldos[]=$row;
        }else
        {
            if(str_contains($row['Concepto'], "Salario Vacacional y licencia"))
            {
                $salarioVacacionalyLicencia[]=$row;
            }

        }

    }

}

?>

<div class="container text-center abs-center">
    <h2>Recibos de Sueldo</h2>
<table width="100%"> 
<tr>
        <td><b>Fecha</td><td><b>Concepto</td><td><b>Total Bruto</td><td><b>Total Recibido</td>
</tr>

    <?php
    foreach($recibosDeSueldo as $row)
    {
        echo "<tr>";
        $temp=explode("-",$row['Fecha']);
        echo "<td>";
        echo $meces[$temp[1]] .  " - "  . $temp[0];
        echo "</td>";
        echo "<td>";
        echo $row['Concepto'];
        echo "</td>";
        echo "<td>";
        echo $row['TotalBruto'];
        echo "</td>";
        echo "<td>";
        echo $row['TotalRecibido'];
        echo "</td>";
        echo "<td>";
        echo '<a href="ReciboSueldo.php?RSID=',$row['Id'],'&CHID=',$row['ChoferID'],'&Fecha=',$row['Fecha'],'">';
        echo "VER&#128269;";
        echo '</a>';
        echo "</td>";
        echo "</tr>";

    }
    
    ?>
</table>
</div>

<div class="container text-center abs-center">
    <h2>Aguinaldo</h2>
<table width="100%"> 
<tr>
        <td><b>Fecha</td><td><b>Concepto</td><td><b>Jornales</td><td><b>Total Bruto</td><td><b>Total Recibido</td>
</tr>
<tr>
    <?php
    foreach($aguinaldos as $row)
    {
        $temp=explode("-",$row['Fecha']);
        echo "<td>";
        echo $meces[$temp[1]] .  " - "  . $temp[0];
        echo "</td>";
        echo "<td>";
        echo $row['Concepto'];
        echo "</td>";
        echo "<td>";
        echo $row['	Comunes_Jornales'];
        echo "</td>";
        echo "<td>";
        echo $row['TotalBruto'];
        echo "</td>";
        echo "<td>";
        echo $row['TotalRecibido'];
        echo "</td>";
        echo "<td>";
        echo '<a href="ReciboSueldo.php?RSID=',$row['Id'],'&CHID=',$row['ChoferID'],'">';
        echo "VER&#128269;";
        echo '</a>';
        echo "</td>";

    }
    
    ?>
</tr>
</table>
</div>


<div class="container text-center abs-center">
    <h2>Salario Vacacional y Licencia</h2>
<table width="100%"> 
<tr>
        <td><b>Fecha</td><td><b>Concepto</td><td><b>Jornales</td><td><b>Total Bruto</td><td><b>Total Recibido</td>
</tr>
<tr>
    <?php
    foreach($aguinaldos as $row)
    {
        $temp=explode("-",$row['Fecha']);
        echo "<td>";
        echo $meces[$temp[1]] .  " - "  . $temp[0];
        echo "</td>";
        echo "<td>";
        echo $row['Concepto'];
        echo "</td>";
        echo "<td>";
        echo $row['	Comunes_Jornales'];
        echo "</td>";
        echo "<td>";
        echo $row['TotalBruto'];
        echo "</td>";
        echo "<td>";
        echo $row['TotalRecibido'];
        echo "</td>";
        echo "<td>";
        echo '<a href="ReciboSueldo.php?RSID=',$row['Id'],'&CHID=',$row['ChoferID'],'">';
        echo "VER&#128269;";
        echo '</a>';
        echo "</td>";

    }
    
    ?>
</tr>
</table>
</div>

<?php
}
else
{
    echo "error";
}
?>