<?php
// include the configs
require_once("config/db.php");
    
// load the login class
require_once("classes/Login.php");
    
// create a login object.
$login = new Login();
    
// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {    
    // the user is logged in...
    include("views/logged_in.php");    
} else {
    // the user is not logged in...
    include("views/not_logged_in.php");
}
?>