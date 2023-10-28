<?php
require_once './model/api.php';


function ticketlist(){

    //Obtner el Id de usuario administrador
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminincidences.php';
    $incidences = getAllIncidences();
    include './view/view_admin.php';
    listadminincidences($incidences);
}
?>