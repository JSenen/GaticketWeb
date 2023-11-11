<?php
include('view_header.php');
$fecha_actual = date('d-m-Y');
?>
<header id="header">
<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/GaticketLogo_epic.jpg"  alt="" width="130" height="130">>
        <li class="nav-item">
            <a class="nav-link" href="#" style="color: white;">USUARIO</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#" style="color: white;"><?php echo $_SESSION['user_tip'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=user&action=firstPage" style="color: yellow;">Grabar Ticket</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=user&action=listIncidencesUser">Listado</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Salir</a>
        </li>
    </ul>
</nav>
</header>
<!-- Start Page content holder -->
<div class="page-content p-5 text-gray" id="content">
<form action="" method="post">
  <div class="container d-flex justify-content-center align-items-center" style="height: 85vh;">
    <div class="form-container" style="width: 600px;">        
        <div class="form-group text-center">
            <img class="mb-1" src="./resources/img/ticketlogo.jpg" alt="" width="200" height="200">
            <h5>Bienvenido , <?php echo $_SESSION['user_tip'];?></h5>
            <h4><?php echo $fecha_actual ?></h4>
            <h4 class="mb-1">ALTA TICKET DE SOPORTE</h4>
            <div class="form-group">
            <label for="asunto">ASUNTO:</label>
            <input type="text" class="form-control" name="theme_incidence" placeholder="Ingrese asunto" required>
            
        </div>
            <label for="nombre">Descripcion:</label>
            <textarea class="form-control" name="commit_incidence" placeholder="Detalle la incidencia" rows="6" required></textarea>            
        </div>
        <div class="form-group text-justify">
            <p>Facilite nuestro trabajo, y en caso de conocerlo. Seleccione el campo que pueda aportar y rellene los datos.
                Si los desconoce, dejelo en blanco
            </p>
        </div>
        <div class="form-group">
           
        <div class="form-group">
            <select class="form-select" name="typeId" id="typeSelect">
                <option value="deviceNulll" selected>Sin datos</option>
                <option value="deviceSerial">Numero de serie</option>
                <option value="deviceMac">MAC</option>
            </select>
        </div>
        <div class="form-group">
            <label for="IP">Datos:</label>
            <input type="text" class="form-control" name="field_value" placeholder="Ingrese campo seleccionado" id="dataField">
        </div>
        <input type="hidden" name="action" value="sendticket"> <!-- Agrega un campo oculto con el valor de acción para identificar el formulario -->
        <button type="submit" class="btn btn-primary btn-block" name="sendticket" value="sendticket">Enviar</button>
    </div>
</div>
</div>
</form>
<script>
    // Obtener el elemento select y el campo de entrada
    const select = document.getElementById("typeSelect");
    const dataField = document.getElementById("dataField");
    // Agregar un controlador de eventos para detectar cambios en el select
    select.addEventListener("change", function() {
        dataField.setAttribute("name", select.value);
    });
</script>
</div>
</div>
  </body>
</html>
