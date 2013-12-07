<?php
session_start();
include("common.php");
require_once("../config/db.php");

function displayRaport(){
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM timesheet where emp_id = '" . $_SESSION['user_id']. "';");
        
    $r = '';
    $r .= ' <table id="testTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Data</td>';
    $r .= '         <td width="75" align="center">Ore lucrate</td>';
    $r .= '         <td width="75" align="center">Extra Ore</td>';
    $r .= '         <td width="100" align="center">Nume proiect</td>';
    $r .= '         <td width="450" align="center">Descrierea lucrului</td>';
    $r .= '    </tr>';
    while( $query_result && $timesheet = $query_result->fetch_object() )
    {
        $project_result = $db_connection->query("SELECT name FROM projects where id = '" . $timesheet->project_id . "';");
        $project_name = $project_result->fetch_object();
        $r .= ' <tr>';
        $r .= '     <td align="center">"'. $timesheet->date .'"</td>';
        $r .= '     <td align="center">"'. $timesheet->hours .'"</td>';
        $r .= '     <td align="center">"'. $timesheet->extra_hours .'"</td>';
        $r .= '     <td align="center">"'. $project_name->name .'"</td>';
        $r .= '     <td align="center">"'. $timesheet->description .'"</td>';
        $r .= ' </tr>';
    }
    $r .= '     <tr>';
    $r .= '         <td><input type="date" name="fill_date"></td>';
    $r .= '         <td><input type="number" name="fill_interval"></td>';
    $r .= '         <td><input type="number" name="fill_extra_interval"></td>';
    $r .= '         <td>';
    $r .=               projectSelectField();
    $r .=           '</td>';     
    $r .= '         <td><textarea rows="2" cols="50" name = "fill_description"></textarea></td>';
    $r .= '     </tr>';
    $r .= ' </table>';
    return $r;
}

function projectSelectField() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM projects where dept_id = '" . $_SESSION['dept_id']. "';");
    
    $projects_name = array();    
    $projects_id = array();
    while($obj = $query_result->fetch_object()){ 
        array_push($projects_name, $obj->name);
        array_push($projects_id, $obj->id);
    }
	
    $r = '';
	$r .= '<select name="fill_project">';
	for($i = 0; $i < count($projects_id); $i++) {
        $r .= '<option value="' . $projects_id[$i] . '">' . $projects_name[$i] . '</option>';
	}
	$r .= '</select>';
    return $r;
}
?>
<script src="../javascript/raport_export.js"></script>
<form method="post" action="../classes/timesheet_management.php" name="raportform">
    <table>
        <tr>
            <td width = "800">
                <?php echo displayRaport(); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <input type="button" name="export_btn" value="Exporta" onclick="tableToExcel('testTable')">
                <input type="submit" name="add_line_btn" value="Adauga linia">
                <input type="submit" name="del_line_btn" value="Sterge linia">
                <input type="submit" name="send_btn" value="Trimite spre verificare">
            </td>
        </tr>
    </table>
</form>
 