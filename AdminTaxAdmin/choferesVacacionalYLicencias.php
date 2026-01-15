<script>
    function confirmacion() {
        var respuesta = confirm("¿Desea realmente borrar el registro?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }

    }
</script>

<?php include('index.php'); 


function btnEliminar($doc,$chofer)
{
  $respuesta = "
  <form action='#' method='POST'>
  <input type='hidden' name='doc' value='true'>
  <input type='image' name='eliminar' value='eliminar' src='img/del.png' align='right' title='Eliminar' width='30' height='30' onclick='return confirmacion()'>
  </form>
  ";
  return $respuesta;
}

if(isset($_POST['AgModificado']))
{
    if($_POST['AgModificado']=="si")
    {
        $sql="UPDATE liceniciachofersinrut SET Salario='". $_POST['ag']. "' , Jornales='". $_POST['Jornales']. "', JornalProm='". $_POST['JorProm']. "', JornalProm2='". $_POST['JorProm2']. "', Licencia='". $_POST['Licencia']. "', Gosada='". $_POST['Gosada']. "' WHERE Id='". $_POST['id']. "';";
        Insert($sql);
    }
}
if(isset($_POST['Eliminar']))
{
    if($_POST['Eliminar']=="si")
    {
        
        $sql="SELECT * FROM planilladetrabajo WHERE Fecha='".$_POST["fecha"]."' AND Concepto='Licencia SR' AND ChoferID='".$_POST["ChoferID"]."' AND EmpresaID='".$_POST["EmpresaID"]."';";
        $recibo=ejecutarConsulta($sql);

        $rsid=$recibo[0][0];
        $sql="DELETE FROM planilladetrabajo where Id=".$rsid;    
        Insert($sql);
        $sql="DELETE FROM recibodetallerw where IdRs=".$rsid;    
        Insert($sql);
        $sql="DELETE FROM `liceniciachofersinrut` WHERE `Empresa`='".$_POST["EmpresaID"]."' and `Chofer`='".$_POST["ChoferID"]."' and `Periodo`='".$_POST["Periodo"]."';";
        Insert($sql);
    }
}


$sql="SELECT DATE(DATE_ADD(max(HoraEntrada), INTERVAL -1 MONTH)), max(HoraEntrada) FROM recaudaciones where chofer=". $_GET['chofer'];
$fecha=ejecutarConsulta($sql);

$porciones = explode("-", $fecha[0][0]);
$fechaDesde=$porciones['0']."-".$porciones['1']."-"."1 00:00:00";
$porciones = explode("-", $fecha[0][1]);
$fechaHasta=$porciones['0']."-".$porciones['1']."-"."1 00:00:00";
//echo $fechaDesde . " -----> " .$fechaHasta;

$sql="SELECT sum(Salario), count(id) FROM recaudaciones 
where
HoraEntrada >= '".$fechaDesde."'
and  HoraEntrada < '".$fechaHasta."'
and Kilometros>0
and chofer=". $_GET['chofer'];
$respuesta=ejecutarConsulta($sql);

$jornalPromMesAnterior=$respuesta[0][0]/$respuesta[0][1];
$jornalPromMesAnterior=round($jornalPromMesAnterior,2);



$consulta="SELECT
empresa.Nombre as Empresa,
empresa.id as EmpresaID,
recaudaciones.Chofer as ChoferID,
licencias.Id as AGID,
licencias.desde,
licencias.hasta,
".$jornalPromMesAnterior." as JornalProm2,
round((COUNT(recaudaciones.id) * 0.0664 * ".$jornalPromMesAnterior."),2) as Licencia,
round((((sum(recaudaciones.Salario))/COUNT(recaudaciones.id))*(COUNT(recaudaciones.id)*0.0664)),2) as 'SueldoBaseParaAportacion',
round((sum(recaudaciones.Salario)),2) as salario,
round((COUNT(recaudaciones.id) * 0.0664),2) as jornales,
COUNT(recaudaciones.id) as jornalesComputados,
round(((sum(recaudaciones.Salario))/COUNT(recaudaciones.id)),2) as 'Jornal Prom.'
FROM recaudaciones,movil,empresa,licencias
WHERE recaudaciones.MovilId = movil.Id
and movil.NumRut=empresa.NumeroDeRUT
and recaudaciones.Kilometros>0
and recaudaciones.HoraEntrada>=licencias.desde
and recaudaciones.HoraEntrada<=licencias.hasta
and chofer='". $_GET['chofer']. "'
GROUP BY empresa.id,licencias.Id;";


$docs=ejecutarConsulta($consulta);


$consulta="SELECT Nombre FROM Chofer WHERE id=".$_GET['chofer'];
$nombre=ejecutarConsulta($consulta);


$masInfo=false;
if(isset($_POST['masInfo']))
{
    if($_POST['masInfo']=="true")
    {
        $masInfo=true;
    }else
    {
        $masInfo=false;
    }
}

$recibosDeAguinaldos=[];
$consulta="SELECT * FROM liceniciachofersinrut WHERE Chofer='". $_GET['chofer']. "'";
$docs2=ejecutarConsulta($consulta);

$diferecias=[];
foreach($docs as $row)
{
    $existe=false;
    foreach($docs2 as $row2)
    {
        //echo $row["AGID"] ." == ". $row2["Periodo"] . "<br>";

        if($row["AGID"] == $row2["Periodo"])
        {
            $existe=true;
            //echo "true";
        }
    }
    if (!($existe)) 
    {
        $diferecias[]=$row;
    }
}


$ejecutar=false;
$values="INSERT INTO `liceniciachofersinrut`(`Empresa`, `JornalesComputados`,`Chofer`, `Periodo`, `Salario`, `Jornales`, `JornalProm`, `JornalProm2`, `Licencia`) VALUES ";
foreach($diferecias as $row)
{
    //jornalesComputados
    $values=$values."('".$row["EmpresaID"]."','".$row["jornalesComputados"]."','".$row["ChoferID"]."','".$row["AGID"]."','".$row["SueldoBaseParaAportacion"]."','".$row["jornales"]."','".$row["Jornal Prom."]."','".$row["JornalProm2"]."','".$row["Licencia"]."')";
    $ejecutar=true;
}
$values=str_replace(")(","),(",$values);


if ($ejecutar)
    Insert($values);


$consulta="SELECT * FROM liceniciachofersinrut WHERE Chofer='". $_GET['chofer']. "'";
$docs2=ejecutarConsulta($consulta);

$consulta="SELECT 
empresa.Nombre as Empresa, 
empresa.id as EmpresaID, 
Chofer as ChoferID, 
liceniciachofersinrut.Periodo as AGID, 
licencias.desde, 
licencias.hasta, 
`Salario` as 'SueldoBaseParaAportacion',
`Jornales` as 'jornales',
`JornalProm` as 'Jornal Prom.',
`Gosada` as 'Gosada',
JornalesComputados AS jornalesComputados
FROM `liceniciachofersinrut`,Empresa,licencias
WHERE Empresa.id=liceniciachofersinrut.Empresa 
and licencias.id=liceniciachofersinrut.Periodo 
and Chofer='". $_GET['chofer']. "'
ORDER BY `Periodo` ASC;";

$consulta="SELECT *
FROM `liceniciachofersinrut`,licencias
WHERE licencias.Id=liceniciachofersinrut.Periodo 
and Chofer='". $_GET['chofer']. "'
ORDER BY `Periodo` ASC;";
$docs=ejecutarConsulta($consulta);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- DATATABLES -->
    <!--  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
        th,td {
            padding: 0.4rem !important;
        }
        body>div {
            box-shadow: 10px 10px 8px #888888;
            border: 2px solid black;
            border-radius: 10px;
        }
        .container .title{
        font-size: 25px;
        font-weight: 500;
        position: relative;
        }
        .container .title::before{
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 30px;
        border-radius: 5px;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }
    </style>
    <title>Paginacion</title>
</head>
<body>


<div class="container" style="margin-top: 10px;padding: 5px">
<div class="title"><?php echo $nombre[0][0]; ?></div>
</div>

<div class="container" style="margin-top: 10px;padding: 5px">
     <?php include('recibosMenu.php');?>
<hr>
    <table id="tablax" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <th>Empresa</th>
            <!--<th>Empresa</th>-->
            <th>Vacacional</th>
            <th>Licencia</th>
            <?php if ($masInfo){echo '
            <th>Días</th>
            <th>jornal Prom.</th>
            <th>jornal Comp.</th>
            <th>Gozada</th>
            <th>Fecha Desde</th>
            <th>Editar</th>
            <th>Eliminar</th>';
            //jornalesComputados
            }?>
            <th>Hasta</th>
            <th>Recibos</th>

        </thead>
        <tbody>
            <?php
                $i=0;
                foreach($docs as $doc)
                {
                    $recibosDeAguinaldos[$i]['ChoferID']=$doc['Chofer'];
                    echo '<tr>';
                    echo '<td>';
                    echo $empresas[$doc['Empresa']]['Nombre'];
                    echo '</td>';/*
                    echo '<td>';
                    echo '<a href="recibo.php?rsid='.$doc['Id'].'">';
                    $porciones = explode(" ", $doc['Fecha']);
                    $porciones = explode("-", $porciones[0]);
                    echo $porciones[0]."/".$porciones[1];
                    echo '</a>';
                    echo '</td>';*/
                    echo '<td>';
                    echo $doc['Salario'];
                    $recibosDeAguinaldos[$i]['TotalBruto']=round(($doc['Salario']),2);
                    echo '</td>';
                    echo '<td>';
                    echo $doc['Licencia'];
                    $recibosDeAguinaldos[$i]['Licencia']=round(($doc['Licencia']),2);
                    $recibosDeAguinaldos[$i]['Jornales']=round(($doc['Jornales']),2);
                    echo '</td>';
                    if($masInfo){
                        echo '<td>';
                        $jornales=$doc['Jornales'];
                        $recibosDeAguinaldos[$i]['Jornales']=round(($doc['Jornales']),2);
                        echo $jornales;
                        echo '</td>';
                        echo '<td>';
                        echo $doc['JornalProm'];//
                        echo '</td>';
                        echo '<td>';
                        echo $doc['JornalesComputados'];//
                        echo '</td>';
                        echo '<td>';
                        echo $doc['Gosada'];
                        echo '</td>';
                        echo '<td>';
                        $porciones = explode(" ", $doc['desde']);
                        echo $porciones['0'];
                        echo '</td>';echo '
                        <td>
                            <form action="aguinaldoSinRutModificar.php" method="post">
                                <input type="text" name="Id" Value="'.$doc['0'].'" hidden>
                                <input type="text" name="Chofer" Value="'.$doc['Chofer'].'" hidden>
                                <input type="text" name="Empresa" Value="'.$empresas[$doc['Empresa']]['Nombre'].'" hidden>
                                <input type="text" name="Desde" Value="'.$doc['desde'].'" hidden>
                                <input type="text" name="Hasta" Value="'.$doc['hasta'].'" hidden>
                                <input type="text" name="ag" Value="'.$doc['Salario'].'" hidden>
                                <input type="text" name="Jornales" Value="'.$doc['Jornales'].'" hidden>
                                <input type="text" name="JorProm" Value="'.$doc['JornalProm'].'" hidden>
                                <input type="text" name="JorProm2" Value="'.$doc['JornalProm2'].'" hidden>
                                <input type="text" name="Gosada" Value="'.$doc['Gosada'].'" hidden>
                                <input type="text" name="Licencia" Value="'.$doc['Licencia'].'" hidden>
                                <input type="text" name="Origen" Value="choferesVacacionalYLicencias.php" hidden>

                                <input type="Submit" Value="Editar" class="btn btn-success">
                            </form>
                        </td>
                        ';

                            
                        $porciones = explode(" ", $doc['hasta']);
                        $recibosDeAguinaldos[$i]['Fecha']=$porciones['0']." 23:59:59";
                        $recibosDeAguinaldos[$i]['Concepto']="Licencia SR";
                        
                        echo '
                        <td>
                            <form action="#recibo_aguinaldo_pdf_sinrut.php" method="post">
                                <input type="text" name="ChoferID" Value="'.$doc['Chofer'].'" hidden>
                                <input type="text" name="Periodo" Value="'.$doc[3].'" hidden>
                                <input type="text" name="fecha" Value="'.$recibosDeAguinaldos[$i]['Fecha'].'" hidden>
                                <input type="text" name="EmpresaID" Value="'.$doc['Empresa'].'" hidden>
                                <input type="text" name="TotalBruto" Value="'.$recibosDeAguinaldos[$i]['TotalBruto'].'" hidden>
                                <input type="text" name="Eliminar" Value="si" hidden>
                                <input type="Submit" Value="Eliminar" class="btn btn-danger" onclick="return confirmacion()">
                            </form>
                        </td>
                        ';
                    }
                    
                    echo '<td>';
                    $porciones = explode(" ", $doc['hasta']);
                    echo $porciones['0'];
                    echo "</form>";
                    $recibosDeAguinaldos[$i]['Fecha']=$porciones['0']." 23:59:59";
                    $recibosDeAguinaldos[$i]['Concepto']="Licencia SR";
                    echo '</td>';

                    echo '
                    <td>
                        <form action="recibo_VacacionalyLicencia_pdf_sinrut.php" method="post">
                            <input type="text" name="ChoferID" Value="'.$doc['Chofer'].'" hidden>
                            <input type="text" name="Gosada" Value="'.$doc['Gosada'].'" hidden>
                            <input type="text" name="fecha" Value="'.$recibosDeAguinaldos[$i]['Fecha'].'" hidden>
                            <input type="text" name="EmpresaID" Value="'.$doc['Empresa'].'" hidden>
                            <input type="text" name="TotalBruto" Value="'.$recibosDeAguinaldos[$i]['TotalBruto'].'" hidden>
                            <input type="text" name="Licencia" Value="'.$recibosDeAguinaldos[$i]['Licencia'].'" hidden>
                            <input type="text" name="Jornales" Value="'.$recibosDeAguinaldos[$i]['Jornales'].'" hidden>
                            <input type="Submit" Value="Recibo" class="btn btn-primary">
                        </form>
                    </td>
                    ';
                    echo '</tr>';
                    $recibosDeAguinaldos[$i]['EmpresaID']=$doc['Empresa'];
                    $i++;                 
                }
            ?>
        </tbody>
    </table>
</div>


<center>
      <form action='#' method='POST'>
      
      <?php 
      if ($masInfo) 
      {
        echo "<input type='hidden' name='masInfo' value='false'>";
      }
      else
      {
        echo "<input type='hidden' name='masInfo' value='true'>";
      } 
      ?>
      <input type='image' name='Mas Información' value='Mas Información' src='img/lupa.png' title='Mas Información' width='60' height='60' align="centre">
      </form>
</center>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
        </script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>
    <script>
        $(document).ready(function () {
            $('#tablax').DataTable({
                language: {
                    processing: "Tratamiento en curso...",
                    search: "Buscar&nbsp;:",
                    lengthMenu: "Agrupar de _MENU_ items",
                    info: "Mostrando del item _START_ al _END_ de un total de _TOTAL_ items",
                    infoEmpty: "No existen datos.",
                    infoFiltered: "(filtrado de _MAX_ elementos en total)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron datos con tu busqueda",
                    emptyTable: "No hay datos disponibles en la tabla.",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Ultimo"
                    },
                    aria: {
                        sortAscending: ": active para ordenar la columna en orden ascendente",
                        sortDescending: ": active para ordenar la columna en orden descendente"
                    }
                },
                scrollY: 300,
                lengthMenu: [ [10, 25, -1], [10, 25, "All"] ],
            });
        });
    </script>
</body>
</html>
<?php
//print_r($recibosDeAguinaldos);
$sql = "Select * from planilladetrabajo where Concepto='Licencia SR' and ChoferID=".$recibosDeAguinaldos[0]['ChoferID'];
$recivosExistentes=ejecutarConsulta($sql);
$i=0;
foreach($recibosDeAguinaldos as $nuevo)
{
    $recibosDeAguinaldos[$i]['Id']=0;
    foreach($recivosExistentes as $existente)
    {
        if(($existente['Fecha']==$nuevo['Fecha']) and ($existente['EmpresaID']==$nuevo['EmpresaID']))
        {
            $recibosDeAguinaldos[$i]['Id']=$existente['Id'];
        }
    }
    $i++;
}
foreach($recibosDeAguinaldos as $recibo)
{
    $sql="";
    if($recibo['Id']=="0")
    {
        $sql="INSERT INTO `planilladetrabajo` (Fecha,Concepto,EmpresaID,ChoferID,TotalBruto,SueldoBaseParaAportacion) VALUES ";
        $sql=$sql."('".$recibo['Fecha']."','".$recibo['Concepto']."','".$recibo['EmpresaID']."','".$recibo['ChoferID']."','".$recibo['TotalBruto']."','".$recibo['TotalBruto']."');";
    }
    else
    {
        $sql="UPDATE `planilladetrabajo` set TotalBruto='".$recibo['TotalBruto']+$recibo['Licencia']."' where Concepto='".$recibo['Concepto']."' and ChoferID='".$recibo['ChoferID']."' and Fecha='".$recibo['Fecha']."' and EmpresaID='".$recibo['EmpresaID']."';";
    }
    //echo $sql;
    Insert($sql);
}
//print_r($recibosDeAguinaldos);
?>
