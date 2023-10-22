<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica si se está realizando una solicitud POST desde el formulario

    // Recopila los datos del formulario
    $userMail = $_POST['userMail'];
    $userPassword = $_POST['userPassword'];
    $userTip = $_POST['userTip'];

    // Define los datos que se enviarán a la API
    $data = array(
        'userMail' => $userMail,
        'userPassword' => $userPassword,
        'userTip' => $userTip
    );

    // Realiza una solicitud POST a la API para crear un nuevo usuario
    $url = 'http://localhost:8080/users';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);

    // Verifica si la solicitud se realizó con éxito
    if ($response !== false) {
        echo "Usuario creado con éxito.".$response;
    } else {
        echo "Error al crear el usuario.";
    }
} else {
    echo "Acceso no permitido.";
}
?>