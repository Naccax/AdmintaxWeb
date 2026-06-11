<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="graficas.php">AdminTax</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          M&oacute;viles
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
          
            echo '<a class="dropdown-item" href="movilesMultasYDeducibles.php">';
            echo 'Multas y deducibles','</a>';
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="moviles.php?plate=',$movil['Id'],'">';
              echo $movil['Matricula'],'</a>';
              $_SESSION["EmpresaID"]=$movil['NumEmpresa'];
            }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Choferes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosChoferes as $chofer)
            {
              echo '<a class="dropdown-item" href="choferes.php?Id=',$chofer['id'],'">';
              echo $chofer['Nombre'],'</a>';
            }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Recaudaciones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="recaudaciones.php?plate=',$movil['Matricula'],'">';
              echo $movil['Matricula'],'</a>';
            }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Reportes de Varela
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="reportesVarela.php?plate=',$movil['Matricula'],'">';
              echo $movil['Matricula'],'</a>';
            }
          ?>
        </div>
      </li>      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Resumen de Empresa
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="resumenFinalDeEmpresa.php">Balance mensual</a>
          <a class="dropdown-item" href="#">Estado General</a>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="vinculos.php">Vínculos<span class="sr-only"></span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Mantenimientos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
            foreach($todosLosMoviles as $movil)
            {
              echo '<a class="dropdown-item" href="movilesMantenimientos.php?plate=',$movil['Matricula'],'">';
              echo $movil['Matricula'],'</a>';
              $_SESSION["EmpresaID"]=$movil['NumEmpresa'];
            }
          ?>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?salir=si"><?php echo"Usuario: " . $_SESSION['usuario'];?><span class="sr-only">(Salir)</span></a>
      </li>
    </ul>
  </div>
</nav>