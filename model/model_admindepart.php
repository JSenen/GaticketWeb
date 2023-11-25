<?php
require_once './model/api.php';

function listDepart($departlist)
{
  ?>
  <style>
  /* ESTILO TABLA DEPARTAMENTOS ADMIN +/
/* Agrega un sombreado a la tabla para dar la apariencia de que sobresale */
#tableDepartAdmin {
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Estilo opcional para resaltar las filas al pasar el ratón */
#tableDepartAdmin tbody tr:hover {
  background-color: #f2f1bf;
}
</style>
  <div class="contenido">
  
    <table class="table table-sm table-striped table-fixed" id="tableDepartAdmin">
      <thead>
        <tr>
          <th class="text-warning bg-dark" style="width: 10%">DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 10%">TELEFONO</th>
          <th class="text-warning bg-dark" style="width: 20%">EMAIL DEPARTAMENTO</th>
          <th class="text-warning bg-dark" style="width: 10%">LOCALIDAD</th>
          <th class="text-warning bg-dark" style="width: 10%">Opciones</th>

        </tr>
      </thead>
      <tbody>
       
<?php 
      if (is_array($departlist) && !empty($departlist)) {
        foreach ($departlist as $depart) {

        
                   
?>
          <tr>
            <td style="vertical-align: middle; font-weight: bold; font-size: 18px;"><?php echo $depart['departmentName'];?></td>
            <td style="vertical-align: middle;"><?php echo $depart['departmentPhone'];?></td>
            <td style="vertical-align: middle;"><?php echo $depart['departmentMail'];?></td>
            <!-- TODO: Añadir total dispositivos y personal del departamento -->
            <td style="vertical-align: middle;"><?php echo $depart['departmentCity'];?></td>
            <td style="vertical-align: middle;"><a href="index.php?controller=admin&action=deleteDepart&id=<?php echo $depart['departemtId']?>" class="btn btn-outline-danger">Borrar</a><a href="index.php?controller=admin&action=updateDepart&id=<?php echo $depart['departemtId']?>" class="btn btn-outline-primary">Actualizar</a></td> 
          </tr>
<?php
        }
        echo "Sin departamentos";
      }
?>
      </tbody>
    </table>

     <!--- MENSAJE EMERGENTE --->
     <div id="rolChangeMessage" class="alert alert-success" style="display: none;">
              <?php
              if (isset($_SESSION['deparsave'])) {
                  echo $_SESSION['deparsave'];
                  unset($_SESSION['deparsave']); // Limpia la variable de sesión después de mostrar el mensaje
              }
              ?>
          </div>
  </div>
      <!-- JQuery table -->
      <script>
    $(document).ready(function () {
      $('#tableDepartAdmin').DataTable({
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
      <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=admin&action=addDepart'" id="agregar_dispositivo">Agregar</button>
    </div>
 
     <!-- Control mensaje emergente -->
 <script>
    $(document).ready(function() {
        // Mostrar el mensaje si está presente
        var rolChangeMessage = $('#rolChangeMessage');
        if (rolChangeMessage.html().trim() !== '') {
            rolChangeMessage.show();

            // Ocultar el mensaje después de 2 segundos (3000 milisegundos)
            setTimeout(function() {
                rolChangeMessage.hide();
            }, 2000); // 3000 ms = 3 segundos
        }
    });
</script>

<?php

}
require_once './view/view_footer.php';
?>