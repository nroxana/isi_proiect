<?php
session_start();
include("../common.php");

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

