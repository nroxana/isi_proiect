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
include("../common.php");

echo displayForm();
function displayForm(){
	$r = '';

	$r .= '<h2>Numar total de ore lucrate la fiecare proiect</h2>';
	
	$r .= '<form method = "post" action = "raport_c.php" name="raport_c">';

    $r .= '</br><label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Incepand cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label style="display: inline-block; width: 150px; text-align: left; margin-left: 20px;">Pana pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	$r .= '<input type="submit" class="btn3 btn-2 btn-2a" name="find" value="Afiseaza" />';

	return $r; 
} 
?>