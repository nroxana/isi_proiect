<link rel="stylesheet" type="text/css" href="../../css/style.css" />


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
require_once("../../config/db.php");
include("../common.php");

function showDept() {
	
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$qDept = $db_connection->query("SELECT name FROM projects where dept_id = '" . $_SESSION['dept_id'] . "';");
	
	$r = '';
	$r .= '<h2 style="text-align:center">Afiseaza ce persoane au lucrat la proiectul introdus</h2>';
    $r .= '<div class="component">';
    $r .= ' <table id="deptTable">';
	$r .= '<thead>';
    $r .= '    <tr style="background-color:#ccc;">';
	$r .= '         <th style="text-align:center" width="100" align="center">Nume Proiect</th>';
	$r .= '    </tr>';
	$r .= '</thead>';
	
	while( $qDept && $deptName = $qDept->fetch_object() ) {
		$r .= ' <tr>';
        $r .= '     <td style="text-align:center" align="center">'. $deptName->name	 .'</td>';
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

    $r .= '</br><label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Nume Proiect</label>';
    $r .= '<input type="text" name="prj_name" required /><br>';
    
    $r .= '<label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Incepind cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Pana pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	$r .= '<input type="submit" class="btn3 btn-2 btn-2a" name="find" value="Afiseaza" />';

	return $r; 
} 
?>

