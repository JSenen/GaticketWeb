<?php
include('view_header.php');
require_once 'view_admin.php';
require_once './model/api.php';
require_once './model/domain/Incidence.php';
$fecha_actual = date('d-m-Y');
/* 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submitMessage"])) {
        // Procesar el formulario de mensajes
        $messageCommit = $_POST["messageCommit"];
        $messageGetSet->adminMessages($idIncidence, $adminId);
        
    } elseif (isset($_POST["submitSolution"])) {
        // Procesar el formulario de finalizar incidencia
        $solution = $_POST["solution"];
        $incidenceCatch->finsihIncidence($idIncidence,$incidenceToSolve,$solution,$adminTip);
    } 
}*/
?>
<style>
    /* Estilo para el bocadillo de chat */
.chat-bubble {
    background-image: url('./resources/img/chat_icon.png'); 
    background-size: cover;
    width: 70px; /* Ancho de la imagen */
    height: 50px; /* Altura de la imagen */
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
                    <textarea class="form-control col" rows="3" readonly><?php echo $incidenceToSolve['incidence']['incidenceCommit']; ?></textarea>
                </td>
            </tr>
            <?php
            // Verificar si existe información sobre el dispositivo
            if (isset($incidenceToSolve['incidence']['device']) && !empty($incidenceToSolve['incidence']['device'])) {
            ?>
                <tr>
                    <th class="table-success">Dispositivo<img src="./resources/img/computer_icon.png" height="50px" width="70px"></th>
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
            if (isset($incidenceToSolve['incidence']['user']) && !empty($incidenceToSolve['incidence']['user'])) {
            ?>
                <tr>
                    <th class="table-warning">Datos Usuario<img src="./resources/img/User_icon.png" height="50px" width="50px"></th>
                    <td><?php echo $incidenceToSolve['incidence']['user']['userTip']; ?></td>
                    <td class="fw-bold bg-warning">Mail:</td>
                    <td class="fw-bold bg-warning">Departamento:</td>
                    <td class="fw-bold bg-warning">Telefono:</td>
                    <td class="fw-bold bg-warning">Mail Departamento:</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo $incidenceToSolve['incidence']['user']['userMail']; ?></td>
                    <td><?php echo $incidenceToSolve['department']['departmentName']; ?></td>
                    <td><?php echo $incidenceToSolve['department']['departmentPhone']; ?></td>
                    <td><?php echo $incidenceToSolve['department']['departmentMail']; ?></td>
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
                <button type="submit" class="btn btn-danger" name="submitMessage">Enviar</button>
            </div>
    </form>
    <?php
    } else {
        echo '<p class="text-center">No se ha proporcionado información de la incidencia.</p>';
    }
    ?>
</div>
<div class="contenido fs-12">
  
  <table class="table table-sm table-striped table-fixed fs-8" id="tableMessagesAdmin">
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
            
        ?>
    <tr>    
        <td style="vertical-align: middle; font-weight: bold; font-size: 12px;"><?php echo $message['emisorMessage']['userTip'];?></td>
            <td style="vertical-align: middle; font-weight: bold; font-size: 12px;"><?php echo $message['messageCommit'];?></td>
            <td style="vertical-align: middle; font-weight: bold; font-size: 12px;"><?php echo $message['timeMessage'];?></td>
          </tr>
          <?php
        }
          }
          ?>
          </tbody>
    </table>
    <form method="post" action="" class="mt-3">
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-10">
            <textarea class="form-control" rows="2" name="solution" placeholder="Introduzca solución aplicada..."></textarea>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success" name="submitSolution">Finalizar Incidencia</button>
        </div>
    </div>
</div>
        </form>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableMessagesAdmin').DataTable({
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

</body>

</html>