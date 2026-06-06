<?php
session_start();
session_destroy();
include 'funciones.php';


$consulta="SELECT Empresa FROM `usuarios` GROUP BY `Empresa` ORDER BY Empresa desc";
$listaDeRut = ejecutarConsulta($consulta);


if(isset($_POST['usuario']))
{
    $user=$_POST['usuario'];
    $pass=$_POST['password'];
    $empresa=$_POST['empresa'];

    $consulta='SELECT * FROM `usuarios` WHERE `UserId`="'.$user.'" AND `Password`="'.$pass.'" AND `Empresa`="'.$empresa.'";';
    $UserDatos = ejecutarConsulta($consulta);

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
}

?>


<!-- Define que el documento esta bajo el estandar de HTML 5 -->
<!doctype html>

<!-- Representa la raíz de un documento HTML o XHTML. Todos los demás elementos deben ser descendientes de este elemento. -->
<html lang="es">
    
    <head>
        
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="css/login.css">
        
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
                        <select name="empresa" id="empresa" class="form-select">
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
            </div>
        </div>
            
    </body>
</html>