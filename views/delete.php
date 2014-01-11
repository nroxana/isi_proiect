<?php 
require_once("../config/db.php");
session_start();
include("common.php");

	showUsers();
	showDeleteButton();
	
	function showUsers() {
		$r = '';

		$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$query_result = $db_connection->query("SELECT * from employee where dept_id = '" . $_SESSION['dept_id'] . "' AND id != '". $_SESSION['user_id'] ."';");
		$r = '';
		$r .= ' <table id="showUsers" border="2">';
		$r .= '    <tr style="background-color:#ccc;">';
		$r .= '			<td width="100" align="center">Nume angajat</td>';
		$r .= '         <td width="100" align="center">ID angajat</td>';
		$r .= '    </tr>';
		
		while( $query_result && $interogare=$query_result->fetch_object())
		{
			$r .= ' <tr>';
			$r .= '		<td align="center">'. $interogare->numeprenume . '</td>';
			$r .= '		<td align="center">'. $interogare->id . '</td>';
			$r .= ' </tr>';
		}
		$r .= ' <tr></tr></table>';
		
		echo $r;
	}
	
	function showDeleteButton() {
		
		$r = '';
		$r .= '<form method = "post" action = "deleteUser.php" name="deleteform">';
		$r .= '<label for="login_input_id">Introduceti ID de sters</label>';
		$r .= '<input id="login_input_id" type="text" name="id" required />';
		$r .= '<input type="submit"  name="delete" value="Sterge" />';
		
		echo $r;
	}
	
?>