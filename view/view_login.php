<?php

include_once('view_header.php');
include_once('./model/api.php');
require_once ('./model/domain/User.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST['action'] === 'login') {
			// Lógica para procesar el formulario de inicio de sesión
			// Llama a la función que deseas ejecutar para el inicio de sesión
            $tip = strtoupper($_POST['usertip']);
            $clave = $_POST['password'];
						$userInstance = new User();
			$userInstance->conection_login($tip,$clave);
	} elseif ($_POST['action'] === 'register') {
			// Lógica para procesar el formulario de registro
			// Llama a la función que deseas ejecutar para el registro
			$userlogin = new User();
			$userlogin->recordUserFromRegister();
	}
}

?>
<section class="section-log">
		<div class="container">
		  <div class="user signinBx">
			<div class="imgBx"><img src="./resources/img/GaticketMan.jpeg" width="60" height="60" alt="" /></div>
			<div class="formBx">
			  <form action="" method="post">
				<h2>Login</h2>
				<input type="hidden" name="action" value="login"> <!-- Agrega un campo oculto con el valor de acción para identificar el formulario -->
					<input type="text" name="usertip" placeholder="TIP" required/>
					<input type="password" name="password" placeholder="Password" required />
					<input type="submit" class="btn btn-primary" value="Login" />
						<!--  Login erroneo. Se comprueba variable de sesion -->
						<?php
						// Verifica si hay un mensaje de error almacenado en la variable de sesión
						if (isset($_SESSION['login_error'])) {
							echo '<div id="error-message" class="alert alert-danger" role="alert">';
							echo $_SESSION['login_error']; // Muestra el mensaje de error
							echo '</div>';
							unset($_SESSION['login_error']); // Limpia la variable de sesión después de mostrar el mensaje
						}
						?>
						<p class="signup">
							¿No dispone de cuenta?
							<a href="#" onclick="toggleForm();">Crear registro.</a>
                        </p>

			  </form>
				
			</div>
		  </div>
			<div class="user signupBx">
			<div class="formBx">
			  <form action="" method="post">
				<h2>Crear cuenta</h2>
				<input type="hidden" name="action" value="register"> <!-- Agrega un campo oculto con el valor de acción para identificar el formulario -->
				<input type="text" name="user_tip" id="TIPInput" placeholder="TIP" class="form-cotrol"/>
							<div id="tipValidation" class="invalid-feedback">
								Por favor, introduzca TIP valida
							</div>

					<label for="InputDepartment" class="form-label">Departamento</label>
						<select class="form-select" name="department_id" id="departmentSelect">
								<?php
								// Usar un bucle foreach para generar las opciones
								foreach ($departmentlist as $department) {
										// Utilizar $department['departmentId'] como el valor y $department['departmentName'] como el texto de la opción
										echo "<option value='{$department['departemtId']}'>{$department['departmentName']}</option>";
										
								}
								?>
						</select>
              
				<input type="text" name="user_mail" id="emailInput" placeholder="Correo electrónico" class="form-control" />
					<div id="emailValidation" class="invalid-feedback">
						Por favor, ingresa un correo electrónico válido.
					</div>
				<input type="password" name="user_password" placeholder="Crear Password" required/>
				<input type="submit" class="btn btn-primary" name="addregister" value="Registrar" />
				<p class="signup">
				  ¿Ya tiene una cuenta ?
				  <a href="#" onclick="toggleForm();">Login.</a>
					
				</p>
			  </form>
			<input type="hidden" name="department_id" id="departmentIdField" value="<?php echo $department['departemtId']; ?>">
			<div id="result"></div> <!-- Pinta el resultado del envio asincrono con AJAX -->
			</div>
			<div class="imgBx bg-black img-fluid"><img src="./resources/img/GaticketRegister.png" class="img-fluid "width="50" height="50" alt="" /></div>
		  </div>
		</div>
</section>
<script>
  // JavaScript para actualizar el campo oculto "department_id" cuando se selecciona un departamento
  const departmentSelect = document.getElementById('departmentSelect');
  const departmentIdField = document.getElementById('departmentIdField');

  departmentSelect.addEventListener('change', () => {
    departmentIdField.value = departmentSelect.value;
  });
</script>
<?php
include('view_footer.php');
?>