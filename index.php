<?php
require_once 'config/config.php';


// Obtenemos el controlador y la acción. Si no, por defecto
$controller = isset($_GET['controller']) ? $_GET['controller'] : DEFAULT_CONTROLLER;
$action = isset($_GET['action']) ? $_GET['action'] : DEFAULT_ACTION;
$id = isset($_GET['id']) ? $_GET['id'] : "";
 
if (!empty($_GET['action'])){
  $action = $_GET['action'];
}else{
  $action = DEFAULT_ACTION;
}

if (!empty($_GET['controller'])){
  $controller = $_GET['controller'];
}else{
  $controller = DEFAULT_CONTROLLER;
}

//Casos en que se recoge un id
if (!empty($_GET['id'])){
  $id = $_GET['id'];
}else{
  $id = '';
}

//Formacion del fichero que contiene el controlador
$controller = CONTROLLER_FOLDER . $controller . '_controller.php';
//Si la variable controller es un fichero, lo requerimos

if (is_file($controller))
  require_once($controller);
else
  die("El controlador no existe 404 Not found"); //TODO crear pagina 404

//Si action es una función, ejecutamos el script
if (is_callable($action) && !$id ){
  $action();
}elseif (is_callable($action) && $id) {
  $action($id);
} else
die("La accion requerida no existe 404 not found");

?>