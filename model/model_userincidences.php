<?php
include './view/view_header.php';

function listUserIncidences($incidencesList)
{
  ?>
  <div class="contenido">
  
    <table class="table table-sm table-striped table-fixed" id="tableIncidencesUser">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 14%">ASUNTO</th>
          <th class="text-warning bg-dark" style="width: 25%">INCIDENCIA</th>
          <th class="text-warning bg-dark" style="width: 14%">DISPOSITIVO</th>
          <th class="text-warning bg-dark" style="width: 12%">FECHA EMISION</th>
          <th class="text-warning bg-dark" style="width: 7%">ESTADO</th>        
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
?>
          <?php
          
          if(empty($incidence['device']['deviceType']['typeName']) || is_null($incidence['device']['deviceType']['typeName'])){
            $typeName = "Sin Datos";
          }else{
            $typeName = $incidence['device']['deviceType']['typeName'];
          }
          ?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $incidence['incidenceTheme'];?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['incidenceCommit'];?></td>
            <td style="vertical-align: middle;"><?php echo $typeName;?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['incidenceDate'];?></td>
            <!-- Modificamos color según estado -->
            <td style="vertical-align: middle;" class="<?php echo $class_td_cell?>"><?php echo $estado ?></td>            
          </tr>
<?php
        }
?>
      </tbody>
    </table>
    <!--- MENSAJE EMERGENTE --->
    <div id="rolChangeMessage" class="alert alert-success" style="display: none;">
              <?php
              if (isset($_SESSION['savedticket'])) {
                  echo $_SESSION['savedticket'];
                  unset($_SESSION['savedticket']); // Limpia la variable de sesión después de mostrar el mensaje
              }
              ?>
          </div>

     

  <script>
    $(document).ready(function () {
      $('#tableIncidencesUser').DataTable({
        "order": [[3, "desc"]],
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
<!-- Control mensaje emergente -->
<script>
    $(document).ready(function() {
        // Mostrar el mensaje si está presente
        var rolChangeMessage = $('#rolChangeMessage');
        if (rolChangeMessage.html().trim() !== '') {
            rolChangeMessage.show();

            // Ocultar el mensaje después de 3 segundos (3000 milisegundos)
            setTimeout(function() {
                rolChangeMessage.hide();
            }, 3000); // 3000 ms = 3 segundos
        }
    });
</script>
</div>
<?php
}
include './view/view_footer.php';
?>