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

if(isset($_POST['doc']))
{
  //print_r($_POST);
  $sql="Delete from documentos where Id=".$_POST['doc'];
  Insert($sql);

}

//obtener ultimo día trabajado
$sql="SELECT DATE(DATE_ADD(max(HoraEntrada), INTERVAL -1 MONTH)) as fecha FROM recaudaciones where chofer=". $_GET['chofer'];

//$fecha=ejecutarConsulta($sql);


$consulta="Select * 
from 
planilladetrabajo,`licencias`,chofer 
where 
ChoferID='". $_GET['chofer']. "' 
and Concepto='Recibo Sueldo' 
and planilladetrabajo.Fecha>licencias.desde 
and licencias.hasta>=planilladetrabajo.Fecha
and chofer.id=planilladetrabajo.ChoferID
and planilladetrabajo.Fecha>=chofer.FechaDeIngreso 
GROUP BY licencias.id  
ORDER BY `planilladetrabajo`.`Fecha` DESC";


$campos="
chofer.FechaDeIngreso as Ingreso,
`planilladetrabajo`.`Fecha` as Fecha,
`planilladetrabajo`.ChoferID,
Truncate(sum(`planilladetrabajo`.Id),2) as Id,
Truncate(sum(`planilladetrabajo`.SueldoBaseParaAportacion),2) as Recaudacion,
Truncate(sum(`planilladetrabajo`.RemuneracionTotal),2) as RemuneracionTotal,
Truncate(sum(`planilladetrabajo`.Comunes_Jornales),2) as Comunes_Jornales,
Truncate(sum(`planilladetrabajo`.FeriadosNoLaborables_Cant),2) as FeriadosNoLaborables_Cant,
Truncate(sum(`planilladetrabajo`.SueldoBaseParaAportacion),2) as SueldoBaseParaAportacion,
`planilladetrabajo`.EmpresaID as EmpresaID,
licencias.id as id,
licencias.desde as desde,
licencias.hasta as hasta
";
$consulta=str_replace("*", $campos, $consulta);

//echo $consulta;

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
            <th>Fecha Hasta</th>
            <!--<th>Empresa</th>-->
            <th>Vacacional(Aportación)</th>
            <?php if ($masInfo){echo '
            <th>Remuneración</th>
            <th>Jornales</th>
            <th>jornal Prom.</th>
            <th>Empresa</th>
            <th>Fecha Desde</th>';
            //ReciboRetroactivosAplicar.php?chofer=
            }?>
            <th>Recibos</th>

        </thead>
        <tbody>
            <?php
                $i=0;
                foreach($docs as $doc)
                {
                    $recibosDeAguinaldos[$i]['ChoferID']=$doc['ChoferID'];
                    echo '<tr>';
                    echo '<td>';
                    $porciones = explode(" ", $doc['hasta']);
                    echo $porciones['0'];
                    echo "</form>";
                    $recibosDeAguinaldos[$i]['Fecha']=$porciones['0']." 23:59:59";
                    $recibosDeAguinaldos[$i]['Concepto']="Vacacional";
                    echo '</td>';/*
                    echo '<td>';
                    echo '<a href="recibo.php?rsid='.$doc['Id'].'">';
                    $porciones = explode(" ", $doc['Fecha']);
                    $porciones = explode("-", $porciones[0]);
                    echo $porciones[0]."/".$porciones[1];
                    echo '</a>';
                    echo '</td>';*/
                    echo '<td>';
                    
                    $jornales=$doc['Comunes_Jornales']+$doc['FeriadosNoLaborables_Cant'];
                    $jornales=round(($jornales*0.0664),0);

                    echo round(($doc['SueldoBaseParaAportacion'])/$jornales,2);//TotalBruto
                    $recibosDeAguinaldos[$i]['TotalBruto']=round(($doc['SueldoBaseParaAportacion'])/$jornales,2);
                    echo '</td>';
                    if($masInfo){
                        echo '<td>';
                        echo $doc['Recaudacion'];
                        echo '</td>';
                        echo '<td>';
                        $jornales=$doc['Comunes_Jornales']+$doc['FeriadosNoLaborables_Cant'];
                        echo round(($jornales*0.0664),0);
                        echo '</td>';
                        echo '<td>';
                        if($jornales>0){
                            $prom=$doc['SueldoBaseParaAportacion']/$jornales;
                            $prom = round($prom,2);
                        }else
                        {
                            $prom=0;
                        }
                        echo $prom;
                        echo '</td>';
                        echo '<td>';
                        echo $empresas[$doc['EmpresaID']]['Nombre'];
                        echo '</td>';
                        echo '<td>';
                        $porciones = explode(" ", $doc['desde']);
                        echo $porciones['0'];
                        echo '</td>';
                    }
                    echo '
                    <td>
                        <form action="recibo_VacacionalyLicencia_pdf.php" method="post">
                            <input type="text" name="ChoferID" Value="'.$doc['ChoferID'].'" hidden>
                            <input type="text" name="fecha" Value="'.$recibosDeAguinaldos[$i]['Fecha'].'" hidden>
                            <input type="text" name="EmpresaID" Value="'.$doc['EmpresaID'].'" hidden>
                            <input type="text" name="TotalBruto" Value="'.$recibosDeAguinaldos[$i]['TotalBruto'].'" hidden>
                            <input type="Submit" Value="Recibo" class="btn btn-primary">
                        </form>
                    </td>
                    ';
                    echo '</tr>';
                    $recibosDeAguinaldos[$i]['EmpresaID']=$doc['EmpresaID'];
                    $i++;                 
                }
            ?>
        </tbody>
    </table>
</div>


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
</body>
</html>
<?php
//print_r($recibosDeAguinaldos);
$sql = "Select * from planilladetrabajo where Concepto='Vacacional' and ChoferID=".$recibosDeAguinaldos[0]['ChoferID'];
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
        $sql="UPDATE `planilladetrabajo` set TotalBruto='".$recibo['TotalBruto']."' where Concepto='".$recibo['Concepto']."' and ChoferID='".$recibo['ChoferID']."' and Fecha='".$recibo['Fecha']."' and EmpresaID='".$recibo['EmpresaID']."';";
    }
    //echo $sql;
    Insert($sql);
}
//print_r($recibosDeAguinaldos);
?>