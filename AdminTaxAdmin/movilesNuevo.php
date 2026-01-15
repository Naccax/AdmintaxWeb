<?php include('index.php');
echo'<br>';

$consulta="SELECT * FROM empresa";
$empresas = ejecutarConsulta($consulta);

if (isset($_GET["movil"]))
{
  $sql="SELECT * FROM movil where Id=".$_GET["movil"];
  $movil=ejecutarConsulta($sql);
}
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
    max-height: 500px;
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
    
    <div class="content">
      <form action="movilesTodos.php" method="POST">
        <div class="user-details">
        
        <div class="input-box">
            <span class="details">Id</span>
            <input type="number" name="id" readonly placeholder="NULL"
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['Id'].'"'
            ?>
            >
        </div>


          <div class="input-box">
            <span class="details">Matrícula</span>
            <input type="text" placeholder="Matricula" name="Matricula" required 
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['Matricula'].'"'
            ?>
            >
          </div>
          <div class="input-box">
            <span class="details">Patronal</span>
            <input type="text" placeholder="N° de Patronal" name="Patronal" 
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['Patronal'].'"'
            ?>
            >
          </div>
          <div class="input-box">
            <span class="details">Celeritas</span>
            <input type="text" placeholder="N° de Celeritas" name="Celeritas" 
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['Celeritas'].'"'
            ?>
            >
          </div>
          <div class="input-box">
            <span class="details">N° de Empresa</span>
            <input type="text" placeholder="11715" name="NumEmpresa"
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['NumEmpresa'].'"'
            ?>
            >
          </div>
          <div class="input-box">
            <span class="details">N° de Pos</span>
            <input type="text" placeholder="30717721"  name="NumPos"
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['NumPos'].'"'
            ?>
            >
          </div>
          
          <div class="input-box">
            <span class="details">Elija Empresa (RUT):</span>
                        <select name="NumRut" id="NumRut" class="form-select" required>
                                <?php
                                if (isset($movil[0]['NumRut']))
                                  echo "<option value='".$movil[0]['NumRut']."'>".$movil[0]['NumRut']."</option>";
                                foreach($empresas as $row)
                                {
                                    echo "<option value='".$row['NumeroDeRUT']."'>".$row['NumeroDeRUT']."</option>";
                                }
                                ?>
                        </select>
          </div>

          <div class="input-box">
            <span class="details">Padron</span>
            <input type="text" placeholder="903629063"  name="Padron"
            <?php 
            if (isset($movil[0]['Id']))
              echo ' value="'.$movil[0]['Padron'].'"'
            ?>
            >
          </div>
          
          <div class="input-box">
            <span class="details">Combustible: </span>
                        <select name="Combustible" id="Combustible" class="form-select">
                          <?php 
                          if (isset($movil[0]['Id']))
                            echo "<option value='".$movil[0]['Combustible']."'>".$movil[0]['Combustible']."</option>";
                          ?>
                          
                          <option value='Nafta Premium'>Nafta Premium</option>
                          <option value='Nafta Super'>Nafta Super</option>
                          <option value='Gas-oil Especial'>Gas-oil Especial</option>
                          <option value='Gas-oil'>Gas-oil</option>
                          <option value='Electricidad'>Electricidad</option>
                        </select>
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Registrar">
        </div>
      </form>
    </div>
  </div>
<?php

if (isset($salir))
  if($salir=="si")
    header('location:movilesTodos.php');
?>
</body>
</html>
