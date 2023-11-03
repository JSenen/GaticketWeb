<?php
require_once './model/api.php';
require_once('./resources/config.php');

$urlAddType = BASE_URL.'types';

function listTypes($typelist)
{
  ?>
  <div class="contenido">
  
    <table class="table table-striped table-fixed" id="tableTypesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">NOMBRE</th>
          <th class="text-warning bg-dark" style="width: 10%">TOTAL</th>
          <th class="text-warning bg-dark" style="width: 10%">Opciones</th>

        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($typelist) && !empty($typelist)) {
        foreach ($typelist as $type) {
                   
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $type['typeName'];?></td>
            <td style="vertical-align: middle;"><?php echo 'POR HACER';?></td>
            <td style="vertical-align: middle;"><a href="#<?php echo $type['typeId']?>" class="btn btn-danger">Borrar</a></td> 
          </tr>

          
<?php
        }
        echo "Sin tipos de dispositivos";
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

    <div class="btn-group" role="group" aria-label="Basic example" id="admin-options">
      <?php unset($_SESSION['typesave']); ?>
      <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=admin&action=addType'" id="agregar-type">Agregar</button>
    </div>

<?php

}
include './view/view_footer.php';
?>