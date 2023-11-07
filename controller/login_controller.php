<?php
require_once './model/api.php';
require_once './model/domain/Net.php';
require_once './model/domain/User.php';
require_once './model/domain/Department.php';
require_once './model/domain/Device.php';
require_once './model/domain/Type.php';
require_once './model/domain/Incidence.php';
require_once './model/domain/IncidenceHistory.php';
function loginpage()
{ 
  $departmentlist = getAllSomeThing('departments');
  require('./view/view_login.php');
 
}


