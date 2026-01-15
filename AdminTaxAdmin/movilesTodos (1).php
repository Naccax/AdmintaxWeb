
<?php 
include('index.php'); 

if (isset($_POST['id']))
{
    $consulta="INSERT INTO `movil`(`Matricula`, `Patronal`, `Celeritas`, `Multas`, `NumEmpresa`, `NumPos`, `NumRut`, `Padron`, `Combustible`) VALUES";
    $values="('".$_POST['Matricula']."','".$_POST['Patronal']."','".$_POST['Celeritas']."','0','".$_POST['NumEmpresa']."','".$_POST['NumPos']."','".$_POST['NumRut']."','".$_POST['Padron']."','".$_POST['Combustible']."')";
    $consulta=$consulta.$values;
    if($_POST['id']=="")
      Insert($consulta);
    else
    {
        $consulta="UPDATE `movil` SET `Matricula`='".$_POST['Matricula']."', `Patronal`='".$_POST['Patronal']."', `Celeritas`='".$_POST['Celeritas']."', `NumEmpresa`='".$_POST['NumEmpresa']."', `NumPos`='".$_POST['NumPos']."', `NumRut`='".$_POST['NumRut']."', `Padron`='".$_POST['Padron']."', `Combustible`='".$_POST['Combustible']."' WHERE Id='".$_POST['Id']."';";
        Insert($consulta);
    }
    $salir="si";
}

$consulta="SELECT movil.Id as Id, movil.Matricula as Matricula, movil.NumRut as NumRut, max(recaudaciones.KmSalida) as Kilometros FROM `recaudaciones`,movil WHERE movil.Id=recaudaciones.MovilId GROUP by movil.Id;";
$todosLosMoviles=ejecutarConsulta($consulta);
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
            <th>Nombre</th>
            <th>Empresa</th>
            <th>Kil&oacute;metros</th>
            <th>Opci&oacute;n</th>
        </thead>
        <tbody>
            <?php
                foreach($todosLosMoviles as $row)
                {
                    echo '<tr>';
                    echo '<td>';
                    echo $row['Matricula'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['NumRut'];
                    echo '</td>';
                    echo '<td>';
                    echo $row['Kilometros'];
                    echo '</td>';
                    echo '<td>
                    <a href="movilesNuevo.php?movil='.$row['Id'].'">
                    <img src="img/lapiz.png" title="Editar" width="20" height="20"></a>&nbsp;
                    
                    <a href="#?chofer='.$row['Id'].'">
                    <img src="img/multas.png" title="Multas" width="30" height="30"></a>&nbsp;
                    
                    <a href="#?chofer='.$row['Id'].'">
                    <img src="img/rec.png" title="Recibos" width="30" height="30"></a>
                    </td>';
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