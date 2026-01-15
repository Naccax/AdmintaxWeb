<?php

$meces["01"]="Enero";
$meces["02"]="Febrero";
$meces["03"]="Marzo";
$meces["04"]="Abril";
$meces["05"]="Mayo";
$meces["06"]="Junio";
$meces["07"]="Julio";
$meces["08"]="Agosto";
$meces["09"]="Septiembre";
$meces["10"]="Octubre";
$meces["11"]="Noviembre";
$meces["12"]="Diciembre";
$meces["13"]="Enero";

function ejecutarConsulta($consulta)
  {
    $usuario = "root";
    $password = "";
    $servidor = "localhost";
    $basededatos = "admintax";

    $conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
    
    // Selección del a base de datos a utilizar
    $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
  
    // establecer y realizar consulta. guardamos en variable.
    $sql = $consulta;
    //echo $sql . '<br>';
    $resultado = mysqli_query( $conexion, $sql ) or die ( "Algo ha ido mal en la consulta a la base de datos");
    
    $i=0;
    $respuesta=[];

    //print_r( $resultado );

    while ($columna = mysqli_fetch_array( $resultado ))
    {
      $respuesta[$i]=$columna;
      //print_r($columna);
      $i=$i+1;
    }
    
    // cerrar conexión de base de datos
    mysqli_close( $conexion );
    
    //print_r($resultado);
    return $respuesta;

  }
  
    /** Actual month last day **/
    function _data_last_month_day() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
 
  /** Actual month first day **/
  function _data_first_month_day() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }

  $consulta="SELECT * FROM `chofer`";
  $todosLosChoferes=ejecutarConsulta($consulta);
  $choferes=[];

  foreach($todosLosChoferes as $chofer)
  {
    $choferes[$chofer['id']]=$chofer;
  }

  $consulta="SELECT * FROM `empresa`";
  $todosLasEmpresas=ejecutarConsulta($consulta);
  $Empresas=[];

  foreach($todosLasEmpresas as $chofer)
  {
    $Empresas[$chofer['id']]=$chofer;
  }

  function Insert($consulta){
    
    $usuario = "root";
    $password = "";
    $servidor = "localhost";
    $basededatos = "admintax";
    
    $conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
    
    // Selección del a base de datos a utilizar
    $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
  
    // establecer y realizar consulta. guardamos en variable.
    $sql = $consulta;
    //echo $sql . '<br>';
    $resultado = mysqli_query( $conexion, $sql ) or die ( "Algo ha ido mal en la consulta a la base de datos");
    }
?>