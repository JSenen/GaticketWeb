<?php
include('view_admin.php');
$fecha_actual = date('d-m-Y');
?>
<!-- Tabla agregar nuevo tipo -->
<form action="" method="post">
  <table class="table table-striped table-fixed" id="tableTypesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">NUEVO TIPO</th>
        </tr>
      </thead>
        <tbody>
          <tr>
            <td><input type="text" name="typeName" id="newTypeName"></td>
            <td><div class="btn-group" role="group" aria-label="Basic example" id="type-options">
                <button type="submit" class="btn btn-primary" value="sendnewtype" id="agregar_tipo">Agregar</button>
              </div></td>
          </tr>
      </tbody>
    </table>
  </form>
  <?php
						// Verifica si hay un mensaje almacenado en la variable de sesión
						if (isset($_SESSION['typesave'])) {
							echo '<div id="error-message" class="alert alert-success" role="alert">';
							echo $_SESSION['typesave']; // Muestra el mensaje de error
							echo '</div>';
							unset($_SESSION['typesave']); // Limpia la variable de sesión después de mostrar el mensaje
						}
						?>