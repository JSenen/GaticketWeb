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
        if ($user['userTip'] == $tip && $user['userPassword'] == $clave) {

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
            $incidenceTheme = $_POST['theme_incidence'];
            $incidenceStatus = false;
            $incidenceDate = $fecha_actual;
            $incidenceDateFinish = "";

             //Recopila datos del usuario grabo ticket
            $userId = $_SESSION['user_id'];
            $userTip = $_SESSION['user_tip'];
            echo $userId;
            // Define los datos que se enviarán a la API
            $data = array(
                'incidenceCommit' => $incidenceCommit,
                'incidenceTheme' => $incidenceTheme,
                'incidenceStatus' =>  $incidenceStatus,
                'incidenceDate' => $incidenceDate,
                'incidenceDateFinish' => $incidenceDateFinish
            );

            // Realiza una solicitud POST a la API para crear un nuevo usuario
            $url = 'http://localhost:8080/incidence/'.$userId;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);

            // Después de procesar la solicitud, redirigir de nuevo a la misma página
            //header('Location: ' . $_SERVER['PHP_SELF']);
            //exit(); // asegura de que el script se detenga aquí
        
                // Verifica si la solicitud se realizó con éxito
                if ($response !== false) {
                    echo "INCIDENCIA AGREGADA.".$response;
                } else {
                    echo "ERROR!!!.";
                }
     } else {
            echo "Acceso no permitido.";
        }
}

?>