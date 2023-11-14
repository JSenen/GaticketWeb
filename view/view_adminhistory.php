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
         <tr onclick="fillPopup('<?php echo $history['historyTip']; ?>', '<?php echo $history['historyTheme']; ?>', '<?php echo $history['historyCommit']; ?>', '<?php echo $history['historySolution']; ?>', '<?php echo $history['historyDateFinish']; ?>', '<?php echo $history['historyAdmin']; ?>'); openPopup();">
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

<div id="popup" class="popup">
  <span class="close" onclick="closePopup()">&times;</span>
  <h5>Detalles de la Incidencia</h5>
  <p><strong>Usuario:</strong> <span id="popupHistoryUser"></span></p>
  <p><strong>Asunto:</strong> <span id="popupHistoryTheme"></span></p>
  <p><strong>Incidencia:</strong> <span id="popupHistoryIncidence"></span></p>
  <p><strong>Solución:</strong> <span id="popupHistorySolution"></span></p>
  <p><strong>Fecha Solución:</strong> <span id="popupHistoryDateFinish"></span></p>
  <p><strong>Admin:</strong> <span id="popupHistoryAdmin"></span></p>
</div>

<!-- Modal -->
<style>
  /* Estilos del modal */
  .popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #F8F4F3;
    padding: 20px;
    border-radius: 5px;
    z-index: 1001;
    max-width: 400px; /* Ajusta según sea necesario */
    width: 100%;
    text-align: center;
  }

  .close {
    cursor: pointer;
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
  }
</style>
<div id="historyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h5>Detalles de la Incidencia</h5>
        <p><strong>Usuario:</strong> <span id="modalHistoryUser"></span></p>
        <p><strong>Asunto:</strong> <span id="modalHistoryTheme"></span></p>
        <p><strong>Incidencia:</strong> <span id="modalHistoryIncidence"></span></p>
        <p><strong>Solución:</strong> <span id="modalHistorySolution"></span></p>
        <p><strong>Fecha Solución:</strong> <span id="modalHistoryDateFinish"></span></p>
        <p><strong>Administrador:</strong> <span id="modalHistoryAdmin"></span></p>
    </div>
</div>
<script>
  function openPopup() {
    document.getElementById("popup").style.display = "block";
  }

  function closePopup() {
    document.getElementById("popup").style.display = "none";
  }

  // Llenar la ventana emergente con los datos
  function fillPopup(user, theme, incidence, solution, dateFinish, admin) {
    document.getElementById("popupHistoryUser").innerText = user;
    document.getElementById("popupHistoryTheme").innerText = theme;
    document.getElementById("popupHistoryIncidence").innerText = incidence;
    document.getElementById("popupHistorySolution").innerText = solution;
    document.getElementById("popupHistoryDateFinish").innerText = dateFinish;
    document.getElementById("popupHistoryAdmin").innerText = admin;
  }
</script>
<?php
include './view/view_footer.php';
?>