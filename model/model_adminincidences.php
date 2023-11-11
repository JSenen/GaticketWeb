<?php
require_once './model/api.php';
require_once './model/domain/Department.php';

function listadminincidences($incidencesList)
{
  ?>
  <div class="contenido">
  
    <table class="table table-sm table-striped table-fixed" id="tableIncidencesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 30%">ASUNTO</th>
          <th class="text-warning bg-dark" style="width: 4%">DISPOSITIVO</th>
          <th class="text-warning bg-dark" style="width: 2%">USUARIO</th>
          <th class="text-warning bg-dark" style="width: 4%">DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 4%">FECHA EMISION</th>
          <th class="text-warning bg-dark" style="width: 4%">ESTADO</th>        
        </tr>
      </thead>
      <tbody>

<?php 
      if (is_array($incidencesList) && !empty($incidencesList)) {
        foreach ($incidencesList as $incidence) {
          
          //Color del estado segun este activa o resuelto
          if ($incidence['incidenceStatus'] == "active") {
            $class_td_cell = "btn btn-danger btn-sm";
            $estado = "Activa";
          } elseif ($incidence['incidenceStatus'] == "process") {
            $class_td_cell = "btn btn-warning btn-sm";
            $estado = "En Proceso";
          } else {
            $class_td_cell = "btn btn-success btn-sm";
            $estado = "Finalizada";
          }
          //Recuperamos los datos del Array Json del usuario
          $usertip = $incidence['user']['userTip'];
          $userid = $incidence['user']['userId'];
          $departUser = new Department();
          $departmentUser = $departUser->getUserDepartment($userid);
         

          // Recuperar el dispositivo de haber sido introducido
          if (isset($incidence['device']['deviceType']['typeName']) && $incidence['device']['deviceType']['typeName'] !== null) {
            $deviceName = $incidence['device']['deviceType']['typeName'];
          } else {
            $deviceName = 'Sin datos';
          }
          
          //Recuperar departamento de haber sido introducido

          
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $incidence['incidenceTheme'];?></td>
            <td style="vertical-align: middle;"><?php echo $deviceName;?></td>
            <td style="vertical-align: middle;"><?php echo $usertip;?></td>
            <td style="vertical-align: middle;"><?php echo $departmentUser['departmentName'];?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['incidenceDate'];?></td>
            <!-- Modificamos color según estado -->
            <td style="vertical-align: middle;"><a class="<?php echo $class_td_cell?>" href="index.php?controller=admin&action=getIncidence&id=<?php echo $incidence['incidencesId']?>"><?php echo $estado ?></a></td>            
          </tr>
<?php
        }
      } else {
        echo "Sin incidencias";
      }
?>
      </tbody>
    </table>
  </div>
     

  <script>
    $(document).ready(function () {
      $('#tableIncidencesAdmin').DataTable({
        "order": [[4, "des"]],
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