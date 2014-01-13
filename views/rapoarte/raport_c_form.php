<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
session_start();
include("../common.php");

echo displayForm();
function displayForm(){
	$r = '';

	$r .= '<h2>Numar total de ore lucrate la fiecare proiect</h2>';
	
	$r .= '<form method = "post" action = "raport_c.php" name="raport_c">';

    $r .= '<label>Incepand cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label>Pana pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	$r .= '<input type="submit" name="find" value="Afiseaza" />';

	return $r; 
} 
?>