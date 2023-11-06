<?php
class User {
    public long $userId;
    public String $useremail;
    public String $userpassword;
    public String $useryip;
    public String $userrol;

    function __construct() {

    }

    // =========== ELIMINAR USUARIO POR ID =====================

function eraseUser($idUser){
    
    $url = BASE_URL . 'user/' . $idUser; // Agrega "/" para formar la URL completa
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        echo "Solicitud DELETE exitosa. Respuesta del servidor: " . $response;
        header('Location: index.php?controller=admin&action=userChanges');
    }

    curl_close($ch);

}

//======== CHANGE ROL =============
function changeRol($idUser,$rol){

        
    $url = BASE_URL.'user/'.$idUser;

    // Datos que envia en la solicitud PATCH 
    $data = [
        "userRol" => $rol
    ];

    $data_string = json_encode($data);

    // Inicializa una instancia de cURL
    $ch = curl_init($url);

    // Configura la solicitud cURL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Indica que es una solicitud PATCH
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // Define los datos a enviar
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Especifica el tipo de contenido (en este caso, JSON)
    ]);

    // Realiza la solicitud cURL y obtén la respuesta
    $response = curl_exec($ch);

    // Cierra la instancia cURL
    curl_close($ch);

    // Maneja la respuesta 
    if ($response) {
        $_SESSION['rolchange'] = 'Rol modificado con exito ';
        header('location: index.php?controller=admin&action=userChanges');
        
       
    } else {
        $_SESSION['rolchange'] = "Error al realizar la solicitud";
        header('location: index.php?controller=admin&action=userChanges');
    }

}
//================== BUSCAR 1 USUARIO ============================================

function getOneUser($idUser){

    //Listamos los usuarios
    $urlUser = BASE_URL.'users/'.$idUser;
    $ch = curl_init($urlUser);
    curl_setopt($ch, CURLOPT_URL, $urlUser);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultusers = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $userdata = json_decode($resultusers, true);
    return $userdata;
}


}
?>