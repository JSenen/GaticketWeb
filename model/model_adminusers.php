<?php
require_once './model/api.php';
require_once './model/domain/User.php';
require_once './model/domain/Department.php';

function listUsers($userlist)
{
  ?>
        <style>
  /* ESTILO TABLA USERS ADMIN +/
/* Agrega un sombreado a la tabla para dar la apariencia de que sobresale */
#tableUsersAdmin {
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Estilo opcional para resaltar las filas al pasar el ratón */
#tableUsersAdmin tbody tr:hover {
  background-color: #f2f1bf;
}
</style>
  <div class="contenido">
  
    <table class="table table-sm table-striped table-fixed" id="tableUsersAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 5%">TIP</th>
          <th class="text-warning bg-dark" style="width: 10%">@</th>
          <th class="text-warning bg-dark" style="width: 10%">DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 10%">CONTACTO</th>
          <th class="text-warning bg-dark" style="width: 10%">@ DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 3%">INCIDENCIAS</th>
          <th class="text-warning bg-dark" style="width: 5%">ROL</th>
          <th class="text-warning bg-dark" style="width: 10%">Seleccionar</th>
        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($userlist) && !empty($userlist)) {
        foreach ($userlist as $user) {

          //Recuperamos los datos del Array Json del usuario
          $userid = $user['userId'];
          $departSearch = new Department();
          $userdepartment = $departSearch->getUserDepartment($userid);
          if (empty($userdepartment)) {
            $userdepartment = [
                'departmentName' => 'Sin datos',
                'departmentPhone' => 'Sin datos',
                'departmentMail' => 'Sin datos'
            ];
          }

          //Numero de incidencias del usuario
          $userincidences = new User();
          $incidencesUser = $userincidences->getUserIncidences($user['userId']);
          $numberIncidences = count($incidencesUser);
                   
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $user['userTip'];?></td>
            <td style="vertical-align: middle;"><?php echo $user['userMail'];?></td>
            <td style="vertical-align: middle;"><?php echo $userdepartment['departmentName'];?></td>
            <td style="vertical-align: middle;"><?php echo $userdepartment['departmentPhone'];?></td>
            <td style="vertical-align: middle;"><?php echo $userdepartment['departmentMail'];?></td>
            <td style="vertical-align: middle;"><?php echo $numberIncidences;?></td>
            <td style="vertical-align: middle;"><?php echo $user['userRol'];?></td> 
            <td style="vertical-align: middle;"><?php
            if ($_SESSION['user_rol'] == 'superusuario'){
              ?><a href="index.php?controller=admin&action=deleteUser&id=<?php echo $user['userId']?>" class="btn btn-outline-danger">Borrar</a><a href="index.php?controller=admin&action=updateUser&id=<?php echo $user['userId']?>" class="btn btn-outline-success">Rol</a></td> <?php } ?>
          </tr>
<?php
        }
      } else {
        echo "Sin usuarios";
      }
?>
      </tbody>
    </table>

    <!--- MENSAJE EMERGENTE --->
          <div id="rolChangeMessage" class="alert alert-success" style="display: none;">
              <?php
              if (isset($_SESSION['rolchange'])) {
                  echo $_SESSION['rolchange'];
                  unset($_SESSION['rolchange']); // Limpia la variable de sesión después de mostrar el mensaje
              }
              ?>
          </div>
  </div>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableUsersAdmin').DataTable({
        "order": [[3, "des"]],
        "language": {
          "lengthMenu": "Mostrar _MENU_ registros por página",
          "zeroRecords": "Sin resultados - lo lamento",
          "info": "Mostrando _PAGE_ de _PAGES_",
          "infoEmpty": "No hay registros disponibles",
          "infoFiltered": "(Filtrando _MAX_ registros totales)",
          "paginate": {
            "next": "Siguiente",
            "previous": "Anterior"
          },
          "search": "Buscar"
        }


      });
    });
  </script>
  <!-- Boton actualizar pagina -->
 
    <button type="button" class="btn btn-info" onclick="location.reload()">Actualizar Página</button>
  
  <div class="btn-group" role="group" aria-label="Basic example" id="user-options">
    <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=admin&action=addUser'" id="agregar-usuario">Agregar</button>
  </div>

 <!-- Control mensaje emergente -->
 <script>
    $(document).ready(function() {
        // Mostrar el mensaje si está presente
        var rolChangeMessage = $('#rolChangeMessage');
        if (rolChangeMessage.html().trim() !== '') {
            rolChangeMessage.show();

            // Ocultar el mensaje después de 3 segundos (3000 milisegundos)
            setTimeout(function() {
                rolChangeMessage.hide();
            }, 3000); // 3000 ms = 3 segundos
        }
    });
</script>

<?php

}
include './view/view_footer.php';
?>