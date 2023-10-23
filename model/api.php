<!-- LEER DE API -->
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
            echo "El usuario con TIP '$tip' y clave proporcionada existe en la API.";
        }
    }

    echo "No se encontró un usuario con el TIP y la clave proporcionados en la API.";
}


?>