<!-- Intercambio de datos con la API -->
<?php
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


?>