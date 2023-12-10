<?php
// Ruta al archivo .env
$envFilePath = __DIR__ . '/.env';

// Verifica si el archivo .env existe
if (file_exists($envFilePath)) {
    // Lee el contenido del archivo .env como un archivo de configuración INI
    $envConfig = parse_ini_file($envFilePath);

       // Itera sobre cada par clave-valor en el archivo de configuración
    foreach ($envConfig as $key => $value) {
        // Establece la variable de entorno
        putenv("$key=$value");
    }
} else {
    die('.env file not found!');
}

/**
 * URL base para la aplicación.
 * @var string
 */
define('BASE_URL','http://localhost:8080/');
/**
 *Obtiene el token para la api key de chatgpt
 *
 * @var string
 */
define('API_KEY',getenv('MY_API_KEY'));
/**
 * Carpeta donde se almacenan los controladores.
 *
 * @var string
 */
define('CONTROLLER_FOLDER', "controller/"); 
/**
 * Controlador por defecto.
 *
 * @var string
 */
define('DEFAULT_CONTROLLER', "login");      
/**
 * Acción por defecto.
 *
 * @var string
 */
define('DEFAULT_ACTION', "loginpage"); 

?>