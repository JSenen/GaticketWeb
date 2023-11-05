<?php
include('view_admin.php');
$fecha_actual = date('d-m-Y');
?>

<!-- FORMULARIO MODIFICAR DISPOSITIVO -->
<form action="" method="post">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputTip" class="form-label">NOMBRE</label>
                    <input type="text" class="form-control" name="departmentName" value="<?php echo $depart['departmentName']?>">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">TELÉFONO</label>
                    <input type="text" class="form-control" name="departmentPhone" value="<?php echo $depart['departmentPhone']?>">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">EMAIL</label>
                    <input type="email" class="form-control" name="departmentMail" value="<?php echo $depart['departmentMail']?>">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">CIUDAD</label>
                    <input type="text" class="form-control" name="departmentCity" value="<?php echo $depart['departmentCity']?>">
                </div>
            </div>
        </div>
        
 <!-- Campos ocultos  -->
  <input type="hidden" name="action" value="sendnewdevice"> 
   <!-- Agrega un campo oculto con el valor de acción para identificar el id del tipo -->
   <input type="hidden" name="type_id" id="typeIdField" value="<?php echo $type['typeId']; ?>">
   <div class="mb-3 mt-3">
        <button type="submit" class="btn btn-success" name="sendnewdevice" value="sendnewdevice">Actualizar<?php</button>
    </div>
                
   
</div>
</form>

<?php
include ('view_footer.php');
?>