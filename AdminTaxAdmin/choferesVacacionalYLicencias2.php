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

<?php 
include('index.php');
$sql="SELECT * FROM `chofer` WHERE chofer.id=".$_GET['chofer'];
$chofer=ejecutarConsulta($sql);

$sql=
"SELECT 
chofer.id as choferID, 
chofer.Nombre as Nombre, 
COUNT(recaudaciones.id) as Jornales, 
TRUNCATE(sum(`29`),2) as Salario29, 
TRUNCATE(sum(`Salario`),2) as Salario33, 
TRUNCATE(sum(recaudaciones.Recaudado),2) as Recaudado, 
movil.Matricula as Movil, 
movil.NumRut as RUT, 
empresa.id as Empresa, 
licencias.Id as Periodo, 
licencias.desde as Desde, 
licencias.hasta as Hasta 
from recaudaciones,chofer,movil,empresa,licencias 
WHERE 
recaudaciones.Kilometros > 0 
and recaudaciones.FeriadoNoCobrado=0 
and recaudaciones.FeriadoCobrado=0 
and recaudaciones.Chofer=chofer.id 
and recaudaciones.MovilId=movil.Id 
and movil.NumRut=empresa.NumeroDeRUT 
and recaudaciones.HoraEntrada>=licencias.desde 
and recaudaciones.HoraEntrada<=licencias.hasta 
AND chofer.id=".$_GET['chofer']." GROUP by licencias.Id;
";
$preconteo=ejecutarConsulta($sql);

?>