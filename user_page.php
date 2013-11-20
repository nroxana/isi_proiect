<?php
session_start();

include("views/common.php");

// redirect users by their types
switch ($_SESSION['tip_angajat']) {
    case 1: 
        include("views/angajat.php");
        break;
    case 2: 
        include("views/sefDivizie.php");
        break;
    case 3: 
        include("views/sefDepartament.php");
        break;
    case 4: 
        include("views/director.php");
        break;
    case 5: 
        include("views/administrator.php");
        break;
}

?>