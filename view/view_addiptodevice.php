<?php
include('view_admin.php');
$fecha_actual = date('d-m-Y');

?>

<!-- FORMULARIO IP A DISPOSITIVO -->
<form action="" method="post">

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <label for="InputDevice" class="form-label">IP's Libres</label>
                        <select class="form-select" name="netId" id="departmentSelect">
                            <?php
                            // Usar un bucle foreach para generar las opciones
                            foreach ($listIp as $ip) {
                                if (!$ip['netStatus']) {
                                    // Utilizar $ip['netId'] como el valor y $ip['netIp'] como el texto de la opción
                                echo "<option value='{$ip['netId']}'>{$ip['netIp']}</option>";
                                }
                            }
                            ?>
                        </select>
                </div>
               
                    <div class="col-md-3">
                        <div class="container">
                            <label for="SelectedDevice" class="form-label">MODELO</label>
                            <span><?php echo $device['deviceModel'] ?></span>
                        </div>
                        <div class="container">
                            <label for="SelectedDevice" class="form-label">S/N</label>
                            <span><?php echo $device['deviceSerial'] ?></span>
                        </div>
                        <div class="container">
                            <label for="SelectedDevice" class="form-label">TIPO</label>
                            <span><?php echo $device['deviceTypeId']['typeName'] ?></span>
                        </div>
                       
                    </div>
                
            </div>
        </div>
        <script>
document.getElementById('departmentSelect').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var selectedDeviceId = selectedOption.value;
    document.getElementById('selectedDeviceId').textContent = "ID seleccionado: " + selectedDeviceId;
});
</script>

 <!-- Campos ocultos  -->
  <input type="hidden" name="action" value="sendnewdevice"> 
   <!-- Agrega un campo oculto con el valor de acción para identificar el id del dispositivo-->
   <input  type="hidden" name="deviceId" id="departmentIdField" value="<?php echo $device['deviceId']; ?>">
     <!-- Agrega un campo oculto con el valor de acción para identificar el id de de la red --> 
     <input type="hidden" name="net_id" id="typeIdField" value="<?php echo $net['netId']; ?>">
   <div class="mb-3 mt-3">
        <button type="submit" class="btn btn-primary" name="sendnewdevice" value="sendnewdevice">Asignar</button>
    </div>
                
   
</div>
</form>

<script>
  // JavaScript para actualizar el campo oculto "department_id" y "type_id" cuando se selecciona un departamento
  const departmentSelect = document.getElementById('departmentSelect');
  const departmentIdField = document.getElementById('departmentIdField');

  departmentSelect.addEventListener('change', () => {
    departmentIdField.value = departmentSelect.value;
    typeIdField.value = typeSelect.value; // Actualiza también el campo type_id
  });
  typeSelect.addEventListener('change', () => {
    typeIdField.value = typeSelect.value;
  });
 
</script>
<?php
include ('view_footer.php');
?>