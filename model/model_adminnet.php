<?php
require_once './model/api.php';
require_once('./resources/config.php');

$urlAddNet = BASE_URL.'net';

function listNet($netlist)
{
  ?>
  <div class="contenido">
  
    <table class="table table-striped table-fixed" id="tableTypesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">GATEWAY</th>
          <th class="text-warning bg-dark" style="width: 10%">MASK</th>
          <th class="text-warning bg-dark" style="width: 10%">CDIR</th>
          <th class="text-warning bg-dark" style="width: 10%">IP</th>
          <th class="text-warning bg-dark" style="width: 10%">ASIGNADO</th>
          <th class="text-warning bg-dark" style="width: 10%">ESTADO</th>
          <th class="text-warning bg-dark" style="width: 10%">ACCION</th>

        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($netlist) && !empty($netlist)) {
        foreach ($netlist as $net) {

          $ip = $net['netIp'];
          if ($net['netStatus']) {
            $device = getDeviceIp($ip);
            
            if (!empty($device)) {
              $model = $device[0]['deviceModel'];
            }else{
              $model = '';
            }
            
          } else {
            $model = '';
          } 
          
            
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $net['netGateWay'];?></td>
            <td style="vertical-align: middle;"><?php echo $net['netMask'];?></td>
            <td style="vertical-align: middle;"><?php echo $net['netCdir'];?></td>
            <td style="vertical-align: middle;"><?php echo $net['netIp'];?></td>
            <td style="vertical-align: middle;"><?php echo $model?></td>
            <td style="vertical-align: middle;"><?php
                    if ($net['netStatus']) {
                        echo '<p class="text-primary">Ocupada</p>';
                    } else {
                        echo '<p class="text-success">Libre</p>';
                    }
            ?></td> 
            <td style="vertical-align: middle;"><?php 
                if ($net['netStatus']) {
                        echo '<a href="index.php?controller=admin&action=freeIp&id='.$net['netId'].'" class="btn btn-danger">Liberar</a></td>';
                    } else {
                        echo '<p class="text-success">--</p>';
                        
                    }?></td>
          </tr>

          
<?php
        }
        
      }
?>
      </tbody>
    </table>
  </div>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableTypesAdmin').DataTable({
        "order": [[1, "des"]],
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

    <div class="btn-group" role="group" aria-label="Agragar IP" id="admin-options">
      <?php unset($_SESSION['netsave']); ?>
      <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=admin&action=addIp'" id="agregar-net">Agregar</button>
    </div>

<?php

}
include './view/view_footer.php';
?>