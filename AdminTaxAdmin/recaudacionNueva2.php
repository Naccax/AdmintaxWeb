<script>
    function actualizar(opcion){
            //$("#action-button").click();
    }
</script>

<?php include('index.php');
echo'<br>';

$consulta="SELECT * FROM empresa";
$empresas = ejecutarConsulta($consulta);

$consulta="SELECT * FROM movil order by Matricula";
$moviles = ejecutarConsulta($consulta);

if (((isset($_POST["movil"])) and ($_POST["movil"]!="")) or (isset($_POST["Movil_Id"])))
{
  if(($_POST["movil"]==""))
  {
    $consulta="SELECT MAX(KmSalida) AS km,Movil,MovilId from recaudaciones where MovilId=".$_POST["Movil_Id"];
  }
  else
  {
    $consulta="SELECT MAX(KmSalida) AS km,Movil,MovilId from recaudaciones where MovilId=".$_POST["movil"];
  }
  
  $movil = ejecutarConsulta($consulta);
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
      <form action="
      <?php
      if(isset($_POST['Kilometros']))
      {
        if ($_POST['Kilometros']>=0)
        { 
          echo "recaudacionNueva2.php";
        } else
          echo "#";
      }
      else
        echo "#";
      ?>
      " method="POST">
        <div class="user-details">

        <div class="input-box">
            <span class="details">Elija Movil: STX</span>
                        <select name="movil" id="NumRut" class="form-select" onchange="actualizar(this)" 
                        <?php
                        if ((!isset($_POST['movil'])) and (!isset($movil[0]['MovilId'])))
                        { 
                          echo " autofocus ";
                        } 
                        ?>
                        >
                                <?php
                                if(isset($movil[0]['MovilId']))
                                {
                                  $temp=explode(" ",$movil[0]['Movil']);
                                  echo "<option value='".$row['Id']."' selected>".$temp[1]."</option>";
                                }
                                foreach($moviles as $row)
                                {
                                    $temp=explode(" ",$row['Matricula']);
                                    echo "<option value='".$row['Id']."'>".$temp[1]."</option>";
                                }
                                ?>
                        </select>
        </div>

        <?php if (isset($movil[0]['MovilId'])) { ?>

        <div class="input-box">
          <span class="details">Movil Id</span>
          <input type="text" placeholder="Movil Id" name="Movil Id" readonly
          <?php 
          if (isset($movil[0]['MovilId']))
            echo ' value="'.$movil[0]['MovilId'].'"'
          ?>
          >
        </div>
        
        <div class="input-box">
          <span class="details">Movil</span>
          <input type="text" placeholder="Movil" name="Movil" readonly
          <?php 
          if (isset($movil[0]['Movil']))
            echo ' value="'.$movil[0]['Movil'].'"'
          ?>
          >
        </div>

        
        
        <div class="input-box">
          <span class="details">Último Km</span>
          <input type="text" placeholder="km" name="km" readonly
          <?php 
          if (isset($movil[0]['Movil']))
            echo ' value="'.$movil[0]['km'].'"'
          ?>
          >
        </div>
        
        <div class="input-box">
          <span class="details">Km Entrada</span>
          <input type="number" placeholder="Km Entrada" name="KmEntrada"
          <?php 
          if (((isset($movil[0]['Movil'])) and (!isset($_POST['Relevo']))))
            echo ' autofocus value="'.$movil[0]['km'].'"';
          
          if (isset($_POST['KmEntrada']))
            echo ' value="'.$_POST['KmEntrada'].'"';
          ?>
          >
        </div>

        <div class="input-box">
          <span class="details">Km Relevo</span>
          <input type="number" placeholder="Relevo" name="Relevo" readonly
          <?php 
            if (isset($movil[0]['Movil']) and (@$_POST["KmEntrada"]>0))
            {
              $temp=$_POST["KmEntrada"]-$movil[0]['km'];
              echo ' value="'.$temp.'"';
            }            
          ?>
          >
        </div>

        <div class="input-box">
          <span class="details">Km Salida</span>
          <input type="number" placeholder="Km Salida" name="KmSalida"
          <?php
          if (isset($_POST['KmEntrada']))
            if($_POST['KmSalida']=="")
              echo ' required autofocus value="'.$_POST["KmEntrada"].'"';
          if (isset($_POST['KmSalida']))
            echo ' required value="'.$_POST["KmSalida"].'"';
          ?>
          >
        </div>

        <?php if ((isset($_POST["KmEntrada"])) and (isset($_POST["KmSalida"]))) { ?>

        <div class="input-box">
          <span class="details">Km Rerridos</span>
          <input type="number" placeholder="Km Salida" name="Kilometros"
          <?php
          if (isset($_POST['KmEntrada']))
            if($_POST['KmSalida']!="")
            {
              $temp=$_POST['KmSalida']-$_POST["KmEntrada"];
              echo ' required readonly autofocus value="'.$temp.'"';
            }
          ?>
          >
        </div>
        


        <?php } ?>
        <?php } ?>

        </div>
        <div class="button">
          <input type="submit" value="Siguiente" id="action-button">
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
