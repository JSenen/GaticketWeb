<?php
include('view_admin.php');
$fecha_actual = date('d-m-Y');
?>

<!-- FORMULARIO AÑADIR DEPARTAMENTO -->
<form action="" method="post">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputTip" class="form-label">NOMBRE</label>
                    <input type="text" class="form-control" name="departmentName">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">TELÉFONO</label>
                    <input type="text" class="form-control" name="departmentPhone">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">EMAIL</label>
                    <input type="email" class="form-control" name="departmentMail">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">CIUDAD</label>
                    <input type="text" class="form-control" name="departmentCity">
                </div>
            </div>
        </div>
        
 <!-- Campos ocultos  -->
  <input type="hidden" name="action" value="sendnewdevice"> 
   <!-- Agrega un campo oculto con el valor de acción para identificar el id del tipo -->
   <input type="hidden" name="type_id" id="typeIdField" value="<?php echo $type['typeId']; ?>">
   <div class="mb-3 mt-3">
        <button type="submit" class="btn btn-danger" name="sendnewdevice" value="sendnewdevice">Grabar</button>
    </div>
                
   
</div>
</form>

<?php
include ('view_footer.php');
?>