<?php
session_start();
include("../common.php");

echo displayForm();
function displayForm(){
	$r = '';

	$r .= '<form method = "post" action = "raport_d.php" name="raport_d">';
    
    $r .= '<label>Incepind cu </label>';
    $r .= '<input type="date" name="start_date" required /><br>';
    
    $r .= '<label>Pina pe data </label>';
    $r .= '<input type="date" name="end_date" required /><br>';
    
	$r .= '<input type="submit" name="find" value="Afiseaza" />';

	return $r; 
} 
?>

