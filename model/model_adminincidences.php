<?php
require_once './model/api.php';
require_once './model/domain/Department.php';
/**
 * Funcion que genera la tabla con la totalidad de las incidencias
 * @param array $incidencesList Listado de todas las incidencias
 * @param array $incidence array de una única incidencia con todos los datos
 * @param string $class_td_cell define el tipo de clase para aplicar css
 * @param string $estado estado de la incidencia (Activa, En proceso o Finalizada)
 * @param string $usertip TIP del usuario
 * @param string $userid Numero Id del usuario
 * @param array $departmentUser Datos del departamento del usuario
 * @param string $deviceName modelo del dispositivo
 */
function listadminincidences($incidencesList)
{
  ?>
<style>
  /* ESTILO TABLA INCIENCIAS ADMIN +/
/* Agrega un sombreado a la tabla para dar la apariencia de que sobresale */
#tableIncidencesAdmin {
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Estilo opcional para resaltar las filas al pasar el ratón */
#tableIncidencesAdmin tbody tr:hover {
  background-color: #f2f1bf;
}
</style>
  <div class="contenido">
  
    <table class="table table-sm table-striped table-fixed" id="tableIncidencesAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 30%">ASUNTO</th>
          <th class="text-warning bg-dark" style="width: 4%">DISPOSITIVO</th>
          <th class="text-warning bg-dark" style="width: 2%">USUARIO</th>
          <th class="text-warning bg-dark" style="width: 4%">DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 4%">FECHA EMISION</th>
          <th class="text-warning bg-dark" style="width: 4%">ESTADO</th>        
        </tr>
      </thead>
      <tbody>

<?php 
      if (is_array($incidencesList) && !empty($incidencesList)) {
        foreach ($incidencesList as $incidence) {
          
          //Color del estado segun este activa o resuelto
          if ($incidence['incidenceStatus'] === "active") {
            $class_td_cell = "btn btn-danger btn-sm";
            $estado = "Activa";
          } elseif ($incidence['incidenceStatus'] === "process") {
            $class_td_cell = "btn btn-warning btn-sm";
            $estado = "En proceso";
          } else {
            $class_td_cell = "btn btn-success btn-sm";
            $estado = "Finalizada";
          }
          //Recuperamos los datos del Array Json del usuario
          $usertip = $incidence['user']['userTip'];
          $userid = $incidence['user']['userId'];
          $departUser = new Department();
          $departmentUser = $departUser->getUserDepartment($userid);
         

          // Recuperar el dispositivo de haber sido introducido
          if (isset($incidence['device']['deviceType']['typeName']) && $incidence['device']['deviceType']['typeName'] !== null) {
            $deviceName = $incidence['device']['deviceType']['typeName'];
          } else {
            $deviceName = 'Sin datos';
          }
          
          //Recuperar departamento de haber sido introducido

          
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $incidence['incidenceTheme'];?></td>
            <td style="vertical-align: middle;"><?php echo $deviceName;?></td>
            <td style="vertical-align: middle;"><?php echo $usertip;?></td>
            <td style="vertical-align: middle;"><?php echo $departmentUser['departmentName'];?></td>
            <td style="vertical-align: middle;"><?php echo $incidence['incidenceDate'];?></td>
            <!-- Modificamos color según estado -->
            <td style="vertical-align: middle;"><a class="<?php echo $class_td_cell?>" href="index.php?controller=admin&action=getIncidence&id=<?php echo $incidence['incidencesId']?>"><?php echo $estado ?></a></td>            
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
      $('#tableIncidencesAdmin').DataTable({
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

}
include './view/view_footer.php';
?>