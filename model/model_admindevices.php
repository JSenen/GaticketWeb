<?php
require_once './model/api.php';

function listDevices($deviceList)
{
  ?>
  <div class="contenido">
  
    <table class="table table-striped table-fixed" id="tableDeviceAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">MODELO</th>
          <th class="text-warning bg-dark" style="width: 10%">TIPO</th>
          <th class="text-warning bg-dark" style="width: 20%">HD</th>
          <th class="text-warning bg-dark" style="width: 10%">RAM</th>
          <th class="text-warning bg-dark" style="width: 10%">MAC</th>
          <th class="text-warning bg-dark" style="width: 10%">S/N</th>
          <th class="text-warning bg-dark" style="width: 10%">FECHA TEIN</th>
          <th class="text-warning bg-dark" style="width: 10%">FECHA DEPART</th>
          <th class="text-warning bg-dark" style="width: 10%">IP</th>
          <th class="text-warning bg-dark" style="width: 10%">INCIDENCIAS</th>
          <th class="text-warning bg-dark" style="width: 10%">Seleccionar</th>
        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($deviceList) && !empty($deviceList)) {
        foreach ($deviceList as $device) {

          //Recuperamos los datos del Array de dispositivos y gestionamos los campos que no haya resultado
          $deviceId = $device['deviceId'];
          $deviceIP = '';
          //Gestion campo IP
          if (!isset($device['net']) || empty($device['net'])) {
            $deviceIP = 'Sin IP';
        } else {
            $deviceIP = $device['net']['netIp'];
        }
          
         // Gestion campo Tipo
         if (empty($device['deviceType'])) {
          $deviceType = 'Sin tipo';
        }else{
          $deviceType = $device['deviceType']['typeName'];
        }
        

         // Gestion campo departamento
          /*  if (empty($userdepartment)) {
            $userdepartment = [
                'departmentName' => 'Sin datos',
                'departmentPhone' => 'Sin datos',
                'departmentMail' => 'Sin datos'
            ];
          } */

          //Numero de incidencias del device
          $incidencesDevice = getDeviceIncidences($deviceId);
          $numberIncidences = count($incidencesDevice);
                   
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $device['deviceModel'];?></td>
            <td style="vertical-align: middle;"><?php echo $deviceType;?></td>
            <td style="vertical-align: middle;"><?php echo $device['deviceHd'];?></td>
            <td style="vertical-align: middle;"><?php echo $device['deviceRam'];?></td>
            <td style="vertical-align: middle;"><?php echo $device['deviceMac'];?></td>
            <td style="vertical-align: middle;"><?php echo $device['deviceSerial'];?></td>
            <td style="vertical-align: middle;"><?php echo $device['deviceDateBuy'];?></td>
            <td style="vertical-align: middle;"><?php echo $device['deviceDateStart'];?></td>
            <td style="vertical-align: middle;"><?php 
                          if ($deviceIP === 'Sin IP') {?>
                            <a href="index.php?controller=admin&action=giveIp&id=<?php echo $device['deviceId'] ?>" class="btn btn-outline-success" value="sennewip" id="agregra_ip">Asignar</a><?php
                          }else { 
                            echo $deviceIP;
                          }?></td>
            <td style="vertical-align: middle;"><?php echo $numberIncidences;?></td>    
            <td style="vertical-align: middle;"><a href="index.php?controller=admin&action=deleteDevice&id=<?php echo $device['deviceId']?>" class="btn btn-danger">Borrar</a></td> 
          </tr>
<?php
        }
        echo "Sin dispositivos";
      }
?>
      </tbody>
    </table>
    <!--- MENSAJE EMERGENTE --->
          <div id="rolChangeMessage" class="alert alert-success" style="display: none;">
              <?php
              if (isset($_SESSION['rolchange'])) {
                  echo $_SESSION['rolchange'];
                  unset($_SESSION['rolchange']); // Limpia la variable de sesión después de mostrar el mensaje
              }
              ?>
          </div>
  </div>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableDeviceAdmin').DataTable({
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
    <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=admin&action=addDevice'" id="agregar_dispositivo">Agregar</button>
  </div>
  
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


<?php

}
include './view/view_footer.php';
?>