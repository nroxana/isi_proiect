<?php
require_once("../config/db.php");
session_start();

function addLine() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_insert = $db_connection->query("INSERT INTO timesheet (emp_id, date, hours, project_id, description, extra_hours) 
        VALUES( '" . $_SESSION['user_id'] . "', 
                '" . $_POST['fill_date'] . "', 
                '" . $_POST['fill_interval'] . "', 
                '" . $_POST['fill_project'] . "', 
                '" . $_POST['fill_description'] . "',
                '" . $_POST['fill_extra_interval']. "'
               );
    ");
}

function delLine() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM  timesheet ORDER BY id DESC;");
    if($query_result) {
        $obj = $query_result->fetch_object();
        $db_connection->query("DELETE FROM timesheet WHERE id='". $obj->id ."'");
    }
    
}

if (isset($_POST["add_line_btn"])) {
    addLine();
}

if (isset($_POST["del_line_btn"])) {
    delLine();
}
header('Location: ../views/my_raport.php');
?>