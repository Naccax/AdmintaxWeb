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
$consulta="SELECT * FROM chofer";
$datosChoferes = ejecutarConsulta($consulta);

function getEmpresaId($rut, $empresas)
{
    $respuesta="";
    foreach($empresas as $empresa)
    {
        if($empresa['NumeroDeRUT']==$rut)
        {
            $respuesta=$empresa['id'];
        }
    }
    return $respuesta;
}

$consulta="SELECT * FROM `retroactivos` WHERE `retroactivos`.`Detalle`='Viático' ORDER BY `retroactivos`.`Fecha` ASC";
$retroactivos=ejecutarConsulta($consulta);

if(!isset($_POST))
{
    $i=0;
    foreach($retroactivos as $retroactivo)
    {
        $sql="UPDATE recaudaciones,chofer SET 
        ViaticoCorrespondiente='".$retroactivos[$i]['Monto']."',
        DiferenciaDeViatico=
        TRUNCATE(
            (
                '".$retroactivos[$i]['Monto']."'-(`ViaticoCobrado`+ViaticoNoCobrado)
            ),
            2
        ),
        DiferenciaDeViaticoNeta=
        TRUNCATE(
            (
                '".$retroactivos[$i]['Monto']."'-(`ViaticoCobrado`+ViaticoNoCobrado)
            ),
            2
        )
        WHERE `recaudaciones`.`HoraEntrada`>='".$retroactivos[$i]['Fecha']."'
        and `Kilometros` > 0;";
        Insert($sql);
        $i++;
    }
    
    $sql="UPDATE recaudaciones,chofer SET 
    DiferenciaDeViaticoNeta=
    TRUNCATE(
        (
            DiferenciaDeViaticoNeta-((DiferenciaDeViaticoNeta/2)*(BPS/100))
        ),
        2
    )
    WHERE `recaudaciones`.`HoraEntrada`>='".$retroactivos[0]['Fecha']."' 
    AND ViaticoNoCobrado > 0 
    and `Kilometros` > 0;";
    Insert($sql);
    
    
    $sql="UPDATE recaudaciones,chofer SET 
    RetencionDeRetroactividad=
    TRUNCATE(
        (
            ((DiferenciaDeViaticoNeta*0.35)*(0.25))
        ),
        2
    )
    WHERE `recaudaciones`.`HoraEntrada`>='".$retroactivos[0]['Fecha']."' 
    AND ViaticoNoCobrado > 0 
    and OtraRetencion > 0 
    and `Kilometros` > 0;";
    Insert($sql);
    

}

$consulta="SELECT 
chofer.id,
chofer.Nombre,
TRUNCATE(sum(DiferenciaDeViaticoNeta),2) as DiferenciaDeViaticoNeta,
TRUNCATE(sum(recaudaciones.DiferenciaDeViatico),2) as DiferenciaDeViatico,
TRUNCATE(sum(RetencionDeRetroactividad), 2) as RetencionDeRetroactividad,
COUNT(recaudaciones.id) as Cantidad,
TRUNCATE(sum(ViaticoNoCobrado+ViaticoCobrado),2) as ViaticoCobrado,
TRUNCATE(sum(ViaticoCorrespondiente),2) as ViaticoCorrespondiente,
movil.NumRut as NumRut
FROM 
`recaudaciones`,movil,chofer 
where 
recaudaciones.Chofer=chofer.id
and `HoraEntrada`>'".$retroactivos[0]['Fecha']."' 
and recaudaciones.Movil=movil.Matricula
and Kilometros>0 
GROUP by chofer.Nombre,movil.NumRut;
";

//echo $consulta;
$todosLosChoferes=ejecutarConsulta($consulta);


if((!isset($_POST['Filtro'])) or (!isset($_POST['masInfo']))){

    $sql="SELECT * FROM planilladetrabajo WHERE Concepto='Retroactivo 2023'";
    $recibosExistentes=ejecutarConsulta($sql);

    $ejecutar=false;
    $values="";
    foreach($todosLosChoferes as $chofer)
    {
        $existe=false;
        foreach($recibosExistentes as $recibo)
        {
            if($recibo['ChoferID']==$chofer['id'])
            {
                $existe=true;
            }
        }
        //$empresaId=getEmpresaId($chofer['RUT'],$empresas);
        if(!$existe){
            $values=$values." ('".date('Y-m-d')."','Retroactivo 2023',
            '".$chofer['EmpresaId']."',
            '".$chofer['id']."',
            '".$chofer['Cantidad']."',
            '".($chofer['DiferenciaDeViatico'])*(1)."',
            '".($chofer['DiferenciaDeViatico'])*(1)."',
            '".($chofer['DiferenciaDeViatico'])*(1)."',
            '".($chofer['DiferenciaDeViaticoNeta'])*(1)."',
            '".($chofer['DiferenciaDeViatico'])*(0.5)."')";
            $ejecutar=true; 
        }
    }

    $sql="Insert into planilladetrabajo 
    (Fecha,Concepto,EmpresaID,ChoferID,Comunes_Jornales,Comunes_MontoAbonado,RemuneracionTotal,TotalBruto,TotalRecibido,SueldoBaseParaAportacion)";
    $sql=$sql." VALUES ".str_replace(") (", "), (", $values);
    //echo $sql;

    if ($ejecutar) 
        Insert($sql);

    $values="";
}

$todosLosChoferes=ejecutarConsulta($consulta);
/*
$consulta="SELECT * FROM `recaudaciones`,`chofer` where `recaudaciones`.`Chofer`=`chofer`.`id` and `recaudaciones`.`ViaticoCobrado`!='0' and `recaudaciones`.`HoraEntrada`>='".$retroactivos[0]['Fecha']."' ORDER BY `recaudaciones`.`HoraEntrada` DESC";
$todosLosChoferes=ejecutarConsulta($consulta);
*/
$consulta2="SELECT 
chofer.id as id,
chofer.Nombre as Nombre,
TRUNCATE(sum(DiferenciaDeViaticoNeta/2/6),2) as DiferenciaDeViaticoNeta,
TRUNCATE(sum(DiferenciaDeViatico/2/6),2) as DiferenciaDeViatico,
TRUNCATE(sum(RetencionDeRetroactividad/2/6),2) as RetencionDeRetroactividad,
COUNT(recaudaciones.id) as Cantidad,
TRUNCATE(sum(ViaticoNoCobrado/2/6),2) as ViaticoCobrado,
TRUNCATE(sum(ViaticoCorrespondiente/2/6),2) as ViaticoCorrespondiente,
movil.NumRut as NumRut,
periodosaguinaldo.id as P_id,
periodosaguinaldo.desde,
periodosaguinaldo.hasta
FROM `recaudaciones`,movil,periodosaguinaldo,chofer
where 
chofer.id=recaudaciones.Chofer
and `HoraEntrada`>'2022-07-01 00:00:00'
and Kilometros>0
and ViaticoNoCobrado>0
and HoraEntrada>=periodosaguinaldo.desde
and HoraEntrada<=periodosaguinaldo.hasta
and movil.Matricula=recaudaciones.Movil
GROUP BY chofer.id,`movil`.`NumRut`  
ORDER BY periodosaguinaldo.hasta DESC;";


if((isset($_POST['Filtro'])) and ($_POST['Filtro']=="Filtrar por Empresa"))
{
    $consulta=str_replace("GROUP by chofer.Nombre,movil.NumRut","GROUP by movil.NumRut",$consulta);
    $consulta=str_replace("chofer.Nombre,","movil.NumRut as Nombre,",$consulta);
    $todosLosChoferes=ejecutarConsulta($consulta);
    $consulta2=str_replace("GROUP BY chofer.id,`movil`.`NumRut`,periodosaguinaldo.id","GROUP BY `movil`.`NumRut`",$consulta2);
    
}
$aguinaldos=ejecutarConsulta($consulta2);

function btnEliminar($retoactivo)
{
  $respuesta = "
  <form action='recibo_retroactivo' method='POST'>
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
                    echo '<td><a href="recibo_retroactivo.php?Chofer='.$chofer['id'].'&Empresa='.$chofer['NumRut'].'&Retencion='.$chofer['RetencionDeRetroactividad'].'">';
                    echo $chofer['Nombre'];
                    echo '</td></a>';
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
                        echo $chofer['ViaticoCobrado'];
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['ViaticoCorrespondiente'];
                        echo '</td>';
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['NumRut'];
                        echo '</td>';
                    }
                    
                    $values="";
                    $empresa=getEmpresaId($chofer['NumRut'],$empresas);//Cantidad
                    $values=$values."UPDATE planilladetrabajo SET 
                    Fecha='".date('Y-m-d')."',
                    Comunes_MontoAbonado='".($chofer['DiferenciaDeViatico'])*(1)."',
                    Comunes_Jornales='".($chofer['Cantidad'])*(1)."',
                    RemuneracionTotal='".($chofer['DiferenciaDeViatico'])*(1)."',
                    TotalBruto='".($chofer['DiferenciaDeViatico'])*(1)."',
                    TotalRecibido='".($chofer['DiferenciaDeViaticoNeta'])*(1)."',
                    SueldoBaseParaAportacion='".($chofer['DiferenciaDeViatico'])*(0.5)."' 
                    WHERE ChoferID='".$chofer['id']."' AND  Concepto='Retroactivo 2023' and EmpresaId='".$empresa."';
                    ";
                    Insert($values);
                    echo '</tr>';

                }
                foreach($aguinaldos as $chofer)
                {
                    echo '<tr>';
                    echo '<td>';
                    echo $chofer['id'];
                    echo '</td>';
                    echo '<td><a href="recibo_retroactivo.php?Chofer='.$chofer['id'].'&Empresa='.$chofer['NumRut'].'&Retencion='.$chofer['RetencionDeRetroactividad'].'">';
                    echo $chofer['Nombre']."(Aguinaldo)";
                    echo '</td></a>';
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
                        echo $chofer['ViaticoCobrado'];
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['ViaticoCorrespondiente'];
                        echo '</td>';
                        echo '</td>';
                        echo '<td>';
                        echo $chofer['NumRut'];
                        echo '</td>';
                    }
                    
                    $values="";
                    $empresa=getEmpresaId($chofer['NumRut'],$empresas);//Cantidad
                    $values=$values."UPDATE planilladetrabajo SET 
                    Fecha='".date('Y-m-d')."',
                    Comunes_MontoAbonado='".($chofer['DiferenciaDeViatico'])*(1)."',
                    Comunes_Jornales='".($chofer['Cantidad'])*(1)."',
                    RemuneracionTotal='".($chofer['DiferenciaDeViatico'])*(1)."',
                    TotalBruto='".($chofer['DiferenciaDeViatico'])*(1)."',
                    TotalRecibido='".($chofer['DiferenciaDeViaticoNeta'])*(1)."',
                    SueldoBaseParaAportacion='".($chofer['DiferenciaDeViatico'])*(0.5)."' 
                    WHERE ChoferID='".$chofer['id']."' AND  Concepto='Retroactivo 2023' and EmpresaId='".$empresa."';
                    ";
                    //Insert($values);
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
      <form action='#' method='POST'>
      <?php 
      if((isset($_POST['Filtro'])) and ($_POST['Filtro']=="Filtrar por Empresa")) 
      {
        echo "<input type='submit' name='Filtro' class='btn btn-secondary' value='Quitar Filtro' src='img/chofer.jpg' title='Filtrar por Empresa' width='60' height='60' align='centre'>";
      }
      else
      {
        echo "<input type='submit' name='Filtro' class='btn btn-secondary' value='Filtrar por Empresa' src='img/chofer.jpg' title='Filtrar por Empresa' width='60' height='60' align='centre'>";
      } 
      ?>
      
      </form>
    </center>
    </td>
</tr></table>
    </div>
</body>
</html>
