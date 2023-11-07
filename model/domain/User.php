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
// =========== COMPROBAR LOGIN ===========================
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
                
                setcookie('gaticket', '', 86400); //Establecemos una cookie de 1 dia
                if($user['userRol'] === 'administrador'){
                    // Envio a pagina de administradors
                header('location:index.php?controller=admin&action=ticketlist');
                } else {
                    //Envio a pagina de usuarios
                header('location:index.php?controller=user&action=firstPage'); 
                }

            }
            
        } else {
            // Login erroneo
    $_SESSION['login_error'] = "LOGIN FALLIDO"; // Almacena el mensaje de error en una variable de sesión
    session_write_close(); // Borramos sesiones anteriores
    header("Refresh: 3; url=index.php");
        }
       
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

// =========== AÑADIR NUEVO USUARIO ================================
function recordUserfromAdmin(){
    
    //Comprobamos que session este iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $userTip = strtoupper($_POST['user_tip']);
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

            // Realiza una solicitud GET para obtener todos los usuarios
            $urlGetUsers = BASE_URL . 'users';
            $ch = curl_init($urlGetUsers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseGetUsers = curl_exec($ch);

            if ($responseGetUsers !== false) {
                // Decodifica la respuesta JSON
                $userList = json_decode($responseGetUsers, true);
                
                // Encuentra el último usuario en la lista
                $lastUser = end($userList);  
                $newUserId = $lastUser['userId'];

                if (!empty($newUserId)) {
                    // Realiza una solicitud POST a la API para grabar un usuario en el departamento
                    $urlsavedepart = BASE_URL . 'user/' . $newUserId . '/' . $departmentId;
                    $ch = curl_init($urlsavedepart);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    $response = curl_exec($ch);

                    if ($response !== false) {
                        // La solicitud se realizó con éxito                     
                        $_SESSION['rolchange'] = "Usuario grabado.";
                    } else {
                        $_SESSION['rolchange'] = "Error en la solicitud para grabar al usuario en el departamento.";
                    }
                    
                    echo '<p>' . $message . '</p>';
                  
                    // Redirecciona después de 3 segundos
                    echo '<meta http-equiv="refresh" content="0.1;url=index.php?controller=admin&action=userChanges">'; 
                    exit();

                } else {
                    echo "Error al obtener el ID del nuevo usuario.";
                }
            }
        }
        
    }

    //=============== AÑADIR USUARIO DESDE REGISTRO ======================
function recordUserFromRegister(){
    
    //Comprobamos que session este iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $userTip = strtoupper($_POST['user_tip']);
            $userMail = $_POST['user_mail'];
            $userPassword = $_POST['user_password'];
            $userRol = 'usuario';
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

            // Realiza una solicitud GET para obtener todos los usuarios
            $urlGetUsers = BASE_URL . 'users';
            $ch = curl_init($urlGetUsers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseGetUsers = curl_exec($ch);

            if ($responseGetUsers !== false) {
                // Decodifica la respuesta JSON
                $userList = json_decode($responseGetUsers, true);
                
                // Encuentra el último usuario en la lista
                $lastUser = end($userList);  
                $newUserId = $lastUser['userId'];

                if (!empty($newUserId)) {
                    // Realiza una solicitud POST a la API para grabar un usuario en el departamento
                    $urlsavedepart = BASE_URL . 'user/' . $newUserId . '/' . $departmentId;
                    $ch = curl_init($urlsavedepart);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    $response = curl_exec($ch);

                    if ($response !== false) {
                        // La solicitud se realizó con éxito                     
                        $_SESSION['login_error'] = "Usuario grabado.";
                    } else {
                        $_SESSION['login_error'] = "Error en la solicitud para grabar al usuario ";
                    }
                    
                    
                  
                    // Redirecciona después de 3 segundos
                    echo '<meta http-equiv="refresh" content="0.1;url=index.php?controller=login&action=loginpage">'; 
                    exit();

                } else {
                    echo "Error al obtener el ID del nuevo usuario.";
                }
            }
        }
        
    }

}
?>