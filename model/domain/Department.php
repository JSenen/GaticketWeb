<?php
class Department {

  public $departemtId;
  public $departmentName;
  public $departmentPhone;
  public $departmentMail;
  public $departmentCity;

  function __construct(){}

  //================ AGREGAR DEPARTAMENTO ===================
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

    //=========== UPDATE DEPARTAMENTO ===============
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
}
?>