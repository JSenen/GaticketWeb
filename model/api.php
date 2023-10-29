<!-- Intercambio de datos con la API -->
<?php
include './resources/config.php';

// =========== COMPROBAR USUARIO ===========================
function conection_login($tip,$clave){                                                  
    $url = BASE_URL.'users';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true); 

     // Buscar el usuario que coincide con el TIP y la clave
     foreach ($data as $user) {
        
        if ($user['userTip'] == $tip ){

            //Verificar si la contraseña ingresada coincide con la alamacenada(hash)
            if (password_verify($clave,$user['userPassword'])){
                session_start(); //Iniciamos sesion del usuario
                $_SESSION['user_id'] = $user['userId'];
                $_SESSION['user_tip'] = $user['userTip']; 
                $_SESSION['user_rol'] = $user['userRol']; 

                var_dump($user);
                
                setcookie('gaticket', '', 86400); //Establecemos una cokkie de 1 dia
                if($user['userRol'] === 'administrador'){
                    // Envio a pagina de administradors
                header('location:index.php?controller=admin&action=ticketlist');
                } else {
                    //Envio a pagina de usuarios
                header('location:index.php?controller=user&action=firstPage'); 
                }

            }
            
        }
        
    }

    echo "El usuario no se encuentra registrado"; //TODO gestionar usuario no encontrado
}

// =========== GRABAR TICKET ================================
function recordTicket(){
    
    //Comprobamos que session este iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

        $fecha_actual = date('d/m/y');

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $incidenceCommit = $_POST['commit_incidence'];
            $incidenceTheme = strtoupper($_POST['theme_incidence']);
            $incidenceStatus = "active";
            $incidenceDate = $fecha_actual;
            $incidenceDateFinish = ""; 
            $deviceSerialNumber = $_POST['device_serialnumber'];
            if (!isset($_POST['device_serialnumber']) || empty($_POST['device_serialnumber'])) {
                $deviceSerialNumber = "SIN DATOS";
            }

            // 1º Buscar  Id device por serial number
            $endpointserial = BASE_URL.'/device?deviceSerial='.$deviceSerialNumber;
            $ch = curl_init($endpointserial);
            curl_setopt($ch, CURLOPT_URL, $endpointserial);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            //Decodificamos Json
            $data = json_decode($result, true);
            // Verificar si se obtuvo una respuesta válida y si el campo "deviceId" está presente
                if (is_array($data) && isset($data['deviceId'])) {
                    // Obtener el valor del deviceId
                    $deviceId = $data['deviceId'];
                } else {
                    echo "No se pudo encontrar el deviceId para el número de serie proporcionado."; //TODO mostrar error a usuario
                }

             //Recopila datos del usuario grabo ticket
            $userId = $_SESSION['user_id'];
            $userTip = $_SESSION['user_tip'];
            
            // Define los datos que se enviarán a la API
            $incidencedata = array(
                'incidenceCommit' => $incidenceCommit,
                'incidenceTheme' => $incidenceTheme,
                'incidenceStatus' =>  $incidenceStatus,
                'incidenceDate' => $incidenceDate,
                'incidenceDateFinish' => $incidenceDateFinish,
                'device' => $deviceId
            );

            // Realiza una solicitud POST a la API para grabar una incidencia
            $url = BASE_URL.'incidence/'.$userId;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($incidencedata));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);

            // Después de procesar la solicitud, redirigir de nuevo a la misma página
            header('Location: index.php?controller=user&action=listIncidencesUser');
            exit(); // asegura de que el script se detenga aquí
        
     } else {
            echo "Acceso no permitido.";
        }
}

//===================== LISTAR INCIDENCIAS USUARIO ==================================
function getUserIncidences($userId){
    
    $urllistincidences = BASE_URL.'incidences/user/'.$userId;
    $ch = curl_init($urllistincidences);
    curl_setopt($ch, CURLOPT_URL, $urllistincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado de incidencias del usuario
    //Decodificamos json
    $userincidences = json_decode($result, true);
            
    return $userincidences;

}

//==================== LISTAR INCIDENCIAS ADMINISTRADOR ===============================

function getAllIncidences(){

    $urladminincidences = BASE_URL.'incidences';
    $ch = curl_init($urladminincidences);
    curl_setopt($ch, CURLOPT_URL, $urladminincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado total de incidencias
    $adminincidences = json_decode($result, true);

    if(is_array($adminincidences) && !empty($adminincidences)){
        return$adminincidences;
    }else{
        return [];
    }
            
    

}

//==================== DATOS USUARIO ==========================================

function getUserDepartment($userid){

    $urlUserDepart = BASE_URL.'department/'.$userid;
    $ch = curl_init($urlUserDepart);
    curl_setopt($ch, CURLOPT_URL, $urlUserDepart);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos del departamento del usuario
    $userdepart = json_decode($result, true);
            
    return $userdepart;

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

// =========== GRABAR NUEVO USUARIO ================================
function recordUserfromAdmin(){
    
    //Comprobamos que session este iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $userTip = $_POST['user_tip'];
            $userMail = $_POST['user_mail'];
            $userPassword = $_POST['user_password'];
            $userRol = $_POST['user_rol'];
            $departmentId = $_POST['department_id'];
            
            // 1º Grabamos nuevo usuario
            // Define los datos que se enviarán a la API
            $userdata = array(
                'userMail' => $userMail,
                'userPassword' =>  $userPassword,
                'userTip' => $userTip,
                'userRol' => $userRol
            );

            // Realiza una solicitud POST a la API para grabar un usuario
            $urlsave = BASE_URL.'users';
            $ch = curl_init($urlsave);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userdata));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            $responseSaveUSer = curl_exec($ch);
            if ($responseSaveUSer === false) {
                echo 'cURL error: ' . curl_error($ch);
            } else {
                var_dump($response);
            }
                $userData = json_decode($responseSaveUSer, true);
                $newUserId = $userData['userId'];

            //Realiza una solicitud POST a la API para grabar un usuario al departamento
            $urlsavedepart = BASE_URL.'user/'.$newUserId.'/'.$departmentId;
            $ch = curl_init($urlsavedepart);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);
            

            // Después de procesar la solicitud, redirigir de nuevo a la misma página
            header('Location: index.php?controller=admin&action=userChanges');
            exit(); // asegura de que el script se detenga aquí
        
        } else {
            echo "Acceso no permitido.";
        }
    }
    

?>

