<?php
require_once './model/api.php';
require_once './model/domain/Net.php';
require_once './model/domain/User.php';
require_once './model/domain/Department.php';
require_once './model/domain/Device.php';
require_once './model/domain/Type.php';
require_once './model/domain/Incidence.php';
require_once './model/domain/IncidenceHistory.php';

/** Obtener los departamentos en el login y abrir pagina inicial del login
 * @return array $departmentlist Listado de departamentos
 */
function loginpage()
{ 
  $departmentlist = getAllSomeThing('departments');
  require('./view/view_login.php');
 
}


