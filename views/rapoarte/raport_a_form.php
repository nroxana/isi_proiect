<head>
    <link href="../../css/global.css" rel="stylesheet" type="text/css">
	<link href="../../css/style.css"     rel="stylesheet" type="text/css">
	
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Raviro</title>
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="../../css/buttons/default.css" />
	<link rel="stylesheet" type="text/css" href="../../css/buttons/component.css" />
	<script src="../../javascript/modernizr.custom.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../../css/tables/normalizeTable.css" />
	<link rel="stylesheet" type="text/css" href="../../css/tables/demoTable.css" />
	<link rel="stylesheet" type="text/css" href="../../css/tables/componentTable.css" />
</head>

<?php
session_start();
include("../common.php");
require_once("../../config/db.php");

function showID() {
	
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$qDept = $db_connection->query("SELECT id FROM employee where dept_id = '" . $_SESSION['dept_id'] . "' AND id != '" . $_SESSION['user_id'] . "';");
	
	$r = '';
	$r = '<h2 style="text-align:center">Afiseaza sumar numar de ore lucrate</h2>';
	$r .= '<div class="component">';
    $r .= ' <table id="idTable">';
	$r .= '<thead>';
    $r .= '    <tr style="background-color:#ccc;">';
	$r .= '         <th style="text-align:center" width="100" align="center">ID angajat</th>';
	$r .= '    </tr>';
	$r .= '</thead>';
	
	while( $qDept && $deptName = $qDept->fetch_object() ) {
		$r .= ' <tr>';
        $r .= '     <td style="text-align:center" align="center">'. $deptName->id	 .'</td>';
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

    $r .= '</br><label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">ID Angajat</label>';
    $r .= '<input type="number" name="emp_id" required /><br>';
    
    $r .= '<label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Incepind cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Pina pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	
	$r .= '<input type="submit" class="btn3 btn-2 btn-2a" name="find" value="Afiseaza" />';

	return $r; 
} 
?>

