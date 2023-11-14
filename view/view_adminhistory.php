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
   

<!-- <script>
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
</script> -->
<!-- Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Detalles de la Incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Usuario:</strong> <span id="modalHistoryUser"></span></p>
                <p><strong>Asunto:</strong> <span id="modalHistoryTheme"></span></p>
                <p><strong>Incidencia:</strong> <span id="modalHistoryIncidence"></span></p>
                <p><strong>Solución:</strong> <span id="modalHistorySolution"></span></p>
                <p><strong>Fecha Solución:</strong> <span id="modalHistoryDateFinish"></span></p>
                <p><strong>Admin:</strong> <span id="modalHistoryAdmin"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tableHistory').DataTable({
            "order": [[4, "desc"]],
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

        // Manejar clic en cualquier fila de la tabla
        $('#tableHistory tbody').on('click', 'tr', function () {
            var rowData = $('#tableHistory').DataTable().row(this).data();

            // Llenar el modal con los datos de la fila
            $('#modalHistoryUser').text(rowData[0]);
            $('#modalHistoryTheme').text(rowData[1]);
            $('#modalHistoryIncidence').text(rowData[2]);
            $('#modalHistorySolution').text(rowData[3]);
            $('#modalHistoryDateFinish').text(rowData[4]);
            $('#modalHistoryAdmin').text(rowData[5]);

            // Mostrar el modal
            $('#historyModal').modal('show');
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