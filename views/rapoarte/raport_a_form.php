<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
session_start();
include("../common.php");
require_once("../../config/db.php");

function showID() {
	
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$qDept = $db_connection->query("SELECT id FROM employee where dept_id = '" . $_SESSION['dept_id'] . "' AND id != '" . $_SESSION['user_id'] . "';");
	
	$r = '';
	$r = '<h2>Afiseaza sumar numar de ore lucrate</h2>';
    $r .= ' <table id="idTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
	$r .= '         <td width="100" align="center">ID angajat</td>';
	$r .= '    </tr>';
	
	while( $qDept && $deptName = $qDept->fetch_object() ) {
		$r .= ' <tr>';
        $r .= '     <td align="center">'. $deptName->id	 .'</td>';
        $r .= ' </tr>';
	}
	
	$r .= ' <tr></tr></table>';
    echo $r;
}

showID();
echo displayForm();

function displayForm(){
	$r = '';
	
	
	$r .= '<form method = "post" action = "raport_a.php" name="raport_a">';

    $r .= '<label>ID Angajat</label>';
    $r .= '<input type="number" name="emp_id" required /><br>';
    
    $r .= '<label>Incepind cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label>Pina pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	$r .= '<input type="submit" name="find" value="Afiseaza" />';

	return $r; 
} 
?>

