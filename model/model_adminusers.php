<?php
require_once './model/api.php';

function listUsers($userlist)
{
  ?>
  <div class="contenido">
  
    <table class="table table-striped table-fixed" id="tableIncidencesAdmin">
      <thead>
        <tr>
          <th class="text-info" style="width: 10%">TIP</th>
          <th class="text-info" style="width: 20%">EMAIL</th>
          <th class="text-info" style="width: 10%">DEPARTAMENTO</th>
          <th class="text-info" style="width: 10%">CONTACTO</th>
          <th class="text-info" style="width: 10%">MAIL</th>
          <th class="text-info" style="width: 10%">INCIDENCIAS</th>
          <th class="text-info" style="width: 10%">ROL</th>
          <th class="text-info" style="width: 10%">Seleccionar</th>
        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($userlist) && !empty($userlist)) {
        foreach ($userlist as $user) {

          //Recuperamos los datos del Array Json del usuario
          $userid = $user['userId'];
          $userdepartment = getUserDepartment($userid);
          if (empty($userdepartment)) {
            $userdepartment = [
                'departmentName' => 'Sin datos',
                'departmentPhone' => 'Sin datos',
                'departmentMail' => 'Sin datos'
            ];
          }

          //Numero de incidencias del usuario
          $incidencesUser = getUserIncidences($user['userId']);
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
            <td><input type="checkbox" class="select-checkbox" data-userid="<?php echo $user['userId']; ?>" /></td>       
          </tr>
<?php
        }
      } else {
        echo "Sin usuarios";
      }
?>
      </tbody>
    </table>
  </div>
     
      <!-- JQuery table -->
  <script>
    $(document).ready(function () {
      $('#tableIncidencesAdmin').DataTable({
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
    // ============ EVENTOS CHECK BOX TABLE ======================
    $(document).ready(function() {
    // Maneja el evento de cambio en las casillas de verificación
    $('.select-checkbox').change(function() {
        // Desmarca todas las casillas de verificación
        $('.select-checkbox').prop('checked', false);
        // Marca la casilla de verificación seleccionada
        $(this).prop('checked', true);

        // Obtiene el userId asociado con la fila seleccionada
        var userId = $(this).data('userid');

        // Modifica el atributo 'data-userid' de los botonesModificar y Eliminar para incluir el userId
        $('#modificar-usuario').data('userid', userId);
        $('#eliminar-usuario').data('userid', userId);
    });

    // Maneja el evento de clic en el botón "Modificar"
    $('#modificar-usuario').click(function() {
        // Obtiene el userId del botón "Modificar"
        var userId = $(this).data('userid');
        // Realiza la acción de modificación, por ejemplo, redirige a la página de modificar
        window.location.href = 'index.php?controller=admin&action=modifyUser&userId=' + userId;
    });

    // Maneja el evento de clic en el botón "Eliminar"
    $('#eliminar-usuario').click(function() {
        // Obtiene el userId del botón "Eliminar"
        var userId = $(this).data('userid');
        // Realiza la acción de eliminación, por ejemplo, redirige a la página de eliminar
        window.location.href = 'index.php?controller=admin&action=deleteUser&userId=' + userId;
    });
});
  </script>
  <!-- Boton actualizar pagina -->
 
    <button type="button" class="btn btn-info" onclick="location.reload()">Actualizar Página</button>
  
  
  <label for="user-options" class="user-options-label">Opciones Usuarios</label>
  <div class="btn-group" role="group" aria-label="Basic example" id="user-options">
    <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=admin&action=addUser'" id="agregar-usuario">Agregar</button>
    <button type="button" class="btn btn-success" id="modificar-usuario">Modificar</button>
    <button type="button" class="btn btn-danger" id="eliminar-usuario">Eliminar</button>
  </div>
 



<?php

}
include './view/view_footer.php';
?>