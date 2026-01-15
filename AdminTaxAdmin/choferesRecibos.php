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

$sql="UPDATE planilladetrabajo set Salario29=`Recaudacion`*0.29;";
Insert($sql);

$consulta="Select * from planilladetrabajo where ChoferID='". $_GET['chofer']. "' and Concepto='Recibo Sueldo' ORDER BY `planilladetrabajo`.`Fecha` DESC";

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
            <th>Fecha</th>
            <!--<th>Empresa</th>-->
            <th>Recaudación</th>
            <th>Salario Bruto</th>
            <?php if ($masInfo){echo '
            <th>Salario 29</th>
            <th>Jornales</th>
            <th>Salario(Aportación)</th>
            <th>jornal Prom.</th>
            <th>Empresa</th>';
            //ReciboRetroactivosAplicar.php?chofer=
            }?>
        </thead>
        <tbody>
            <?php
                foreach($docs as $doc)
                {
                    echo '<tr>';
                    echo '<td>';
                    echo '<a href="recibo.php?rsid='.$doc['Id'].'">';
                    $porciones = explode(" ", $doc['Fecha']);
                    $porciones = explode("-", $porciones[0]);
                    echo $porciones[0]."/".$porciones[1];
                    echo '</a>';
                    echo '</td>';
                    echo '<td>';
                    echo $doc['Recaudacion'];
                    echo '</td>';
                    echo '<td>';
                    echo $doc['RemuneracionTotal'];
                    echo '</td>';
                    if($masInfo){
                        echo '<td>';
                        echo $doc['Salario29'];
                        echo '</td>';
                    echo '<td>';
                    $jornales=$doc['Comunes_Jornales']+$doc['FeriadosNoLaborables_Cant'];
                    echo $jornales;
                    echo '</td>';
                    echo '<td>';
                    echo $doc['SueldoBaseParaAportacion'];
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
                    echo '</tr>';}                 
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