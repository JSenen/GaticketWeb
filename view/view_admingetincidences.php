<?php
include('view_header.php');
require_once 'view_admin.php';
$fecha_actual = date('d-m-Y');
?>

<div class="container mt-5">
    <h1 class="text-center">INCIDENCIA</h1>

    <?php
    // Verificar si $incidenceToSolve está definida y no está vacía
    if (isset($incidenceToSolve) && !empty($incidenceToSolve)) {
    ?>
        <table class="table">
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
                <!-- Puedes agregar más detalles del dispositivo según sea necesario -->
            <?php
            }

            // Verificar si existe información sobre el usuario
            if (isset($incidenceToSolve['incidence']['user']) && !empty($incidenceToSolve['incidence']['user'])) {
            ?>
                <tr>
                    <th class="table-warning">Datos Usuario</th>
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