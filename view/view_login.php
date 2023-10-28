<?php
session_start();
include_once('view_header.php');
include_once('./model/api.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST['action'] === 'login') {
			// Lógica para procesar el formulario de inicio de sesión
			// Llama a la función que deseas ejecutar para el inicio de sesión
            $tip = $_POST['usertip'];
            $clave = $_POST['password'];
			conection_login($tip,$clave);
	} elseif ($_POST['action'] === 'register') {
			// Lógica para procesar el formulario de registro
			// Llama a la función que deseas ejecutar para el registro
			addNewUser();
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
				<input type="text" name="tip" id="TIPInput" placeholder="TIP" class="form-cotrol"/>
							<div id="tipValidation" class="invalid-feedback">
								Por favor, introduzca TIP valida
							</div>

			  <input type="text" name="oficialPhone" placeholder="Telefono Oficial" required/>
				<input type="text" name="unit" placeholder="Unidad" required/>
				<input type="text" name="email" id="emailInput" placeholder="Correo electrónico" class="form-control" />
					<div id="emailValidation" class="invalid-feedback">
						Por favor, ingresa un correo electrónico válido.
					</div>
				<input type="password" name="pass" placeholder="Crear Password" required/>
				<input type="submit" class="btn btn-primary" name="addregister" value="Registrar" />
				<p class="signup">
				  ¿Ya tiene una cuenta ?
				  <a href="#" onclick="toggleForm();">Login.</a>
					<a href="indexTickets.php?controller=login&action=recoverPassword">Recuperar contraseña</a>
				</p>
			  </form>
				
			<div id="result"></div> <!-- Pinta el resultado del envio asincrono con AJAX -->
			</div>
			<div class="imgBx bg-black img-fluid"><img src="./resources/img/GaticketRegister.png" class="img-fluid "width="50" height="50" alt="" /></div>
		  </div>
		</div>
</section>
<?php
include('view_footer.php');
?>