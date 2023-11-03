<?php
include('view_header.php');
$fecha_actual = date('d-m-Y');
?>
<style>
    /* Oculta los submenús por defecto */
.submenu {
    display: none;
}

/* Muestra los submenús cuando se hace clic en la opción "Gestión" */
.nav-item:hover .submenu {
    display: block;
       
}
.submenu li a {
    list-style: none;
    text-decoration: none;
    color: white;
}

</style>

<header id="header">
<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/GaticketAdmin.jpeg"  alt="" width="130" height="130">>
        <li class="nav-item">
            <a class="nav-link" href="#">ADMINISTRADOR</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><?php echo $_SESSION['user_tip'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=admin&action=ticketlist" style="color: yellow;">Tickets</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Gestion</a>
            <ul class="submenu">
                    <li><a href="index.php?controller=admin&action=userChanges">Usuarios</a></li>
                    <li><a href="index.php?controller=admin&action=deviceChanges">Dispositivos</a></li>
                    <li><a href="index.php?controller=admin&action=departmentChanges">Departamentos</a></li>
                    <li><a href="#">Red</a></li>
                </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Salir</a>
        </li>
    </ul>
</nav>
</header>

<!-- Start Page content holder -->
<div class="page-content p-5 text-gray" id="content" style="margin-left: 7%; min-height: 100vh;">

<!-- FORMULARIO AÑADIR DISPOSITIVO -->
<form action="" method="post">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputTip" class="form-label">MODELO</label>
                    <input type="text" class="form-control" name="device_model">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">NUMERO DE SERIE</label>
                    <input type="text" class="form-control" name="device_serial">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">DISCO DURO</label>
                    <input type="number" class="form-control" name="device_hd">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">RAM</label>
                    <input type="number" class="form-control" name="device_ram">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputTip" class="form-label">MAC</label>
                    <input type="text" class="form-control" name="device_mac">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">FECHA ADQUISICION</label>
                    <input type="date" class="form-control" name="device_dateget">
                </div>
                <div class="mb-3">
                    <label for="inputTip" class="form-label">FECHA ADJUDICACION</label>
                    <input type="date" class="form-control" name="device_dad">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <label for="InputDepartment" class="form-label">Departamento</label>
                        <select class="form-select" name="departmentid" id="departmentSelect">
                            <?php
                            // Usar un bucle foreach para generar las opciones
                            foreach ($listdepart as $department) {
                                // Utilizar $department['departmentId'] como el valor y $department['departmentName'] como el texto de la opción
                                echo "<option value='{$department['departemtId']}'>{$department['departmentName']}</option>";
                                
                            }
                            ?>
                        </select>
                </div>
                <div class="col-md-3">
                    <label for="InputType" class="form-label">Tipo</label>
                        <select class="form-select" name="typeId" id="typeSelect">
                            <?php
                            // Usar un bucle foreach para generar las opciones
                            foreach ($listtypes as $type) {
                                // Utilizar $type['type_id'] como el valor y $type['type_type'] como el texto de la opción
                                echo "<option value='{$type['typeId']}'>{$type['typeName']}</option>";
                                
                            }
                            ?>
                        </select>
                </div>  
            </div>
        </div>
        
 <!-- Campos ocultos  -->
  <input type="hidden" name="action" value="sendnewdevice"> 
   <!-- Agrega un campo oculto con el valor de acción para identificar el id del departamento -->
   <input  type="hidden" name="department_id" id="departmentIdField" value="<?php echo $department['departemtId']; ?>">
   <!-- Agrega un campo oculto con el valor de acción para identificar el id del tipo -->
   <input type="hidden" name="type_id" id="typeIdField" value="<?php echo $type['typeId']; ?>">
   <div class="mb-3 mt-3">
        <button type="submit" class="btn btn-danger" name="sendnewdevice" value="sendnewdevice">Grabar</button>
    </div>
                
   
</div>
</form>

<script>
  // JavaScript para actualizar el campo oculto "department_id" y "type_id" cuando se selecciona un departamento
  const departmentSelect = document.getElementById('departmentSelect');
  const departmentIdField = document.getElementById('departmentIdField');
  const typeSelect = document.getElementById('typeSelect');
  const typeIdField = document.getElementById('typeIdField');

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