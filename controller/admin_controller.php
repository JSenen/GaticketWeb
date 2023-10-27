<?php
require_once './model/api.php';
include './view/view_admin.php';

function ticketlist(){

    session_start();
    $incidences = getAllIncidences();
    include './model/model_adminincidences.php';
    listadminincidences($incidences);
}
?>