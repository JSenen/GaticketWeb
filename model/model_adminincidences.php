<?php
require_once './model/api.php';

function listadminincidences($incidencesList)
{
  ?>
  <div class="contenido">
  
    <table class="table table-striped table-fixed" id="tableIncidencesAdmin">
      <thead>
        <tr>
          <th class="text-info" style="width: 10%">ASUNTO</th>
          <th class="text-info" style="width: 20%">INCIDENCIA</th>
          <th class="text-info" style="width: 10%">DISPOSITIVO</th>
          <th class="text-info" style="width: 10%">USUARIO</th>
          <th class="text-info" style="width: 10%">DEPARTAMENTO</th>
          <th class="text-info" style="width: 10%">FECHA EMISION</th>
          <th class="text-info" style="width: 7%">ESTADO</th>        
        </tr>
      </thead>
      <tbody>

<?php
        foreach ($incidencesList as $incidence) {
          //Color del estado segun este activo o resuelto
          if ($incidence['incidenceStatus'] == "active") {
            $class_td_cell = "table-danger";
            $estado = "Activa";
          } elseif ($incidence['incidenceStatus'] == "process") {
            $class_td_cell = "table-warning";
            $estado = "En Proceso";
          } else {
            $class_td_cell = "table-success";
            $estado = "Finalizada";
          }
          //Recuperamos los datos del Array Json del usuario
          $usertip = $incidence['user']['userTip'];
          $userid = $incidence['user']['userId'];
          $departmentUser = getUserDepartment($userid);
          
          
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $incidence['incidenceTheme'];?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['incidenceCommit'];?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['device'];?></td>
            <td style="vertical-align: middle;"><?php echo $usertip;?></td>
            <td style="vertical-align: middle;"><?php echo $departmentUser['departmentName'];?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['incidenceDate'];?></td>
            <!-- Modificamos color según estado -->
            <td style="vertical-align: middle;" class="<?php echo $class_td_cell?>"><?php echo $estado ?></td>            
          </tr>
<?php
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
 
<?php
}
include './view/view_footer.php';
?>