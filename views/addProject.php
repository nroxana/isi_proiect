<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
require_once("../config/db.php");
session_start();
include("../common.php");

echo $_SESSION['dept_id'];
function addProject() {

    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	//$aflaDepartament = $db_connection->query("");
    
    $adauga_proiect = $db_connection->query("INSERT INTO projects (id, dept_id, name, client) 
		VALUES (
				NULL,
				'" . $_SESSION['dept_id'] . "',
				'" . $_POST['numeProiect'] . "',
				'" . $_POST['numeClient'] . "'
				);
	");
    
    /*$query_insert = $db_connection->query("INSERT INTO timesheet (emp_id, date, hours, project_id, description, extra_hours) 
        VALUES( '" . $_SESSION['user_id'] . "', 
                '" . $_POST['fill_date'] . "', 
                '" . $_POST['fill_interval'] . "', 
                '" . $_POST['fill_project'] . "', 
                '" . $_POST['fill_description'] . "',
                '" . $_POST['fill_extra_interval']. "'
               );
    ");
	
	INSERT INTO  `login`.`projects` (`id` ,`dept_id` ,`name` ,`client`)
	VALUES (NULL ,  '3',  'laptop',  'ASUS');*/
}

if (isset($_POST["submitProject"])) {
    echo addProject();
}
header('Location: ../user_page.php')
?>