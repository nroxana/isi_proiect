<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
session_start();
include("../common.php");

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

