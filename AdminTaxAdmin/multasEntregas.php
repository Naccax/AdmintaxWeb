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

    $consulta="SELECT SUM(`monto`) from multasentregas WHERE multa=".$_POST["multa"];
    $sumaDeEntregas=ejecutarConsulta($consulta);
    $entregado=$sumaDeEntregas[0][0];
    //echo "Entregado: ". $entregado . "<br>";
    
    $consulta="SELECT monto FROM multas WHERE id = ".$_POST["multa"];
    $temp=ejecutarConsulta($consulta);
    $monto=$temp[0][0];
    echo "Monto: ". $monto . "<br>";

if(isset($_POST["Guardar_Entrega"]))
{
    $consulta="INSERT INTO `multasentregas`
    (`chofer`, `Movil`, `multa`, `fecha`, `monto`) VALUES ";
    $values="'".$_POST["chofer"]."','".$_POST["movil"]."','".$_POST["multa"]."','".$_POST["Fecha"]."','".$_POST["Monto"]."'";
    $values="(".$values.")";
    $consulta=$consulta.$values;
    insert($consulta);

    $consulta="SELECT SUM(`monto`) from multasentregas WHERE multa=".$_POST["multa"];
    $sumaDeEntregas=ejecutarConsulta($consulta);
    $entregado=$sumaDeEntregas[0][0];
    echo "Entregado: ". $entregado . "<br>";

    $monto=$monto-$entregado;
    
    $consulta="UPDATE multas SET multas.Entregado=".$entregado.", multas.saldo=".$monto." WHERE multas.id=".$_POST["multa"];
    //echo $consulta;
    insert($consulta);

    echo "<br>"."Saldo Pendiente: " . $monto . "<br>";

    $consulta="UPDATE multas SET multas.Estado='Paga' WHERE `saldo` <= 0 and `id`=".$_POST["multa"];
    //$consulta="UPDATE `multas` SET `Estado` = 'Activa' WHERE `multas`.`id` = 53;";
    //echo $consulta;
    insert($consulta);
}
if(isset($_POST["Eliminar"]))
{
    $consulta="DELETE FROM `multasentregas` where id=".$_POST["doc"];
    insert($consulta);

    $consulta="SELECT SUM(`monto`) from multasentregas WHERE multa=".$_POST["multa"];
    $sumaDeEntregas=ejecutarConsulta($consulta);
    $entregado=$sumaDeEntregas[0][0];
    
    if ($entregado=="")
        $entregado=0;

    $monto=$monto-$entregado;

    $consulta="UPDATE multas SET multas.Entregado=".$entregado.",multas.saldo=".$monto." WHERE multas.id=".$_POST["multa"];
    echo "<br>".$consulta."<br>";
    insert($consulta);

    
    $consulta="UPDATE multas SET multas.Estado='Activa' WHERE multas.saldo<multas.monto and multas.id=".$_POST["multa"];
    insert($consulta);
}



$consulta="SELECT `fecha`,`monto`,`id` FROM `multasentregas` WHERE multa=".$_POST["multa"]."  ORDER BY `multasentregas`.`fecha` DESC";
$todosLosChoferes=ejecutarConsulta($consulta);


function btnEliminar($doc)
{
    $antes='
    
    <form action="#" method="POST">
    <input type="text" name="multa" value="'.$_POST["multa"].'" hidden>
    <input type="text" name="saldo" value="'.$_POST["saldo"] .'" hidden>
    <input type="text" name="chofer" value="'.$_POST["chofer"] .'" hidden>
    <input type="text" name="movil" value="'.$_POST["movil"] .'" hidden>
    <input type="text" name="MovilId" value="'.$_POST["MovilId"] .'" hidden>';
  $respuesta = "
  <input type='hidden' name='doc' value='".$doc."'>
  <input type='submit' name='Eliminar' value='Eliminar' title='Eliminar' onclick='return confirmacion()' class='btn btn-danger'>
  </form>
  ";
  $respuesta=$antes.$respuesta;
  return $respuesta;
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
    
<form action="entregaGuardar.php" method="post">
    <input type="text" name="multa" value="<?php echo $_POST["multa"] ?>" hidden>
    <input type="text" name="saldo" value="<?php echo $_POST["saldo"] ?>" hidden>

    <input type="text" name="chofer" value="<?php echo $_POST["chofer"] ?>" hidden>
    <input type="text" name="movil" value="<?php echo $_POST["movil"] ?>" hidden>
    <input type="text" name="MovilId" value="<?php echo $_POST["MovilId"] ?>" hidden>

    <input type="submit" name="Agregar Nuevo" value="Agregar Nuevo" tytle="Agregar Nuevo" class="btn btn-primary">
</form>

    <table id="tablax" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <th>Fecha</th>
            <th>Id</th>
            <th>Monto</th>
            <th>Eliminar</th>
        </thead>
        <tbody>
            <?php
                foreach($todosLosChoferes as $chofer)
                {
                    echo '<tr>';
                    echo '<td>';
                    echo $chofer['fecha'];
                    echo '</td>';
                    echo '<td>';
                    echo $chofer['id'];
                    echo '</td>';
                    echo '<td>';
                    echo $chofer['monto'];
                    echo '</td>';
                    echo '<td>';
                    echo btnEliminar($chofer['id']);    
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