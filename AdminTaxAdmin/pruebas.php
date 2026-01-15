
<?php include('index.php');
$sql="SELECT planilladetrabajo.Id,planilladetrabajo.ChoferID, planilladetrabajo.Fecha, planilladetrabajo.ValorDeJornal8,planilladetrabajo.Aporte, planilladetrabajo.ValorHSExtra, planilladetrabajo.ValorDeViatico FROM planilladetrabajo WHERE planilladetrabajo.Concepto='Recibo Sueldo';";
$recibos=ejecutarConsulta($sql);

$sql="SELECT `id`,tipoAporte FROM `chofer`;";
$choferes=ejecutarConsulta($sql);

$i=0;
foreach($recibos as $row)
{
    //buscar valor de jornal de 8hs
    $temp=0;
    foreach($choferes as $chofer)
    {
        if($chofer['id']==$row['ChoferID'])
        {
            $temp=$chofer['tipoAporte'];
        }
    }
    $recibos[$i]["Aporte"]=100-$temp;
    $i++;
}
print_r($recibos[218]);
echo "<br>";
$sql="";
foreach($recibos as $row)
{
    $sql=$sql."
    UPDATE planilladetrabajo SET
    Aporte='".$row["Aporte"]."'
    WHERE
    planilladetrabajo.Id='".$row["Id"]."';<br>
    ";
}
echo $sql;
?>