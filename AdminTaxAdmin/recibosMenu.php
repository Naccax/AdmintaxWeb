<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
  <a class="navbar-brand" href="#">Tipos de Recibos</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="choferesRecibos.php?chofer=<?php echo $_GET['chofer'];?>">Recibos de Sueldo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="choferesRecibosAguinaldos.php?chofer=<?php echo $_GET['chofer'];?>">Aguinaldos por Aportación</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="choferesRecibosAguinaldosReal.php?chofer=<?php echo $_GET['chofer'];?>">Aguinaldo Real</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="choferesVacacionalYLicencias.php?chofer=<?php echo $_GET['chofer'];?>">Vacacional Real</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="choferesRecibosVacacional.php?chofer=<?php echo $_GET['chofer'];?>">Vacacional por Aportación</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#choferesRecibosVacacional.php?chofer=<?php echo $_GET['chofer'];?>">Gestión de Adelantos</a>
      </li>
    </ul>
  </div>
</nav>