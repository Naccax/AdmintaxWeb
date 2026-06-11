<?php
if(isset($_SESSION['usuario']))
{
    $consulta="SELECT * FROM `movil` WHERE `NumRut`='".$_SESSION['empresa']."';";
    $todosLosMoviles=ejecutarConsulta($consulta);
    
    $consulta="SELECT * FROM `chofer` WHERE RUT='".$_SESSION['empresa']."'";
    $todosLosChoferes=ejecutarConsulta($consulta);
    $choferes=[];

    foreach($todosLosChoferes as $chofer)
    {
      $choferes[$chofer['id']]=$chofer;
    }
    
    $consulta='SELECT * FROM `empresa` WHERE `NumeroDeRUT`="'.$_SESSION['empresa'].'"';
    $EmpresaDatos = ejecutarConsulta($consulta);

}else
{
    header('Location: login.php');
}

if(isset($_GET['salir']))
{
    session_destroy();
    header('Location: login.php');
}
?>