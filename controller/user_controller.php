<?php
require_once './model/api.php';
require_once './model/domain/Net.php';
require_once './model/domain/User.php';
require_once './model/domain/Department.php';
require_once './model/domain/Device.php';
require_once './model/domain/Type.php';
require_once './model/domain/Incidence.php';
require_once './model/domain/IncidenceHistory.php';
require_once './model/domain/Messages.php';

function firstPage(){
    session_start();
    include('./view/view_user.php');
    $incidenceInstance = new Incidence();
    $incidenceInstance->recordTicket();
}

function listIncidencesUser(){
    
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $userId = $user['userId'];
    $userRol = $_SESSION['user_rol'];
    

    $searchUserIncidences = new User();
    
    include('./model/model_userincidences.php');
    $userincidences = $searchUserIncidences->getUserIncidences($userId);

    include('./view/view_userincidences.php');
    listUserIncidences($userincidences);
}

function viewIncidence($idIncidence){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $userId = $user['userId'];

    //Capturar datos incidencia
    $incidenceCatch = new Incidence();
    $messageGetSet = new Messages();
    $incidenceToSolve = $incidenceCatch->searchIncidence($idIncidence);
    $idAdmin = $incidenceToSolve['incidence']['adminId'];
    //Capturar datos admin incidencia
    $admin = new User();
    $adminData = $admin->getOneUser($idAdmin);
     //Obtener todos los mensajes
    $messageGetSet->adminMessages($idIncidence, $userId);
    
    //Leer todos los mensajes de la incidencia
    $listmessages = $incidenceCatch->getAllMenssagesIncidence($idIncidence);

    include('./view/view_userdetailincidence.php');
}
?>