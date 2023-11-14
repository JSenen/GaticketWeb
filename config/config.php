<?php
define('BASE_URL','http://localhost:8080/');
//Token de la API ChatGPT
define('API_KEY',getenv('MI_API_KEY'));

define('CONTROLLER_FOLDER', "controller/"); //Directorio donde definimos los controladores
define('DEFAULT_CONTROLLER', "login");      //Controlador por defecto
define('DEFAULT_ACTION', "loginpage");      //Accion por defecto
?>