
<?php 
include('index.php'); 

print_r($_POST);


$consulta="SELECT * FROM movil";//moviles
$movilestemp = ejecutarConsulta($consulta);

function actualizarChoferes()
{
    $consulta="SELECT COUNT(multas.id) AS cant, multas.chofer as chofer FROM multas WHERE multas.Estado='Activa' GROUP BY multas.chofer;";
    $choferesMultados=ejecutarConsulta($consulta);
    foreach($choferesMultados as $row)
    {
        $consulta="update chofer set multas=".$row["cant"]." where id=".$row["chofer"].";";
        Insert($consulta);
    }    
}
function actualizarMoviles()
{
    $consulta="SELECT COUNT(multas.id) AS cant, multas.movil as movil, multas.MovilId FROM multas WHERE multas.Estado='Activa' GROUP BY multas.MovilId;";
    $choferesMultados=ejecutarConsulta($consulta);
    foreach($choferesMultados as $row)
    {
        $consulta="update movil set Multas=".$row["cant"]." where id=".$row["MovilId"].";";
        Insert($consulta);
    }    
}

if(isset($_POST["Actualizar_Cálculos"]))
{
    actualizarChoferes();
    actualizarMoviles();
}

$moviles=[];
foreach($movilestemp as $row)
{
    $moviles[$row["Id"]]=$row["Matricula"];
}


if(isset($_POST["Guardar"]))
{
    $consulta="INSERT INTO `multas`( 
    `chofer`, 
    `movil`, 
    `Motivo`, 
    `detalle`, 
    `Estado`, 
    `fecha`, 
    `monto`, 
    `MontoEnUR`, 
    `saldo`, 
    `Entregado`, 
    `MovilId`) VALUES ";
    $values="
    '".$_POST["choferId"]."',
    '".$moviles[$_POST["movilId"]]."',
    '".$_POST["motivo"]."',
    '".$_POST["Detalle"]."',
    '".$_POST["Estado"]."',
    '".$_POST["Fecha"]."',
    '".$_POST["monto"]."',
    '".$_POST["montoUr"]."',
    '".$_POST["monto"]."',
    '0',
    '".$_POST["movilId"]."'";
    $values="(".$values.")";
    $consulta=$consulta.$values;
    //echo $consulta;
    Insert($consulta);
    $_POST = array();
}

if(isset($_POST["Guardar_Cambios"]))
{
    $temp=$_POST["monto"]-$_POST["Entregado"];
    $consulta="
    UPDATE `multas` SET 
    `chofer`='".$_POST["choferId"]."',
    `movil`='".$moviles[$_POST["movilId"]]."',
    `Motivo`='".$_POST["motivo"]."',
    `detalle`='".$_POST["Detalle"]."',
    `Estado`='".$_POST["Estado"]."',
    `fecha`='".$_POST["Fecha"]."',
    `monto`='".$_POST["monto"]."',
    `MontoEnUR`='".$_POST["montoUr"]."',
    `saldo`='".$temp."',
    `Entregado`='".$_POST["Entregado"]."',
    `MovilId`='".$_POST["movilId"]."' 
    WHERE `id`=".$_POST["Id"].";
    ";
    Insert($consulta);
    $_POST = array();
}


$porciones = explode("-", $_POST['Fecha']);

$L = new DateTime( $_POST['Fecha'] ); 
$desde=$L->format( 'Y-m-1' );
$hasta=$L->format( 'Y-m-t' );

$consulta="SELECT * FROM `planilladetrabajo` where Concepto='Recibo Sueldo' and Fecha>='".$desde." 00:00:00' and Fecha<='".$hasta." 23:59:59' and EmpresaID='".$_POST['empresa']."' order by Id desc";
$planillaDeTrabajo=ejecutarConsulta($consulta);

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
            <th>Chofer</th>
            <th>Jornales</th>
            <th>HS Extra</th>
            <th>Com. Particip.</th>
            <th>Feriados</th>
            <th>Descuentos</th>
            <th>Total Recibido</th>
            <th>Total Bruto</th>
           
        </thead>
        <tbody>
            <?php
                foreach($planillaDeTrabajo as $row)
                {
                    echo '<tr>';
                    echo '<td>';
                    @$temp=$choferes[$row['ChoferID']]["Nombre"];
                    $a='recibo.php?rsid='.$row['Id'];
                    echo '<a href="'.$a.'">'.$temp."</a>";
                    # deje aca
                    echo '</td>';
                    echo '<td>';
                    echo $row['Comunes_Jornales'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Comunes_HsExtra'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['participacion_monto'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['FeriadosNoLaborables_Monto'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Descuentos'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['TotalRecibido'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['TotalBruto'];
                    echo '</td>';
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
</body>
</html>