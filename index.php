<?php
// include the configs
require_once("config/db.php");
    
// load the login class
require_once("classes/Login.php");
    
// create a login object.
$login = new Login();
    
// ... ask if we are logged in here:
if ($login->isadministratorLoggedIn() == true) {    
    // the user is logged in...
	header("Location: http://localhost/views/administrator.php");
} elseif ($login->isangajatLoggedIn() == true) {
	header("Location: http://localhost/views/angajat.php");
	} elseif ($login->isdirectorLoggedIn() == true) {
		header("Location: http://localhost/views/director.php");
	} elseif ($login->issefDepartamentLoggedIn() == true) {
		header("Location: http://localhost/views/sefDepartament.php");
	} elseif ($login->issefDivizieLoggedIn() == true) {
		header("Location: http://localhost/views/sefDivizie.php");
	} else {
        include("views/not_logged_in.php");
}
?>