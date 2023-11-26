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
require_once './model/chatGPT.php';


/** Funcion que administra los tickets de incidencia por parte del administrador
 * @param int $adminId Numero Id del administrador
 * @param array $incidences Listado de las incidencias 
 * @return array listadminincidences($incidences) Listado con todas las incidencias
 */
function ticketlist(){
     //Obtner el Id de usuario administrador
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminincidences.php';
    $incidences = getAllSomeThing('incidences');
    include './view/view_admin.php';
    listadminincidences($incidences);
}
/** Funcion que maneja la resolucion de incidencias y los mensajes
 *  @param int $adminTip TIP del adminsitrador
 *  @param int $adminId ID del administrador
 * @param array  $incidenceToSolve datos completos de incidencia
 * @param string $messageCommit cuerpo del mensaje
 * @param string $solution solucion a la incidencia
 * 
 *  
 */
function getIncidence($idIncidence){
     // Comprobamos que la sesión esté iniciada
     if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $user['userId']= $_SESSION['user_id'];
    $user['userTip'] = $_SESSION['user_tip'];
    $adminId = $user['userId'];
    $adminTip = $user['userTip'];
    $incidenceCatch = new Incidence();
    $messageGetSet = new Messages();
    //Asociar Incidence a admin
    $incidenceCatch->giveIncidenceAdmin($idIncidence,$adminId);
    //Buscar todos los datos de la incidencia y cambiar estado
    $incidenceToSolve = $incidenceCatch->searchIncidence($idIncidence);
    //Obtener todos los mensajes o finalizar
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submitMessage"])) {
            // Procesar el formulario de mensajes
            $messageCommit = $_POST["messageCommit"];
            $messageGetSet->adminMessages($idIncidence, $adminId);
            
        } elseif (isset($_POST["submitSolution"])) {
            // Procesar el formulario de finalizar incidencia
            $solution = $_POST["solution"];
            // Pasa $incidenceToSolve como argumento a finsihIncidence
            $incidenceCatch->finsihIncidence($idIncidence, $incidenceToSolve, $solution,$adminTip);
            
        } 
    }
    //Leer todos los mensajes de la incidencia
    $listmessages = $incidenceCatch->getAllMenssagesIncidence($idIncidence);
    include './view/view_admingetincidences.php';
    

}
/**
 * Gestiona los usuarios por el administrador
 */
function userChanges(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminusers.php';
    $userList = getAllSomeThing('users');
    include './view/view_admin.php';
    listUsers($userList);
}
/**
 * Añadir un nuevo usuario desde el administrados
 */
function addUser(){

    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    
    //1º Capturar la lista de departamentos
    $listdepartment = getAllSomeThing('departments');
    $userInstance = new User();
    //Mostrar formulario añadir usuarios
    include './view/view_adduser.php';
    $userInstance->recordUserfromAdmin();

}
/**
 * Añadir un nuevo tipo de dispositivo desde el adminstrador
 */
function addType(){

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    $typeAdd = new Type();
    //Mostrar formulario añadir nuevo tipo dispositivo
    include './view/view_addtype.php';
    $typeAdd->recordNewType();

}
/**
 * Añadir un nuevo dispositivo desde el administrador
 */
function addDevice(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    
    $deviceSearch = new Device();
    //1º Capturar la lista de tipos
    $url = 'types';
    $listtypes = getAllSomeThing($url);
    //2º Capturar IP disponibles
    $urlty = 'net';
    $listip = getAllSomeThing($urlty);
    //3º Departamento
    $urldep = 'departments';
    $listdepart = getAllSomeThing($urldep);
    //Mostrar formulario añadir dispositivo
    include './view/view_adddevice.php';
    $deviceSearch->recordDeviceAdmin();


}
/**
 * Elimninar un dispositivo
 */
function deleteDevice($idDevice){
    session_start();
    $user['userId'] = $_SESSION['user_id'];
    $adminId = $user['userId'];
    $deviceSearch = new Device();
    // Obtener usuario seleccionado
    $deviceSearch->eraseDevice($idDevice); // Pasar $iduser como argumento

}

/**
 * Eliminar un usuario
 */
function deleteUser($iduser) {
    session_start();
    $user['userId'] = $_SESSION['user_id'];
    $adminId = $user['userId'];

    // Obtener usuario seleccionado
    $userInstance = new User();
    $userInstance->eraseUser($iduser); // Pasar $iduser como argumento
}

/** Actualizar los datos de un dispositivo */
function deviceChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    $deviceList = getAllSomeThing("device");
    include './model/model_admindevices.php';
    include './view/view_admin.php';
    listDevices($deviceList);

}
/**
 * Añadir un nuevo departamento
 */
function addDepart(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   

    include './view/view_adddepart.php';
    $departmentInstance = new Department();
    $departmentInstance->recordNewDepart();
    
}
/**
 * Actualizar un departamento
 */
function departmentChanges(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_admindepart.php';
    $departlist = getAllSomeThing('departments');
    include './view/view_admin.php';
    listDepart($departlist);
    
}
/**
 * Administrar los tipos de dispositivos
 */
function typeChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    
    include './model/model_admintypes.php';
    $typelist = getAllSomeThing('types');
    include './view/view_admin.php';
    listTypes($typelist);
    
}
/**
 * Eliminar un tipo de dispositivo
 */
function deleteType($id){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  
    $typeToErase = new Type();
   $typeToErase->eraseType($id);
}
/**
 * Administrar la red
 */
function netChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    
    include './model/model_adminnet.php';
    $netlist = getAllSomeThing('net');
    include './view/view_admin.php';
    listNet($netlist);
}
/** Liberar una IP */
function freeIp($idNet){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  
    $netInstance = new Net();
    $netInstance->eraseIp($idNet);
}
/**
 * Agregar una nueva IP
 */
function addIp(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    $netInstance = new Net();
    //Mostrar formulario añadir nuevo tipo dispositivo
    include './view/view_addip.php';
    $netInstance->recordNewIp();

}
/** Asignar una IP a un dispositivo */

function giveIp($deviceId){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    $IpToAdd = new Net();
    //Obtener todas las Ip
    $deviceSearch = new Device();
    $device = $deviceSearch->getDeviceById($deviceId);
    $listIp = getAllSomeThing('net');
    include './view/view_addiptodevice.php';
    $IpToAdd->setIpDevice($device);
    
}
/** 
 * Eliminar un departamento
 */
function deleteDepart($id){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  
    $departmentInstance = new Department();
    $departmentInstance->eraseDepart($id);
}
/** Actualizar un departamento */
function updateDepart($idDepart){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  

    $url = 'departments/'.$idDepart;
    $depart = getAllSomeThing($url);
    include './view/view_updatedepart.php';
    $departInstance = new Department();
    $departInstance->changeDepart($idDepart);
    header('Location: index.php?controller=admin&action=departmentChanges');
}
//======== UPDATE USER ================
function updateUser($idUser){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  

    $userInstance = new User();
    //Buscamos el usuario
    $userdata = $userInstance->getOneUser($idUser);
    $rol = $userdata['userRol'];
    
    //Segun el tipo de rol, le pasamos el contrario
    if($rol == 'usuario') {
        $rol = 'administrador';
    }else{
        $rol = 'usuario';
    }
    //Cambiamos el rol
    
    $userInstance->changeRol($idUser,$rol);
   
}   

/**
 * Acceso a la página de historial de incidencias
 * @param array $listHistory listado de incidencias archivadas
 */
function historyList(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $incidencesHsitory = new IncidenceHistory();
    $listHistory = $incidencesHsitory->getAllHistory();
    include './view/view_adminhistory.php';
    }
}
/**
 * Acceso a la página de chat con la inteligencia artifical
 */
function startChatGpt() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();

        $result = ''; // Inicializa $result antes del bloque condicional

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_query = $_POST["user_query"];
            $result = talkChatGpt($user_query);
        }

        include './view/view_admingpt.php';
    }
}


?>

