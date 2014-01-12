<?php
session_start();
include("common.php");
require_once("../config/db.php");

function displayRaport(){
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM timesheet_info 
        WHERE emp_id= '". $_SESSION['user_id'] ."' ORDER BY id DESC LIMIT 1;");
    $tm_info = $query_result->fetch_object();
    $first = $tm_info->year . "-" . $tm_info->month . "-" . 1;
    $second = $tm_info->year . "-" . ($tm_info->month + 1) . "-" . 1;
    
    $query_result = $db_connection->query("SELECT * FROM timesheet where emp_id = '" . $_SESSION['user_id']. "' and date between '".$first."' and '".$second."';");
        
    $r = '';
    $r .= ' <table id="testTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Data</td>';
    $r .= '         <td width="75" align="center">Ore lucrate</td>';
    $r .= '         <td width="75" align="center">Extra Ore</td>';
    $r .= '         <td width="100" align="center">Nume proiect</td>';
    $r .= '         <td width="350" align="center">Descrierea lucrului</td>';
    $r .= '    </tr>';
    while( $query_result && $timesheet = $query_result->fetch_object() )
    {
        $project_result = $db_connection->query("SELECT name FROM projects where id = '" . $timesheet->project_id . "';");
        $project_name = $project_result->fetch_object();
        $r .= ' <tr>';
        $r .= '     <td align="center">'. $timesheet->date .'</td>';
        $r .= '     <td align="center">'. $timesheet->hours .'</td>';
        $r .= '     <td align="center">'. $timesheet->extra_hours .'</td>';
        $r .= '     <td align="center">'. $project_name->name .'</td>';
        $r .= '     <td align="center">'. $timesheet->description .'</td>';
        $r .= ' </tr>';
    }
    if( $tm_info->state == "OPEN" || $tm_info->state == "REJECT" )
    {
        $r .= '     <tr>';
        $r .= '         <td><input type="date" name="fill_date"></td>';
        $r .= '         <td><input type="number" name="fill_interval"></td>';
        $r .= '         <td><input type="number" name="fill_extra_interval"></td>';
        $r .= '         <td>';
        $r .=               projectSelectField();
        $r .= '         </td>';
        $r .= '         <td>';
        $r .=               selectActivity();
        $r .= '             <textarea rows="2" cols="50" name = "fill_description"></textarea>';
        $r .= '         </td>';
        $r .= '     </tr>';
    }
    $r .= ' </table>';
    return $r;
}

function selectActivity()
{
    $r = '';
	$r .= '<select style="float:left;" name="fill_activity">';
    $r .=   '<option value=" "></option>';
    $r .=   '<option value="lucru din sediu : ">lucru din sediu</option>';
    $r .=   '<option value="deplasare la client : ">deplasare la client</option>';
    $r .=   '<option value="sedinte : ">sedinte</option>';
    $r .=   '<option value="cursuri : ">cursuri</option>';
    $r .= '</select>';
    return $r;
}

function projectSelectField() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM projects where dept_id = '" . $_SESSION['dept_id']. "';");
	//$query_result = $db_connection->query("SELECT * FROM projects;");
    
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

function renderPage() {
    $current_m = date("n");
    $current_y = date("Y");
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM timesheet_info 
        where emp_id = '" . $_SESSION['user_id']. "' and month='". $current_m ."' and year='". $current_y ."' ;");
        
    if( $query_result )//daca exista timesheet pt aceasta luna
    {
        $obj = $query_result->fetch_object();
        if( $obj->state == "OPEN" || $obj->state == "REJECT" )
            return displayRaport();
                
        if( $obj->state == "SUBMIT" )
            return "Timesheet-ul D-stra inca nu a fost verificat";
        if( $obj->state == "APPROVE" )
        {
            return "Timesheet-ul a fost aprobat" . displayRaport();
        }
    }
    else
    {
        if( $current_m > 2 )
        {
            $current_m--;
        }
        else
        {
            $current_m = 12;
            $current_y--;
        }
        $query_result = $db_connection->query("SELECT * FROM timesheet_info 
            where emp_id = '" . $_SESSION['user_id']. "' and month='". $current_m ."' and year='". $current_y ."' ;");
        $obj = $query_result->fetch_object();
        if( $obj->state == "OPEN" || $obj->state == "REJECT" )
            return "Va rugam sa trimiteti timesheet-ul spre verificare" . displayRaport();
                
        if( $obj->state == "SUBMIT" )
            return "Timesheet-ul D-stra inca nu a fost verificat";
    }
}

function buttons() {
    $current_m = date("n");
    $current_y = date("Y");
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM timesheet_info 
        where emp_id = '" . $_SESSION['user_id']. "' and month='". $current_m ."' and year='". $current_y ."' ;");
    $bIntrat = false;    
    if( !$query_result )
    {
        if( $current_m > 2 )
        {
            $current_m--;
        }
        else
        {
            $current_m = 12;
            $current_y--;
        }
        $query_result = $db_connection->query("SELECT * FROM timesheet_info 
            where emp_id = '" . $_SESSION['user_id']. "' and month='". $current_m ."' and year='". $current_y ."' ;");
        $bIntrat = true;
    }
    
    $obj = $query_result->fetch_object();
    if(  ( $bIntrat && $obj->state == "REJECT") || ( $bIntrat == false && ($obj->state == "REJECT" || $obj->state == "OPEN") ) )
    {
        $r = '';
        $r .= '<td align="right">';
        $r .= '    <input type="button" name="export_btn" value="Exporta" onclick="tableToExcel("testTable")">';
        $r .= '    <input type="submit" name="add_line_btn" value="Adauga linia">';
        $r .= '    <input type="submit" name="del_line_btn" value="Sterge linia">';
        $r .= '    <input type="submit" name="submit_btn" value="Trimite spre verificare">';
        $r .= '</td>';
        return $r;
    }
}
?>

<script src="../javascript/raport_export.js"></script>

<form method="post" action="../classes/timesheet_management.php" name="raportform">
    <table>
        <tr>
            <td width = "800">
                <?php echo renderPage(); ?>
            </td>
        </tr>
        <tr>
            <?php echo buttons(); ?>
        </tr>
    </table>
</form>
 