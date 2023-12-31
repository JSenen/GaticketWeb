<?php
require_once './model/api.php';
require_once './model/domain/Device.php';

$typo = new Device();
$urlAddType = BASE_URL.'types';

function listTypes($typelist)
{

  ?>
      <style>
  /* ESTILO TABLA TYPES ADMIN +/
/* Agrega un sombreado a la tabla para dar la apariencia de que sobresale */
#tableTypesAdmin {
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Estilo opcional para resaltar las filas al pasar el ratón */
#tableTypesAdmin tbody tr:hover {
  background-color: #f2f1bf;
}
</style>
  <div class="contenido">
  
    <table class="table table-sm table-striped table-fixed" id="tableTypesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">NOMBRE</th>
          <th class="text-warning bg-dark" style="width: 10%">TOTAL POR TIPO</th>
          <th class="text-warning bg-dark" style="width: 10%">Opciones</th>

        </tr>
      </thead>
      <tbody>
       
<?php 
      if (!isset($typo)) {
        $typo = new Device();
      }
      if (is_array($typelist) && !empty($typelist)) {
        foreach ($typelist as $type) {

          //Totales por tipo
        $typeId = $type['typeId'];
        $devices = $typo->getAllByType($typeId);
        $numberType = count($devices);
       
                   
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $type['typeName'];?></td>
            <td style="vertical-align: middle;"><?php echo $numberType;?></td>
            <td style="vertical-align: middle;"><a href="index.php?controller=admin&action=deleteType&id=<?php echo $type['typeId']?>" class="btn btn-danger">Borrar</a></td> 
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