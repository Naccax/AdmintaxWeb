<?php

function ejecutarConsulta($consulta)
  {
    // Ejemplo de conexión a base de datos MySQL con PHP.
    //
    // Ejemplo realizado por Oscar Abad Folgueira: http://www.oscarabadfolgueira.com y https://www.dinapyme.com
    
    // Datos de la base de datos
    $usuario = "root";
    $password = "";
    $servidor = "localhost";
    $basededatos = "AdminTax";
    
    // creación de la conexión a la base de datos con mysql_connect()
    $conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
    
    // Selección del a base de datos a utilizar
    $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
  
    // establecer y realizar consulta. guardamos en variable.
    $sql = $consulta;
    //echo $sql . '<br>';
    $resultado = mysqli_query( $conexion, $sql ) or die ( "Algo ha ido mal en la consulta a la base de datos");
    
    // Motrar el resultado de los registro de la base de datos
    // Encabezado de la tabla
    
    // Bucle while que recorre cada registro y muestra cada campo en la tabla.
    $i=0;
    $respuesta=[];

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

?>