<?php
session_start();

echo addProjectForm();


function addProjectForm()
{	
	$r = '';
	
	$r .= '<form method = "post" action = "addProject.php" name="addProject">';
	
	$r .= '<form action="">';
	$r .= 'Nume proiect: <input type="text" name="numeProiect"><br>';
	$r .= 'Client: <input type="text" name="numeClient"><br/>';
	$r .= 'ID departament: <input type="text" name="idDept"><br/>';
	
	$r .= '<input type="submit" name="submitProject" value="Adauga proiect" >';
	$r .= '</form>';
	return $r;
}

?>