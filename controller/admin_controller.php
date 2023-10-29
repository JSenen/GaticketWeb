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

function userChanges(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminusers.php';
    $userList = getAllUsers();
    include './view/view_admin.php';
    listUsers($userList);
}

function addUser(){

    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    
    //1º Capturar la lista de departamentos
    $listdepartment = getAllDepartments();

    include './view/view_adduser.php';
    recordUserfromAdmin();

}
?>