<?php
include('view_header.php');
?>

<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/Gaticket.png"  alt="" width="100" height="100">>
        <li class="nav-item">
        <a class="nav-link" href="#"><?php echo $_SESSION['user_tip'] ?></a>
        </li>
    
        <li class="nav-item">
            <a class="nav-link" href="index.php">Salir</a>
        </li>
    </ul>
</nav>

<form action="" method="post">
  <div class="container d-flex justify-content-center align-items-center" style="height: 85vh;">
    <div class="form-container" style="width: 600px;">        
        <div class="form-group text-center">
            <img class="mb-1" src="./resources/img/ticket.jpeg" alt="" width="200" height="200">
            <h5>Bienvenido , <?php echo $_SESSION['user_tip'];?></h5>
            <h4 class="mb-1">ALTA TICKET DE SOPORTE</h4>
            <div class="form-group">
            <label for="asunto">ASUNTO:</label>
            <input type="text" class="form-control" name="theme_computer" placeholder="Ingrese asunto" required>
            
        </div>
            <label for="nombre">Descripcion:</label>
            <textarea class="form-control" name="description" placeholder="Detalle la incidencia" rows="6" required></textarea>            
        </div>
        <div class="form-group">
            <label for="label">ETIQUETA EQUIPO:</label>
            <input type="text" class="form-control" name="label_computer" placeholder="Ingrese etiqueta del equipo">
        </div>
        <div class="form-group">
            <label for="IP">IP:</label>
            <input type="text" class="form-control" name="ip_computer" placeholder="Ingrese IP del equipo">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Capturas pantalla</label>
            <input type="file" class="form-control" id="exampleFormControlInput1" name="pdfContent">
        </div>
        <input type="hidden" name="action" value="sendticket"> <!-- Agrega un campo oculto con el valor de acción para identificar el formulario -->
        <button type="submit" class="btn btn-primary btn-block" name="sendticket" value="sendticket">Enviar</button>
    </div>
</div>
</form>

<?php
include ('view_footer.php');
?>