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

$consulta="SELECT * FROM empresa";
$empresas = ejecutarConsulta($consulta);
if(isset($_POST['retoactivo']))
{
    $sql="DELETE FROM `retroactivos` WHERE `Id`=".$_POST['retoactivo'];
    Insert($sql);
}

$consulta="SELECT * FROM `retroactivos` WHERE `retroactivos`.`Detalle`='Viático' ORDER BY `retroactivos`.`Fecha` ASC";
$retroactivos=ejecutarConsulta($consulta);


$consulta="SELECT `chofer`.id,`chofer`.Nombre,TRUNCATE(sum(RetencionDeRetroactividad),2) as RetencionDeRetroactividad,TRUNCATE(sum(DiferenciaDeViaticoNeta),2) as DiferenciaDeViaticoNeta,TRUNCATE(sum(ViaticoNoCobrado),2) as ViaticoNoCobrado,TRUNCATE(sum(ViaticoCorrespondiente),2) as ViaticoCorrespondiente, TRUNCATE(sum(DiferenciaDeViatico),2) as DiferenciaDeViatico, count(Nombre) as Cantidad,`chofer`.RUT FROM `recaudaciones`,`chofer` where `recaudaciones`.`Chofer`=`chofer`.`id` and `recaudaciones`.`ViaticoNoCobrado`!='0' and `recaudaciones`.`HoraEntrada`>='".$retroactivos[0]['Fecha']."' GROUP BY `recaudaciones`.`Chofer` DESC";
if(isset($_POST['Filtrar']))
{
    $consulta="SELECT `chofer`.id,`chofer`.RUT as Nombre,TRUNCATE(sum(RetencionDeRetroactividad),2) as RetencionDeRetroactividad,TRUNCATE(sum(DiferenciaDeViaticoNeta),2) as DiferenciaDeViaticoNeta,TRUNCATE(sum(ViaticoNoCobrado),2) as ViaticoNoCobrado,TRUNCATE(sum(ViaticoCorrespondiente),2) as ViaticoCorrespondiente, TRUNCATE(sum(DiferenciaDeViatico),2) as DiferenciaDeViatico, count(Nombre) as Cantidad,`chofer`.RUT FROM `recaudaciones`,`chofer` where `recaudaciones`.`Chofer`=`chofer`.`id` and `chofer`.`RUT`!='CHOFERES FUERA DE NOMINA' and `recaudaciones`.`ViaticoNoCobrado`!='0' and `recaudaciones`.`HoraEntrada`>='".$retroactivos[0]['Fecha']."' GROUP BY `chofer`.`RUT` DESC";
};
$todosLosChoferes=ejecutarConsulta($consulta);
/*
$consulta="SELECT * FROM `recaudaciones`,`chofer` where `recaudaciones`.`Chofer`=`chofer`.`id` and `recaudaciones`.`ViaticoNoCobrado`!='0' and `recaudaciones`.`HoraEntrada`>='".$retroactivos[0]['Fecha']."' ORDER BY `recaudaciones`.`HoraEntrada` DESC";
$todosLosChoferes=ejecutarConsulta($consulta);
*/


function btnEliminar($retoactivo)
{
  $respuesta = "
  <form action='#' method='POST'>
  <input type='hidden' name='retoactivo' value='" . $retoactivo . "'>
  <input type='image' name='eliminar' value='eliminar' src='img/del.png' align='right' title='Eliminar' width='30' height='30' onclick='return confirmacion()'>
  </form>
  ";
  return $respuesta;
}

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
    </style>
    
    <title>Paginacion</title>
</head>
<body>
    
    <div class="container" style="margin-top: 10px;padding: 5px">
    <table id="tablax" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <th>Id</th>
            <th>Chofer</th>
            <th>Diferencia Neta</th>
            <?php 
            if($masInfo)
            {
                echo'
            <th>Diferencia Bruta</th>
            <th>Retencion P.A.</th>
            <th>Cantidad</th>
            <th>Vi&aacute;tico Pagado</th>
            <th>Vi&aacute;tico Correspondiente</th>
            <th>Empresa</th>
                ';
            } ?>
        </thead>
        <tbody>
            <?php
                foreach($todosLosChoferes as $chofer)
                {
                    echo '<tr>';
                    echo '<td>';
                    echo $chofer['id'];
                    echo '</td>';
                    echo '<td>';
                    echo $chofer['Nombre'];
                    echo '</td>';
                    echo '<td>';
                    echo $chofer['DiferenciaDeViaticoNeta'];
                    echo '</td>';
                    if($masInfo){
                        echo '<td>';
                        echo $chofer['DiferenciaDeViatico'];
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['RetencionDeRetroactividad'];
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['Cantidad'];
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['ViaticoNoCobrado'];
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['ViaticoCorrespondiente'];
                        echo '</td>';
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['RUT'];
                        echo '</td>';
                    }
                    /*echo '<td>
                    <a href="retroactivosGuardar.php?retroactivo='.$chofer['id'].'">
                    <img src="img/lapiz.png" title="Editar" width="20" height="20"></a>&nbsp;
                    
                    <a href="choferesDocumentos.php?chofer='.$chofer['id'].'">
                    <img src="img/doc.jpg" title="Documentos" width="30" height="30"></a>&nbsp;
                    
                    <a href="choferesRecibos.php?chofer='.$chofer['id'].'">
                    <img src="img/rec.png" title="Recibos" width="30" height="30"></a>';
                    echo btnEliminar($chofer['id']);
                    echo '</td>';*/
                    echo '</tr>';

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
                scrollY: 455,
                lengthMenu: [ [10, 25, -1], [10, 25, "All"] ],
            });
        });
    </script>
    <div class="container" style="margin-top: 10px;padding: 5px">
    <table width='100%'><tr><td>

    <center>
    <form action='#' method='POST'>
    <input type='text' name='Filtro' value='si' hidden>
    <input type='submit' class="btn btn-primary" name='Filtrar' value='Filtrar por empresa' src='img/add.png' title='Filtrar por empresa' width='60' height='60' align="centre">
      </form>
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
      <input type='submit' class="btn btn-success" name='Mas Información' value='Mas Información' src='img/lupa.png' title='Mas Información' width='60' height='60' align="centre">
      </form>
      <form action='RetroactivosAplicar2.php' method='POST'>
      <input type='hidden' name='masInfo6' value='false'>
      <input type='submit' name='Choferes sin RUT' class="btn btn-secondary" value='Choferes sin RUT' src='img/chofer.jpg' title='Choferes sin RUT' width='60' height='60' align="centre">
      </form>
    </center>
    </td>
</tr></table>
    </div>
</body>
</html>