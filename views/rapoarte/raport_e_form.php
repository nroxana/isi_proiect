<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
session_start();
include("../common.php");
require_once("../../config/db.php");

echo displayForm();
function displayForm(){
	$r = '';

	$r .= '<form method = "post" action = "raport_e.php" name="raport_e">';
    
    $r .= '<label>Alege Departamentul:</label>';
    $r .= getDepartments();
    
	$r .= '<input type="submit" name="find" value="Afiseaza" />';

	return $r; 
} 

function getDepartments()
{
    $r = '';

    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = $db_connection->query("SELECT division_id from department where id='". $_SESSION['dept_id'] . "';");
    $division_id = $query->fetch_object()->division_id;
    
    $query_result = $db_connection->query("SELECT id, name FROM department where division_id = '". $division_id ."';");    
    $role_ids = array();
    $role_names = array();  
    while($obj = $query_result->fetch_object()){ 
        array_push($role_ids, $obj->id);
        array_push($role_names, $obj->name); 
    }
	
	$r .= '<select name="dept_id">';
	for($i = 0; $i < count($role_ids); $i++) {
        $r .= '<option value="' . $role_ids[$i] . '">' . $role_names[$i] . '</option>';
	}
	$r .= '</select>';
	return $r;
}
?>

