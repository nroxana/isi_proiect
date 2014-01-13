<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
session_start();
include("../common.php");
require_once("../../config/db.php");

function showDept() {
	
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$qDept = $db_connection->query("SELECT name FROM projects where dept_id = '" . $_SESSION['dept_id'] . "';");
	
	$r = '';
	$r .= '<h2>Afiseaza ce persoane au lucrat la proiectul introdus</h2>';
    $r .= ' <table id="deptTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
	$r .= '         <td width="100" align="center">Nume Proiect</td>';
	$r .= '    </tr>';
	
	while( $qDept && $deptName = $qDept->fetch_object() ) {
		$r .= ' <tr>';
        $r .= '     <td align="center">'. $deptName->name	 .'</td>';
        $r .= ' </tr>';
	}
	
	$r .= ' <tr></tr></table>';
    echo $r;
}

showDept();
echo displayForm();
function displayForm(){

	$r = '';

	$r .= '<form method = "post" action = "raport_b.php" name="raport_a">';

    $r .= '<label>Nume Proiect</label>';
    $r .= '<input type="text" name="prj_name" required /><br>';
    
    $r .= '<label>Incepind cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label>Pina pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	$r .= '<input type="submit" name="find" value="Afiseaza" />';

	return $r; 
} 
?>

