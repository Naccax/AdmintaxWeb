<?php include('index.php');
echo'<br>';
$doc=[];

$consulta="SELECT * FROM laudos group by Detalle asc";
$tipos = ejecutarConsulta($consulta);

if(isset($_GET["doc"]))
{
  $sql="SELECT * FROM laudos WHERE Id=".$_GET["doc"];
  $doc=ejecutarConsulta($sql);
}

//print_r($_POST);

if ((isset($_POST['Detalle'])))
{
  if ($_POST['id']!=""){
    $consulta="UPDATE `laudos` SET 
    `Detalle`='".$_POST['Detalle']."', 
    `Monto`='".$_POST['Monto']."', 
    `Fecha`='".$_POST['Fecha']."' WHERE 
    `Id`='".$_POST['id']."';";
    //echo $consulta;
    Insert($consulta);
  }else
  {
    $sql="INSERT INTO `laudos` (Detalle,Monto,Fecha) VALUES ";
    $values="('".$_POST['Detalle']."','".$_POST['Monto']."','".$_POST['Fecha']."');";
    $sql=$sql.$values;
    Insert($sql);
  }
    header('location:LaudosTodos.php');    
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
    max-height: 400px;
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
      <form action="#" method="POST">
        <div class="user-details">          
          <div class="input-box">
            <span class="details">Id</span>
            <input type="number" name="id" required readonly placeholder="NULL"
            <?php 
            if (isset($doc[0]['Detalle']))
              echo 'value="'.$doc[0]['Id'].'"'
            ?>
            >
          </div>
                    
          <div class="input-box">
            <span class="details">Detalle:</span>
                        <select name="Detalle" id="Detalle" class="form-select">
                                <?php
                                //echo '<option value="'.$doc[0]['Detalle'].'">'.$chofer[0]['Detalle'].'</option>';
                                foreach($tipos as $row)
                                {
                                      echo "<option value='".$row['Detalle']."'>".$row['Detalle']."</option>";
                                }
                                if (isset($doc[0]['Detalle']))
                                  echo "<option value='".$doc[0]['Detalle']."' selected>".$doc[0]['Detalle']."</option>";
                                //selected
                                ?>
                        </select>
          </div>

          <div class="input-box">
            <span class="details">Monto</span>
            <input type="number" placeholder="10.15" name="Monto" step="0.01" required 
            <?php 
            if (isset($doc[0]['Detalle']))
              echo 'value="'.$doc[0]['Monto'].'"'
            ?>
            >
          </div>

          <div class="input-box">
            <span class="details">Fecha desde:</span>
            <input type="date" <?php if (isset($doc[0]['Fecha'])) echo 'value="'.$doc[0]['Fecha'].'"'; ?> name="Fecha">
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