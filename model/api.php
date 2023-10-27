<!-- Intercambio de datos con la API -->
<?php
// =========== COMPROBAR USUARIO ===========================
function conection_login($tip,$clave){                                                  
    $url = 'http://localhost:8080/users';
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

        $fecha_actual = date('m/d/Y');

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $incidenceCommit = $_POST['commit_incidence'];
            $incidenceTheme = strtoupper($_POST['theme_incidence']);
            $incidenceStatus = "active";
            $incidenceDate = $fecha_actual;
            $incidenceDateFinish = "";
            $deviceSerialNumber = $_POST['device_serialnumber'];

            // 1º Buscar  Id device por serial number
            $endpointserial = 'http://localhost:8080/device?deviceSerial='.$deviceSerialNumber;
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
                    echo "No se pudo encontrar el deviceId para el número de serie proporcionado.";
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
            $url = 'http://localhost:8080/incidence/'.$userId;
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
    
    $urllistincidences = 'http://localhost:8080/incidences/user/'.$userId;
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

    $urladminincidences = 'http://localhost:8080/incidences';
    $ch = curl_init($urladminincidences);
    curl_setopt($ch, CURLOPT_URL, $urladminincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado total de incidencias
    $adminincidences = json_decode($result, true);
            
    return $adminincidences;

}

//==================== DATOS USUARIO ==========================================

function getUserDepartment($userid){

    $urlUserDepart = 'http://localhost:8080/department/'.$userid;
    $ch = curl_init($urlUserDepart);
    curl_setopt($ch, CURLOPT_URL, $urlUserDepart);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos del departamento del usuario
    $userdepart = json_decode($result, true);
            
    return $userdepart;

}
?>

