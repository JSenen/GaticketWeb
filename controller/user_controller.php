<?php
require_once './model/api.php';
require_once './model/domain/Net.php';
require_once './model/domain/User.php';
require_once './model/domain/Department.php';
require_once './model/domain/Device.php';
require_once './model/domain/Type.php';
require_once './model/domain/Incidence.php';
require_once './model/domain/IncidenceHistory.php';

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

    $searchUserIncidences = new User();
    
    include('./model/model_userincidences.php');
    $userincidences = $searchUserIncidences->getUserIncidences($userId);

    include('./view/view_userincidences.php');
    listUserIncidences($userincidences);
}
?>