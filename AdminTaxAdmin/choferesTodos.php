
<?php include('index.php');

//print_r($_POST);
if (isset($_POST['Nombre']))
{
    if(@$_POST['HsExtra']=="on")
        $hsExtra="true";
    else
        $hsExtra="false";


    $consulta="UPDATE `chofer` SET 
    `ci`='".$_POST['CI']."', 
    `Nombre`='".$_POST['Nombre']."', 
    `patronal`='".$_POST['Patronal']."', 
    `celeritas`='".$_POST['Celeritas']."', 
    `direccion`='".$_POST['Direccion']."', 
    `contacto`='".$_POST['contacto']."', 
    `contacto2`='".$_POST['contacto2']."', 
    `Sueldo`='".$_POST['Sueldo']."', 
    `tipoAporte`='".$_POST['tipoAporte']."', 
    `Retención`='".$_POST['Retencion']."', 
    `HsExtra`='".$hsExtra."', 
    `FechaNacimiento`='".$_POST['FechaNacimiento']."', 
    `FechaDeIngreso`='".$_POST['FechaDeIngreso']."', 
    `RUT`='".$_POST['empresa']."', 
    `NombreEnPlanilla`='".$_POST['NombreEnPlanilla']."' WHERE 
    `id`='".$_POST['id']."';";
    //echo $consulta;
    Insert($consulta);
    //header('location:choferesTodos.php');    
}







$consulta="Select * from chofer order by Nombre ASC;";
$todosLosChoferes=ejecutarConsulta($consulta);
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
            <th>Nombre</th>
            <!--<th>Empresa</th>-->
            <th>Opci&oacute;n</th>
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
                    echo '</td>';/*
                    echo '<td>';
                    echo $chofer['RUT'];
                    echo '</td>';*/
                    echo '<td>
                    <a href="choferesEditar.php?chofer='.$chofer['id'].'">
                    <img src="img/lapiz.png" title="Editar" width="20" height="20"></a>&nbsp;
                    
                    <a href="choferesDocumentos.php?chofer='.$chofer['id'].'">
                    <img src="img/doc.jpg" title="Documentos" width="30" height="30"></a>&nbsp;
                    
                    <a href="choferesRecibos.php?chofer='.$chofer['id'].'">
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