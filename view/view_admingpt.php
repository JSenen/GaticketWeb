<?php
include 'view_admin.php';

?>
<!-- Start Page content holder -->
<div class="page-content p-5 text-gray" id="content">
<form action="" method="post">
  <div class="container d-flex justify-content-center align-items-center" style="height: 85vh;">
    <div class="form-container" style="width: 600px;">        
        <div class="form-group text-center">
            <img class="mb-1" src="./resources/img/icon_ia.jpg" alt="" width="200" height="200">
            <h5>Bienvenido , <?php echo $_SESSION['user_tip'];?></h5>
            <h4><?php echo $fecha_actual ?></h4>
            <h4 class="mb-1">CONSULTA A INTELIGENCIA ARTIFICAL</h4>
            <div class="form-group">
                <label for="nombre">Asunto:</label>
                <textarea class="form-control" name="user_query" placeholder="Consulta a relizar..." rows="6" required></textarea>            
            
            <div class="form-group">
           <div>
            <p><?php echo $result ?></p>
           </div>
        
        <input type="hidden" name="action" value="sendrequest"> <!-- Agrega un campo oculto con el valor de acción para identificar el formulario -->
        <button type="submit" class="btn btn-primary btn-block" name="sendquestion" value="sendticket">Enviar</button>
    </div>
</div>
</div>
</form>