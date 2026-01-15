<?php include('index.php');
echo'<br>';

$consulta="SELECT * FROM empresa";
$empresas = ejecutarConsulta($consulta);

//si tiene un chofer, almacenarlo
//Array ( [CI] => 46950885 [Nombre] => Cavallero, Hector [Patronal] => 101 [Celeritas] => 258 [Direccion] => canelones 1087 [contacto] => 1111111 [contacto2] => 0 [Sueldo] => 33 [tipoAporte] => 21.100 [FechaNacimiento] => 1995-09-17 [FechaDeIngreso] => 2023-10-10 [NombreEnPlanilla] => Miguelo [HsExtra] => on )



if (isset($_GET['chofer']))
{
  $consulta="Select * from chofer where id=".$_GET['chofer'];
  $chofer=ejecutarConsulta($consulta);
  
  $inicio = date("Y-m-01");
  $fechaNacimiento=$chofer[0]['FechaNacimiento'];
  $FechaDeIngreso=$chofer[0]['FechaDeIngreso'];

  
}
//print_r($chofer[0]);
?>
<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Responsive Registration Form | CodingLab </title>
    <link rel="stylesheet" href="style.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins',sans-serif;
}
.container{
  max-width: 700px;
  width: 100%;
  background-color: #fff;
  padding: 25px 30px;
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}
.container .title{
  font-size: 25px;
  font-weight: 500;
  position: relative;
}
.container .title::before{
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  width: 30px;
  border-radius: 5px;
  background: linear-gradient(135deg, #71b7e6, #9b59b6);
}
.content form .user-details{
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 20px 0 12px 0;
}
form .user-details .input-box{
  margin-bottom: 15px;
  width: calc(100% / 2 - 20px);
}
form .input-box span.details{
  display: block;
  font-weight: 500;
  margin-bottom: 5px;
}
.user-details .input-box input{
  height: 45px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 5px;
  padding-left: 15px;
  border: 1px solid #ccc;
  border-bottom-width: 2px;
  transition: all 0.3s ease;
}
.user-details .input-box input:focus,
.user-details .input-box input:valid{
  border-color: #9b59b6;
}
 form .gender-details .gender-title{
  font-size: 20px;
  font-weight: 500;
 }
 form .category{
   display: flex;
   width: 80%;
   margin: 14px 0 ;
   justify-content: space-between;
 }
 form .category label{
   display: flex;
   align-items: center;
   cursor: pointer;
 }
 form .category label .dot{
  height: 18px;
  width: 18px;
  border-radius: 50%;
  margin-right: 10px;
  background: #d9d9d9;
  border: 5px solid transparent;
  transition: all 0.3s ease;
}
 #dot-1:checked ~ .category label .one,
 #dot-2:checked ~ .category label .two,
 #dot-3:checked ~ .category label .three{
   background: #9b59b6;
   border-color: #d9d9d9;
 }
 form input[type="radio"]{
   display: none;
 }
 form .button{
   height: 45px;
   margin: 35px 0
 }
 form .button input{
   height: 100%;
   width: 100%;
   border-radius: 5px;
   border: none;
   color: #fff;
   font-size: 18px;
   font-weight: 500;
   letter-spacing: 1px;
   cursor: pointer;
   transition: all 0.3s ease;
   background: linear-gradient(135deg, #71b7e6, #9b59b6);
 }
 form .button input:hover{
  /* transform: scale(0.99); */
  background: linear-gradient(-135deg, #71b7e6, #9b59b6);
  }
 @media(max-width: 584px){
 .container{
  max-width: 100%;
}
form .user-details .input-box{
    margin-bottom: 15px;
    width: 100%;
  }
  form .category{
    width: 100%;
  }
  .content form .user-details{
    max-height: 450px;
    overflow-y: scroll;
  }
  .user-details::-webkit-scrollbar{
    width: 5px;
  }
  }
  @media(max-width: 459px){
  .container .content .category{
    flex-direction: column;
  }
}
     </style>
   </head>
<body>
  <div class="container">
    <div class="title">Datos Personales</div>
    <div class="content">
      <form action="choferesTodos.php" method="POST">
        <div class="user-details">
            
          <div class="input-box">
            <span class="details">Id</span>
            <input type="number" <?php echo 'value="'.$chofer[0]['id'].'"'; ?>  name="id" required readonly>
          </div>
          
          <div class="input-box">
            <span class="details">C.I.</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['ci'].'"'; ?> placeholder="C.I." name="CI" required >
          </div>
          <div class="input-box">
            <span class="details">Nombre</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['Nombre'].'"'; ?> placeholder="Apellidos, Nombre" name="Nombre" required>
          </div>
          <div class="input-box">
            <span class="details">Patronal</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['patronal'].'"'; ?> placeholder="N° de conductors" name="Patronal" >
          </div>
          <div class="input-box">
            <span class="details">Celeritas</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['celeritas'].'"'; ?> placeholder="N° de conductors" name="Celeritas" >
          </div>
          <div class="input-box">
            <span class="details">Direcci&oacute;n</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['direccion'].'"'; ?> placeholder="Direcci&oacute;n" name="Direccion" required>
          </div>
          <div class="input-box">
            <span class="details">Contacto</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['contacto'].'"'; ?> placeholder="091234567" name="contacto" required>
          </div>
          <div class="input-box">
            <span class="details">Contacto 2</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['contacto2'].'"'; ?> placeholder="091234567"  name="contacto2">
          </div>
          <div class="input-box">
            <span class="details">Sueldo</span>
            <input type="number" <?php echo 'value="'.$chofer[0]['Sueldo'].'"'; ?> placeholder="33%"  name="Sueldo">
          </div>
          <div class="input-box">
            <span class="details">Aporte</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['tipoAporte'].'"'; ?> placeholder="21.1"  name="tipoAporte">
          </div>
          <div class="input-box">
            <span class="details">Retenci&oacute;n</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['Retención'].'"'; ?> placeholder="0" name="Retencion">
          </div>
          <div class="input-box">
            <span class="details">Fecha de Nacimiento</span>
            <input type="datetime-local" <?php echo 'value="'.$chofer[0]['FechaNacimiento'].'"'; ?> name="FechaNacimiento">
          </div>
          <div class="input-box">
            <span class="details">Fecha De Ingreso</span>
            <input type="datetime-local" <?php echo 'value="'.$chofer[0]['FechaDeIngreso'].'"'; ?> name="FechaDeIngreso">
          </div>

          <div class="input-box">
            <span class="details">Elija Empresa (RUT):</span>
                        <select name="empresa" id="empresa" class="form-select">
                                
                                <?php
                                echo '<option value="'.$chofer[0]['RUT'].'">'.$chofer[0]['RUT'].'</option>';
                                foreach($empresas as $row)
                                {
                                    echo "<option value='".$row['NumeroDeRUT']."'>".$row['NumeroDeRUT']."</option>";
                                }
                                ?>
                        </select>
          </div>

          <div class="input-box">
            <span class="details">Nombre En Planilla</span>
            <input type="text" <?php echo 'value="'.$chofer[0]['NombreEnPlanilla'].'"'; ?> placeholder="Nombre en Excel"  name="NombreEnPlanilla">
          </div>
          <div class="input-box">
            <span class="details">Hs Extra</span>
            <?php
            if($chofer[0]['HsExtra']=="true")
            {
              echo'<input type="checkbox" name="HsExtra" checked="true">';
            }else
            {
              echo'<input type="checkbox" name="HsExtra">';
            } 
            ?>
            
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Guardar">
        </div>
      </form>
    </div>
  </div>

</body>
</html>