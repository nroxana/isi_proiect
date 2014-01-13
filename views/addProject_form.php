<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php

session_start();
include("common.php");

echo addProjectForm();


function addProjectForm()
{	
	$r = '';
	
	$r .= '<form method = "post" action = "addProject.php" name="addProject">';
	
	$r .= '<form action="">';
	$r .= '<table style="margin: auto" align="center">';
	$r .= '<tr>';
	$r .= '<td style="text-align: right" align="right">Nume proiect: </td>';
	$r .= '<td style="text-align: left" align="left"><input type="text" name="numeProiect"></td><br>';
	$r .= '</tr>';
	$r .= '<tr>';
	$r .= '<td style="text-align: right" align="center">Client: </td>';
	$r .= '<td style="text-align: left" align="center"><input type="text" name="numeClient"></td><br/>';
	$r .= '</tr>';
	$r .= '</table>';
	$r .= '<section style="background: none;">';
	$r .= '<div style="text-align:center; padding: 15px;">';
	$r .= '<input class="btn3 btn-2 btn-2a" type="submit" name="submitProject" value="Adauga Proiectul" >';

	$r .= '</form>';
	$r .= '</section>';
	$r .= '</div>';
	return $r;
}

?>