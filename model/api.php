<?php


//===================== LISTAR INCIDENCIAS DISPOSITIVOS ==================================
function getDeviceIncidences($deviceId){
    $urllistincidences = BASE_URL.'incidences/device/'.$deviceId;
    $ch = curl_init($urllistincidences);
    curl_setopt($ch, CURLOPT_URL, $urllistincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado de incidencias del usuario
    //Decodificamos json
    $deviceIncidences = json_decode($result, true);
            
    return $deviceIncidences;
}


//================== TODOS LOS USUARIOS ============================================

function getAllUsers(){

    //Listamos los usuarios
    $urlUser = BASE_URL.'users';
    $ch = curl_init($urlUser);
    curl_setopt($ch, CURLOPT_URL, $urlUser);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultusers = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $userlist = json_decode($resultusers, true);

    return $userlist;
}

//================== TODOS LOSDEPARTAMENTOS ============================================

function getAllDepartments(){

    //Listamos los usuarios
    $urlDepart = BASE_URL.'departments';
    $ch = curl_init($urlDepart);
    curl_setopt($ch, CURLOPT_URL, $urlDepart);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultdepart = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $departlist = json_decode($resultdepart, true);

    return $departlist;
}
//=============== AÑADIR DISPOSITIVO ==================================
function recordDeviceAdmin(){
  
 //Comprobamos que session este iniciada
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recopila los datos del formulario en los campos name de la vista
        $deviceHd = strtoupper($_POST['device_hd']);
        $deviceRam = $_POST['device_ram'];
        $deviceSerie = $_POST['device_serial'];
        $deviceMac = $_POST['device_mac'];
        $deviceModel = strtoupper($_POST['device_model']);
        $DateBuy = $_POST['device_dateget'];
        $DateStart = $_POST['device_dad'];
        
        //Convertimos las fechas al formato que admite la API
        // Convierte la fecha al formato "dd/MM/yyyy"
        $deviceDateBuy = date('d/m/Y', strtotime($DateBuy));
        $deviceDateStart = date('d/m/Y', strtotime($DateStart));
        
        $departmentId = $_POST['department_id'];
        $typeId = $_POST['type_id'];

        

        // 1º Grabamos nuevo dispositivo
        // Define los datos que se enviarán a la API
        $deviceData = array(
            "deviceHd" => $deviceHd,
            "deviceRam" => $deviceRam,
            "deviceMac" => $deviceMac,
            "deviceSerial" => $deviceSerie,
            "deviceModel" => $deviceModel,
            "deviceDateBuy" => $deviceDateBuy,
            "deviceDateStart" => $deviceDateStart
        );

        // Realiza una solicitud POST a la API para grabar dispositivo
        $urlsave = BASE_URL.'device';
        $ch = curl_init($urlsave);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($deviceData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        $responseSaveDevice = curl_exec($ch);

        // Realiza una solicitud GET para obtener todos los dispositivos
        $urlGetDevice = BASE_URL . 'device';
            $ch = curl_init($urlGetDevice);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseGetDevice = curl_exec($ch);

        if ($responseGetDevice !== false) {
            // Decodifica la respuesta JSON
            $deviceList = json_decode($responseGetDevice, true);
            
            // Encuentra el último dispositivo en la lista
            $lastDevice = end($deviceList);  
            $newDevice = $lastDevice['deviceId'];

            if (!empty($newDevice)) {
                // Realiza una solicitud POST a la API para grabar dispositivo en el departamento
                $urlsavedepart = BASE_URL . 'department/' . $newDevice . '/' . $departmentId;
                $ch = curl_init($urlsavedepart);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_POST, 1);
                $response = curl_exec($ch);

                if ($response !== false) {
                    // La solicitud se realizó con éxito                     
                    $message = "Dispositivo grabado exitosamente.";
                } else {
                    $message = "Error en la solicitud para grabar al dispositivo en el departamento.";
                }
                
                echo '<p>' . $message . '</p>';
                // Realiza una solicitud POST a la API para grabar tipo al dispositivo
                $urlsavetype = BASE_URL . 'device/' . $newDevice . '/' . $typeId;
                $ch = curl_init($urlsavetype);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_POST, 1);
                $response = curl_exec($ch);

                if ($response !== false) {
                    // La solicitud se realizó con éxito                     
                    $_SESSION['rolchange'] = "Dispositivo grabado.";
                } else {
                    $_SESSION['rolchange'] = "Error en la solicitud para grabar al tipo de dispositivo.";
                }
                
                echo '<meta http-equiv="refresh" content="0.1;url=index.php?controller=admin&action=deviceChanges">'; 
                exit(); 

            } else {
                echo "Error al obtener el ID del nuevo dispositivo.";
            }
        } 
    }
    
}
//=============== AÑADIR NUEVO TIPO =================================
function recordNewType(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // Recopila los datos del nuevo tipo de dispositivo
            $typeName = strtoupper($_POST['typeName']);
            
            // Define los datos que se enviarán a la API
            $typeData = array(
                "typeName" => $typeName,
            );
            // Realiza una solicitud POST a la API para grabar tippo
            $urlsave = BASE_URL.'types';
            $ch = curl_init($urlsave);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($typeData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_exec($ch);

            $_SESSION['typesave'] = "Nuevo tipo grabado"; // Almacena el mensaje en una variable de sesión
            header('Location: index.php?controller=admin&action=typeChanges');

        }
         

}


//=============== BUSCAR TODOS ==================================
function getAllSomeThing($something){
     //Listamos los tipos
     $usrsome = BASE_URL.$something;
     $ch = curl_init($usrsome);
     curl_setopt($ch, CURLOPT_URL, $usrsome);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $usrsome = curl_exec($ch);
     curl_close($ch);
 
     //Recopila los datos 
     $resultlist = json_decode($usrsome, true);
 
     return $resultlist;

}
//============ BUSCAR IPs Y DISPOSITIVO POR IP ======================
function getDeviceIp($ip){
    
    //Listamos la red en totalidad
    $urnet = BASE_URL.'device?ideviceIp='.$ip;
    $ch = curl_init($urnet);
    curl_setopt($ch, CURLOPT_URL, $urnet);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $urnet = curl_exec($ch);
    
    $deviceIp = json_decode($urnet, true);
    curl_close($ch);

    return $deviceIp;
}
// ============ BUSCAR DISPOSITIVO POR ID ===========================
function getDeviceById($id){
    //Listamos los tipos
    $url = BASE_URL.'device/'.$id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $result = json_decode($url, true);

    return $result;

}
// ========== ASIGNAR IP A DISPOSITIVO ============================
function setIpDevice($device){
    //Comprobamos que session este iniciada
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recopila los datos del formulario en los campos name de la vista
        $netId = $_POST['netId'];
        $deviceId = $_POST['deviceId'];

        // Realiza una solicitud POST a la API para grabar tippo
        $urlsave = BASE_URL.'net/'.$netId.'/'.$deviceId;
        $ch = curl_init($urlsave);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($netData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_exec($ch);

        echo '<div class="container">';
        echo '<span>IP asignada</span>';
        echo '</div>';
                      
        header("Refresh: 10; url=index.php?controller=admin&action=deviceChanges.php");

        
}
}




//============ ELIMINAR DISPOSITIVO ====================
function eraseDevice($idDevice){
    $url = BASE_URL . 'device/' . $idDevice; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        $_SESSION['rolchange'] =  "Dispositivo eliminado: ";
        header('Location: index.php?controller=admin&action=deviceChanges');
    }

    curl_close($ch);
}



?>