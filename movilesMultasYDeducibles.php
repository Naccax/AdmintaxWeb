
<?php 
include('index.php'); 

//print_r($_POST);


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

$consulta="SELECT movil.Id as Id, movil.Matricula as Matricula, movil.NumRut as NumRut, max(recaudaciones.KmSalida) as Kilometros FROM `recaudaciones`,movil WHERE movil.Id=recaudaciones.MovilId GROUP by movil.Id;";
$consulta="SELECT * FROM multas,chofer where Estado!='Paga' and chofer.id=multas.chofer";

if (isset($_POST["Mostrar_Todos"]))
    $consulta="SELECT * FROM multas,chofer,movil where chofer.id=multas.chofer and movil.Id=multas.MovilId and movil.NumRut='".$_SESSION['empresa']."'";
else
    $consulta="SELECT * FROM multas,chofer,movil where Estado!='Paga' and chofer.id=multas.chofer and movil.Id=multas.MovilId and movil.NumRut='".$_SESSION['empresa']."'";

$todosLosMoviles=ejecutarConsulta($consulta);

//print_r($_POST);

if (isset($_POST["Más_detalles"])) {
    $_SESSION["mas"] = !isset($_SESSION["mas"]) || true;
}

if (isset($_POST["Menos_detalles"])) {
    $_SESSION["mas"] = false;
}

if (isset($_POST["Habilitar_Editar"]))
{
    if(@$Habilitar_Editar)
        $Habilitar_Editar=false;
    else
        $Habilitar_Editar=true;
}
if (isset($_POST["Ver_Entregas"]))
{
    if(@$Ver_Entregas)
        $Ver_Entregas=false;
    else
        $Ver_Entregas=true;
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
    
<form action="#" method="POST">
<input type="submit" name="Mostrar Todos" value="Mostrar Todos" class="btn btn-danger" >
<?php 
            
            if(isset($_SESSION["mas"]) && $_SESSION["mas"]){ 
               echo '<input type="submit" name="Menos detalles" value="Menos detalles" class="btn btn-success" >';
            }else
            {
                echo '<input type="submit" name="Más detalles" value="Más detalles" class="btn btn-success" >';
            }
?>  
</form>

    <table id="tablax" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <th>Estado</th>
            <th>Chofer</th>
            <th>Movil</th>
            <th>Motivo</th>
            <th>Saldo</th>
            <?php 
            
            if(isset($_SESSION["mas"]) && $_SESSION["mas"]){ 
                echo "
                <th>Fecha</th>
                <th>Detalle</th>
                <th>Monto</th>
                <th>Entregado</th>";
            }; ?>
        </thead>
        <tbody>
            <?php
                foreach($todosLosMoviles as $row)
                {
                    echo '<tr>';
                    echo '<td>';
                    echo $row['Estado'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Nombre'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['movil'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Motivo'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['saldo'];
                    echo '</td>';
                    if(isset($_SESSION["mas"]) && $_SESSION["mas"])
                    {
                        echo '<td>';
                        echo $row['fecha'];
                        echo '</td>';
                        echo '<td>';
                        echo $row['detalle'];
                        echo '</td>';
                        echo '<td>';
                        echo $row['monto'];
                        echo '</td>';
                        echo '<td>';
                        echo $row['Entregado'];
                        echo '</td>';

                    }
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