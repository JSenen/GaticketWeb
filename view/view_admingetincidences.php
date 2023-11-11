<?php
include('view_header.php');
require_once 'view_admin.php';
$fecha_actual = date('d-m-Y');
?>
 <div class="container mt-5">
        <h1 class="text-center">INCIDENCIA</h1>
        <?php
        // Verificar si $incidenceSearch está definida y no está vacía
        if (isset($incidenceToSolve) && !empty($incidenceToSolve)) {
            ?>
            <table class="table">
                <tr>
                    <th>Asunto</th>
                    <td><?php echo $incidenceToSolve['incidenceTheme']; ?></td>
                </tr>
                <tr>
                    <th>Comentario</th>
                    <td>
                        <textarea class="form-control" rows="4" readonly><?php echo $incidenceToSolve['incidenceCommit']; ?></textarea>
                    </td>
                </tr>
                <?php
                // Verificar si existe información sobre el dispositivo
                if (isset($incidenceToSolve['device']) && !empty($incidenceToSolve['device'])) {
                    ?>
                    <tr>
                <th>Dispositivo</th>
                    <td><?php echo $incidenceToSolve['device']['deviceType']['typeName']; ?></td>
                    <td class="fw-bold">Modelo:</td>
                    <td class="fw-bold">MAC:</td>
                    <td class="fw-bold">S/N:</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo $incidenceToSolve['device']['deviceModel']; ?></td>
                    <td><?php echo $incidenceToSolve['device']['deviceMac']; ?></td>
                    <td><?php echo $incidenceToSolve['device']['deviceSerial']; ?></td>
                </tr>
                    <!-- Puedes agregar más detalles del dispositivo según sea necesario -->
                    <?php
                }

                // Verificar si existe información sobre el usuario
                if (isset($incidenceToSolve['user']) && !empty($incidenceToSolve['user'])) {
                    ?>
                    <tr>
                        <th>Usuario</th>
                        <td><?php echo $incidenceToSolve['user']['userMail']; ?></td>
                    </tr>
                    <!-- Puedes agregar más detalles del usuario según sea necesario -->
                    <?php
                }
                ?>
                <!-- Agregar más campos según sea necesario -->
            </table>
            <?php
        } else {
            echo '<p class="text-center">No se ha proporcionado información de la incidencia.</p>';
        }
        ?>
    </div>

   
</body>
</html>

