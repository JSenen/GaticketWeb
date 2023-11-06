<?php
require_once('./model/api.php'); 
function loginpage()
{ 
  $departmentlist = getAllSomeThing('departments');
  require('./view/view_login.php');
 
}


