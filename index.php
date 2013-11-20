<?php
// include the configs
require_once("config/db.php");
    
// load the login class
require_once("classes/Login.php");
    
// create a login object.
$login = new Login();
    
if( $login->isUserLoggedIn() )
    header("Location: http://localhost/user_page.php");
else
    include("views/not_logged_in.php");   

?>