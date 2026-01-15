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


if(isset($_POST['Eliminar']))
{
    if($_POST['Eliminar']=="si")
    {
        $sql="SELECT Id FROM planilladetrabajo WHERE Fecha='".$_POST["fecha"]."' AND Concepto='Aguinaldo SR' AND ChoferID='".$_POST["ChoferID"]."' AND EmpresaID='".$_POST["EmpresaID"]."';";
        $recibo=ejecutarConsulta($sql);
        $rsid=$recibo[0][0];
        $sql="DELETE FROM planilladetrabajo where Id=".$rsid;    
        Insert($sql);
        $sql="DELETE FROM recibodetallerw where IdRs=".$rsid;    
        Insert($sql);
        $sql="DELETE FROM `aguinadoschoferessinrut` WHERE `Empresa`='".$_POST["EmpresaID"]."' and `Chofer`='".$_POST["ChoferID"]."' and `Periodo`='".$_POST["Periodo"]."';";
        Insert($sql);
    }
}



if(isset($_POST['AgModificado']))
{
    if($_POST['AgModificado']=="si")
    {
        $sql="UPDATE aguinadoschoferessinrut SET Salario='". $_POST['ag']. "' , Jornales='". $_POST['Jornales']. "', JornalProm='". $_POST['JorProm']. "' WHERE Id='". $_POST['id']. "';";
        Insert($sql);
    }
}

$consulta="Select * from planilladetrabajo,`periodosaguinaldo` where ChoferID='". $_GET['chofer']. "' 
and Concepto='Recibo Sueldo' 
and periodosaguinaldo.desde<=planilladetrabajo.Fecha 
and periodosaguinaldo.hasta>=planilladetrabajo.Fecha 
GROUP BY periodosaguinaldo.id  
ORDER BY `planilladetrabajo`.`Fecha` DESC";



$consulta="Select
empresa.Nombre as Empresa,
empresa.id as EmpresaID,
recaudaciones.Chofer as ChoferID,
periodosaguinaldo.id as AGID,
periodosaguinaldo.desde,
periodosaguinaldo.hasta,
round(SUM(recaudaciones.Salario)/12,2) as 'SueldoBaseParaAportacion',
COUNT(recaudaciones.id) as jornales,
round(SUM(recaudaciones.Salario),2) as salario,
round(SUM(recaudaciones.Salario)/COUNT(recaudaciones.id),2) as 'Jornal Prom.'
from recaudaciones,`periodosaguinaldo`,movil,empresa 
where recaudaciones.Chofer='". $_GET['chofer']. "' 
and periodosaguinaldo.desde<=recaudaciones.HoraEntrada 
and periodosaguinaldo.hasta>=recaudaciones.HoraEntrada 
and recaudaciones.Kilometros>0 
and recaudaciones.MovilId=movil.Id
and movil.NumRut=empresa.NumeroDeRUT
GROUP BY periodosaguinaldo.id,movil.NumRut;";
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
$consulta="SELECT * FROM aguinadoschoferessinrut WHERE Chofer='". $_GET['chofer']. "'";
$docs2=ejecutarConsulta($consulta);

$diferecias=[];
foreach($docs as $row)
{
    $existe=false;
    foreach($docs2 as $row2)
    {

        if($row["AGID"] == $row2["Periodo"])
        {
            $existe=true;
        }
    }
    if (!($existe)) 
    {
        $diferecias[]=$row;
    }
}

$ejecutar=false;
$values="INSERT INTO `aguinadoschoferessinrut`(`Empresa`, `Chofer`, `Periodo`, `Salario`, `Jornales`, `JornalProm`) VALUES ";
foreach($diferecias as $row)
{
    $values=$values."('".$row["EmpresaID"]."','".$row["ChoferID"]."','".$row["AGID"]."','".$row["SueldoBaseParaAportacion"]."','".$row["jornales"]."','".$row["Jornal Prom."]."')";
    $ejecutar=true;
}
$values=str_replace(")(","),(",$values);


if ($ejecutar)
    Insert($values);


$consulta="SELECT * FROM aguinadoschoferessinrut WHERE Chofer='". $_GET['chofer']. "'";
$docs2=ejecutarConsulta($consulta);

$consulta="SELECT 
empresa.Nombre as Empresa, 
empresa.id as EmpresaID, 
Chofer as ChoferID, 
aguinadoschoferessinrut.Periodo as AGID, 
periodosaguinaldo.desde, 
periodosaguinaldo.hasta, 
`Salario` as 'SueldoBaseParaAportacion',
`Jornales` as 'jornales',
`JornalProm` as 'Jornal Prom.'
FROM `aguinadoschoferessinrut`,Empresa,periodosaguinaldo
WHERE Empresa.id=aguinadoschoferessinrut.Empresa 
and periodosaguinaldo.id=aguinadoschoferessinrut.Periodo 
and Chofer='". $_GET['chofer']. "'
ORDER BY `Periodo` ASC;";

$consulta="SELECT *
FROM `aguinadoschoferessinrut`,periodosaguinaldo
WHERE periodosaguinaldo.id=aguinadoschoferessinrut.Periodo 
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
            <th>Aguinaldo</th>
            <?php if ($masInfo){echo '
            <th>Jornales</th>
            <th>jornal Prom.</th>
            <th>Fecha Desde</th>
            <th>Editar</th>
            <th>Eliminar</th>';
            //ReciboRetroactivosAplicar.php?chofer=
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
                    if($masInfo){
                        echo '<td>';
                        $jornales=$doc['Jornales'];
                        echo $jornales;
                        echo '</td>';
                        echo '<td>';
                        echo $doc['JornalProm'];
                        echo '</td>';
                        echo '<td>';
                        $porciones = explode(" ", $doc['desde']);
                        echo $porciones['0'];
                        echo '</td>';
                        echo '
                        <td>
                            <form action="aguinaldoSinRutModificar.php" method="post">
                                <input type="text" name="Id" Value="'.$doc['Id'].'" hidden>
                                <input type="text" name="Chofer" Value="'.$doc['Chofer'].'" hidden>
                                <input type="text" name="Empresa" Value="'.$empresas[$doc['Empresa']]['Nombre'].'" hidden>
                                <input type="text" name="Desde" Value="'.$doc['desde'].'" hidden>
                                <input type="text" name="Hasta" Value="'.$doc['hasta'].'" hidden>
                                <input type="text" name="ag" Value="'.$doc['Salario'].'" hidden>
                                <input type="text" name="Jornales" Value="'.$doc['Jornales'].'" hidden>
                                <input type="text" name="JorProm" Value="'.$doc['JornalProm'].'" hidden>
                                <input type="Submit" Value="Editar" class="btn btn-success">
                            </form>
                        </td>
                        ';

                        $porciones = explode(" ", $doc['hasta']);
                        $recibosDeAguinaldos[$i]['Fecha']=$porciones['0']." 23:59:59";
                        $recibosDeAguinaldos[$i]['Concepto']="Aguinaldo SR";
                        

                        echo '
                        <td>
                            <form action="#recibo_aguinaldo_pdf_sinrut.php" method="post">
                                <input type="text" name="ChoferID" Value="'.$doc['Chofer'].'" hidden>
                                <input type="text" name="Periodo" Value="'.$doc['id'].'" hidden>
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
                    $recibosDeAguinaldos[$i]['Fecha']=$porciones['0']." 23:59:59";
                    $recibosDeAguinaldos[$i]['Concepto']="Aguinaldo SR";
                    echo '</td>';

                    echo '
                    <td>
                        <form action="recibo_aguinaldo_pdf_sinrut.php" method="post">
                            <input type="text" name="ChoferID" Value="'.$doc['Chofer'].'" hidden>
                            <input type="text" name="fecha" Value="'.$recibosDeAguinaldos[$i]['Fecha'].'" hidden>
                            <input type="text" name="EmpresaID" Value="'.$doc['Empresa'].'" hidden>
                            <input type="text" name="TotalBruto" Value="'.$recibosDeAguinaldos[$i]['TotalBruto'].'" hidden>
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
$sql = "Select * from planilladetrabajo where Concepto='Aguinaldo SR' and ChoferID=".$recibosDeAguinaldos[0]['ChoferID'];
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
