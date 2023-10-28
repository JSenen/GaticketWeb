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
  </script>
  <!-- Boton actualizar pagina -->
  <div class="container">
    <button type="button" class="btn btn-info" onclick="location.reload()">Actualizar</button>
  </div>
<?php

}
include './view/view_footer.php';
?>