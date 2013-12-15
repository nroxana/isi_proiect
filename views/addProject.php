<?php
require_once("../config/db.php");
session_start();

function addProject() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $adauga_proiect = $db_connection->query("INSERT INTO projects (id, dept_id, name, client) 
		VALUES (
				NULL,
				'" . $_POST['idDept'] . "',
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
    ");*/
}

if (isset($_POST["submitProject"])) {
    addProject();
}
header('Location: ../user_page.php')
?>