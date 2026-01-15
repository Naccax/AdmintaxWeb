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

$sql="SELECT
chofer.id as ChoferID,
chofer.Nombre,
empresa.Nombre as 'Nombre Empresa',
empresa.id as 'EmpresaID',
COUNT(recaudaciones.id) as Cantidad,
min(HoraEntrada) as Desde,
max(HoraEntrada) as Hasta,
max(ViaticoNoCobrado) as 'Viatico No Cobrado',
max(ViaticoCobrado) as 'Viatico Cobrado',
ViaticoCorrespondiente,
DiferenciaDeViatico,
TRUNCATE(sum(DiferenciaDeViatico),2) as 'Diferencia Bruta',
TRUNCATE(sum(DiferenciaDeViaticoNeta),2) as 'Diferencia Neta',
movil.NumRut as RUT,
BPS,
periodosaguinaldo.id
FROM `recaudaciones`,periodosaguinaldo,chofer,movil,empresa
WHERE HoraEntrada>'2022-07-01 00:00:00' and Kilometros>0
AND recaudaciones.HoraEntrada>=periodosaguinaldo.desde 
AND recaudaciones.HoraEntrada<=periodosaguinaldo.hasta
AND chofer.id=recaudaciones.Chofer
AND chofer.id=".$_GET['chofer']."
and movil.NumRut=empresa.NumeroDeRUT
and recaudaciones.MovilId=movil.Id
GROUP BY Chofer,movil.NumRut
ORDER BY chofer.Nombre,`HoraEntrada` ASC;";
$registros=ejecutarConsulta($sql);

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
    <a href="choferesRecibos.php?chofer=<?php echo $_GET['chofer'];?>">Recibo Sueldo </a> |
     <a href="choferesRecibosAguinaldos.php?chofer=<?php echo $_GET['chofer'];?>">Aguinaldos</a> |
     Vacionales y Licencias | 
     <b>Retoactivos</b>
    <hr>

    <table id="tablax" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <th>Chofer</th>
            <th>Empresa</th>
            <th>Recibo</th>
        </thead>
        <tbody>
            <?php
            foreach($registros as $reg)
            {
                echo'<tr>';
                echo'<td>';
                echo $reg["Nombre"];
                echo'</td>';
                echo'<td>';
                echo $reg["Nombre Empresa"];
                echo'</td>';
                echo'<td>';
                echo "
                    <form action='recibo_retroactivo.php' method='POST'>
                    <input type='hidden' name='EmpresaID' value='".$reg["EmpresaID"]."'>
                    <input type='hidden' name='ChoferID' value='".$reg["ChoferID"]."'>
                    <input type='Submit' class='btn btn-primary' name='Recibo' value='Recibo' title='Recibo' width='30' height='15'>
                    </form>
                ";
                echo'</td>';
                echo'</tr>';

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
