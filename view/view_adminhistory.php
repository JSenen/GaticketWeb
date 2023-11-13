<?php
include('view_header.php');
require_once 'view_admin.php';
require_once './model/api.php';
require_once './model/domain/IncidenceHistory.php';
$fecha_actual = date('d-m-Y');
?>
<div class="contenido">
  
  <table class="table table-sm table-striped table-fixed" id="tableHistory">
    <thead>
      <tr>
        <th class="text-warning bg-dark" style="width: 4%">USUARIO</th>
        <th class="text-warning bg-dark" style="width: 10%">ASUNTO</th>
        <th class="text-warning bg-dark" style="width: 30%">INCIDENCIA</th>
        <th class="text-warning bg-dark" style="width: 30%">SOLUTION</th>
        <th class="text-warning bg-dark" style="width: 4%">FECHA SOLUCION</th>
        <th class="text-warning bg-dark" style="width: 4%">ADMIN</th>        
      </tr>
    </thead>
    <tbody>

<?php 
    if (is_array($listHistory) && !empty($listHistory)) {
      foreach ($listHistory as $history) {
        
?>
        <tr>
          <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $history['historyTip'];?></td>
          <td style="vertical-align: middle;"><?php echo $history['historyTheme'];?></td>
          <td style="vertical-align: middle;"><?php echo $history['historyCommit'];?></td>
          <td style="vertical-align: middle;"><?php echo $history['historySolution'];?></td>
          <td style="vertical-align: middle;"><?php echo $history['historyDateFinish'];?></td>
          <td style="vertical-align: middle;"><?php echo $history['historyAdmin'] ?></td>            
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
    $('#tableHistory').DataTable({
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

include './view/view_footer.php';
?>