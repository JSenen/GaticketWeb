<?php
include('view_admin.php');
$fecha_actual = date('d-m-Y');
?>
<!-- Tabla agregar nuevo tipo -->
<form action="" method="post">
  <table class="table table-striped table-fixed" id="tableTypesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">GateWay</th>
          <th class="text-warning bg-dark" style="width: 10%">IP</th>
          <th class="text-warning bg-dark" style="width: 10%">Mask</th>
          <th class="text-warning bg-dark" style="width: 10%">CDIR</th>
        </tr>
      </thead>
        <tbody>
          <tr>
            <td><input type="text" name="netGateWay" id="netGateWay"></td>
            <td><input type="text" name="netIp" id="netIp"></td>
            <td><input type="text" name="netMask" id="netMask"></td>
            <td><input type="text" name="netCdir" id="netCdir"></td>
            <td><div class="btn-group" role="group" aria-label="Basic example" id="type-options">
                <button type="submit" class="btn btn-primary" value="sennewip" id="agregar_tipo">Grabar</button>
              </div></td>
          </tr>
      </tbody>
    </table>
  </form>
  <?php
						// Verifica si hay un mensaje almacenado en la variable de sesión
						if (isset($_SESSION['netsave'])) {
							echo '<div id="error-message" class="alert alert-success" role="alert">';
							echo $_SESSION['netsave']; // Muestra el mensaje de error
							echo '</div>';
							unset($_SESSION['netsave']); // Limpia la variable de sesión después de mostrar el mensaje
						}
						?>