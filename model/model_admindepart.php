<?php
require_once './model/api.php';

function listDepart($departlist)
{
  ?>
  <div class="contenido">
  
    <table class="table table-striped table-fixed" id="tableDepartAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 10%">TELEFONO</th>
          <th class="text-warning bg-dark" style="width: 20%">EMAIL DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 10%">LOCALIDAD</th>
          <th class="text-warning bg-dark" style="width: 10%">Opciones</th>

        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($departlist) && !empty($departlist)) {
        foreach ($departlist as $depart) {

          // TODO: Numero de incidencias del departamento
          /* $incidencesDevice = getDeviceIncidences($deviceId);
          $numberIncidences = count($incidencesDevice); */
                   
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $depart['departmentName'];?></td>
            <td style="vertical-align: middle;"><?php echo $depart['departmentPhone'];?></td>
            <td style="vertical-align: middle;"><?php echo $depart['departmentMail'];?></td>
            <!-- TODO: Añadir total dispositivos y personal del departamento -->
            <td style="vertical-align: middle;"><?php echo $depart['departmentCity'];?></td>
            <td style="vertical-align: middle;"><a href="#<?php echo $depart['departemtId']?>" class="btn btn-danger">Borrar</a></td> 
          </tr>
<?php
        }
        echo "Sin departamentos";
      }
?>
      </tbody>
    </table>
  </div>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableDepartAdmin').DataTable({
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
  
  <div class="btn-group" role="group" aria-label="Basic example" id="device-options">
    <button type="button" class="btn btn-primary" onclick="window.location.href='#'" id="agregar_dispositivo">Agregar</button>
  </div>
 

<?php

}
include './view/view_footer.php';
?>