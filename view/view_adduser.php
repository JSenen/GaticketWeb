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
                    <li><a href="#">Dispositivos</a></li>
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

<!-- FORMULARIO AÑADIR USUARIO -->
<form action="" method="post">
<div class="container d-flex flex-column justify-content-center align-items-center">
  <div class="mb-3">
    <label for="inputTip" class="form-label">TIP</label>
    <input type="text" class="form-control" name="user_tip" id="userTip">
  </div>
  <div class="mb-3">
    <label for="InputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="user_mail" id="InputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">Email no sera compartido con nadie</div>
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name ="user_password" id="InputPassword1">
  </div>
  <div class="mb-3">
    <label for="InputDepartment" class="form-label">Departamento</label>
    <select class="form-select" name="department_id" id="departmentSelect">
        <?php
        // Usar un bucle foreach para generar las opciones
        foreach ($listdepartment as $department) {
            // Utilizar $department['departmentId'] como el valor y $department['departmentName'] como el texto de la opción
            echo "<option value='{$department['departemtId']}'>{$department['departmentName']}</option>";
            
        }
        ?>
    </select>
    <div class="mb-3">
        <label for="InputPassword1" class="form-label">Rol</label>
        <select class="form-select" name="user_rol" aria-describedby="rolHelp">
            <option value='usuario'>Usuario</option>
            <option value='administrador'>Administrador</option>
        </select>
        <div id="rolHelp" class="form-text">Asignar el rol antes de guardar</div>
  </div>
  </div>
  <input type="hidden" name="action" value="sendnewuser"> <!-- Agrega un campo oculto con el valor de acción para identificar el formulario -->
  <input type="hidden" name="department_id" id="departmentIdField" value="<?php echo $department['departemtId']; ?>">
  <button type="submit" class="btn btn-danger" name="sendnewuser" value="sendnewuser">Grabar</button>

</div>
</form>

<script>
  // JavaScript para actualizar el campo oculto "department_id" cuando se selecciona un departamento
  const departmentSelect = document.getElementById('departmentSelect');
  const departmentIdField = document.getElementById('departmentIdField');

  departmentSelect.addEventListener('change', () => {
    departmentIdField.value = departmentSelect.value;
  });
</script>

<?php
include ('view_footer.php');
?>