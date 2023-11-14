<?php
/**
 * Clase Department. Contiene los atributos y metodos relacionados con la entidad Departamentos
 */
class Department {

  public $departemtId;
  public $departmentName;
  public $departmentPhone;
  public $departmentMail;
  public $departmentCity;

  function __construct(){}

/**
 * Grabar un nuevo ticket de incidencia 
 */
function recordNewDepart(){
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
          
          // Recopila los datos del nuevo tipo de departamento
          $departName = strtoupper($_POST['departmentName']);
          $departPhone = $_POST['departmentPhone'];
          $departMail = $_POST['departmentMail'];
          $departCity = $_POST['departmentCity'];
          // Define los datos que se enviarán a la API
          $departData = array(
              "departmentName" => $departName,
              "departmentPhone" => $departPhone,
              "departmentMail" => $departMail,
              "departmentCity" => $departCity
          );
          // Realiza una solicitud POST a la API para grabar departamento
          $urlsave = BASE_URL.'departments';
          $ch = curl_init($urlsave);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($departData));
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_exec($ch);

          $_SESSION['deparsave'] = "Nuevo departamento grabado"; // Almacena el mensaje en una variable de sesión
          header('Location: index.php?controller=admin&action=departmentChanges');

      }
       
    }
    /**
     * Eliminar un departamento
     * 
     * @param tipo $idDepart Número ID del departamento
     */

          //===================== ELIMINAR DEPARTAMENTO ==================
    function eraseDepart($idDepart){
      $url = BASE_URL . 'departments/' . $idDepart; 
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);

      if ($response === false) {
          echo "Error de cURL: " . curl_error($ch);
      } else {
          echo "Solicitud DELETE exitosa. Respuesta del servidor: " . $response;
          header('Location: index.php?controller=admin&action=departmentChanges');
      }

      curl_close($ch);
    }

 /**
  * Actualizar un departamento
  * @param tipo $idDepart Número ID del departamento
  */
function changeDepart($idDepart){

  if (session_status() == PHP_SESSION_NONE) {
         session_start();
     }
     
         if ($_SERVER["REQUEST_METHOD"] === "POST") {
             
             // Recopila los datos del nuevo tipo de dispositivo
             $departName = strtoupper($_POST['departmentName']);
             $departPhone = $_POST['departmentPhone'];
             $departMail = $_POST['departmentMail'];
             $departCity = $_POST['departmentCity'];
             // Define los datos que se enviarán a la API
             $departData = array(
                 "departmentName" => $departName,
                 "departmentPhone" => $departPhone,
                 "departmentMail" => $departMail,
                 "departmentCity" => $departCity
             );
             // Realiza una solicitud POST a la API para grabar departamento
             $urlupdate = BASE_URL.'departments/'.$idDepart;
             $ch = curl_init($urlupdate);
             // Configurar cURL para una solicitud PUT
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
             // Codificar los datos como JSON
             $data_json = json_encode($departData);
             // Establecer el cuerpo de la solicitud con los datos JSON
             curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
             // Configurar las cabeceras adecuadas
             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
             // Ejecutar la solicitud PUT
             $response = curl_exec($ch);
             // Cerrar la sesión cURL
             curl_close($ch);
 
             $_SESSION['deparsave'] = "Nuevo departamento grabado"; // Almacena el mensaje en una variable de sesión
             
 
         }         
 }

 /**
  * Obtener el departamento en el que se encuentra un usuario
  * @param tipo $userId Numero ID del usuario 
  */

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

}
?>
