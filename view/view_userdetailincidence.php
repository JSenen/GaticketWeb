<?php
include('view_header.php');
require_once 'view_userincidences.php';
require_once './model/api.php';

$fecha_actual = date('d-m-Y');
?>
<style>
    /* Estilo para el bocadillo de chat */
.chat-bubble {
    background-image: url('./resources/img/chat_icon.png'); /* Reemplaza 'ruta-de-tu-imagen.png' con la ruta correcta de tu imagen */
    background-size: cover;
    width: 100px; /* Ancho de la imagen */
    height: 70px; /* Altura de la imagen */
    margin-right: 10px; /* Margen derecho para separar el bocadillo de la etiqueta */
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Estilo adicional para centrar verticalmente el contenido dentro del bocadillo de chat */
.chat-bubble label {
    margin: 0;
}
</style>
<div class="container mt-5">
    <h3 class="text-center">INCIDENCIA</h3>

    <?php
    // Verificar si $incidenceToSolve está definida y no está vacía
    if (isset($incidenceToSolve) && !empty($incidenceToSolve)) {
    ?>
        <table class="table fs-6">
            <tr>
                <th class="table-primary">Asunto</th>
                <td><?php echo $incidenceToSolve['incidence']['incidenceTheme']; ?></td>
            </tr>
            <tr>
                <th class="table-primary">Comentario</th>
                <td colspan="5">
                    <textarea class="form-control col" rows="4" readonly><?php echo $incidenceToSolve['incidence']['incidenceCommit']; ?></textarea>
                </td>
            </tr>
            <?php
            // Verificar si existe información sobre el dispositivo
            if (isset($incidenceToSolve['incidence']['device']) && !empty($incidenceToSolve['incidence']['device'])) {
            ?>
                <tr>
                    <th class="table-success">Dispositivo</th>
                    <td><?php echo $incidenceToSolve['incidence']['device']['deviceType']['typeName']; ?></td>
                    <td class="fw-bold bg-success text-white">Modelo:</td>
                    <td class="fw-bold bg-success text-white">MAC:</td>
                    <td class="fw-bold bg-success text-white">S/N:</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo $incidenceToSolve['incidence']['device']['deviceModel']; ?></td>
                    <td><?php echo $incidenceToSolve['incidence']['device']['deviceMac']; ?></td>
                    <td><?php echo $incidenceToSolve['incidence']['device']['deviceSerial']; ?></td>
                </tr>
                
            <?php
            }

            // Verificar si existe información sobre el usuario
            if (isset($incidenceToSolve['incidence']['adminId']) && !empty($incidenceToSolve['incidence']['adminId'])) {
               
               
            ?>
                <tr>
                    <th class="table-warning">Datos Administrador</th>
                    <td><?php echo $adminData['userTip']; ?></td>
                </tr>
            <?php
            
        }
            ?>
        </table>
       <!-- Formulario mensajes -->
    <form method="post" action="" class="mt-3">
            <div class="mb-3 d-flex position-relative">
                <!-- Bocadillo de chat con imagen de fondo -->
                <div class="chat-bubble">
                    <label for="mensaje" class="form-label me-2 fw-bold">CHAT</label>
                </div>
                
                <!-- Textarea y botón -->
                <textarea class="form-control me-2" name="messageCommit" rows="2" required></textarea>
                <button type="submit" class="btn btn-danger">Enviar</button>
            </div>
    </form>
    <?php
    } else {
        echo '<p class="text-center">No se ha proporcionado información de la incidencia.</p>';
    }
    ?>
</div>
<div class="contenido fs-12">
  
  <table class="table table-sm table-striped table-fixed fs-8" id="tableMessages">
    <thead>
      <tr>
        <th class="text-warning bg-dark" style="width: 3%">De</th>
        <th class="text-warning bg-dark" style="width: 60%">Mensaje</th>
        <th class="text-warning bg-dark" style="width: 10%">Fecha</th>
      </tr>
    </thead>
    <tbody>
        <?php
        if (is_array($listmessages) && !empty($listmessages)) {
            foreach ($listmessages as $message) {
                $timeMessage = $message['timeMessage'];
                $formattedDate = formatDate($timeMessage);
              
            
        ?>
    <tr>    
        <td style="vertical-align: middle; font-weight: bold; font-size: 12px;"><?php echo $message['emisorMessage']['userTip'];?></td>
            <td style="vertical-align: middle; font-weight: bold; font-size: 12px;"><?php echo $message['messageCommit'];?></td>
            <td style="vertical-align: middle; font-weight: bold; font-size: 12px;"><?php echo $formattedDate;?></td>
          </tr>
          <?php
        }
          }
          ?>
          </tbody>
    </table>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableMessages').DataTable({
        "order": [[2, "des"]],
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
        },
        "rowCallback": function (row, data, index) {
            if (index % 2 === 0) {
                // Aplicar color a las filas pares
                $(row).css('background-color', '#BEEBF9');
            } else {
                // Dejar filas impares sin cambio de color o aplicar otro color
                // $(row).css('background-color', '#ffffff');
            }
        }
    });
});
  </script>
<?php
// Función para formatear la fecha
function formatDate($timeMessage) {
    $dateTime = new DateTime($timeMessage);
    return $dateTime->format('d-m-Y H:i:s');
}
?>
</body>

</html>