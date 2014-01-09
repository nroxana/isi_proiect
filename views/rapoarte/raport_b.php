<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $project_result = $db_connection->query("SELECT id FROM projects where name = '" . $_POST['prj_name'] . "';");
    if( $project_result &&  ($obj = $project_result->fetch_object()) )
    {
        $project_id = $obj->id;
        $query_result = $db_connection->query("SELECT emp_id, SUM(hours) suma, SUM(extra_hours) suma_extra, SUM(hours) + SUM(extra_hours) suma_total FROM timesheet where project_id='". $project_id ."' AND date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."' GROUP BY emp_id;");
        $r = '';
        $r .= ' <table id="raportTable" border="2">';
        $r .= '    <tr style="background-color:#ccc;">';
        $r .= '         <td width="100" align="center">Nume Angajat</td>';
        $r .= '         <td width="100" align="center">Ore Lucrate</td>';
        $r .= '         <td width="100" align="center">Ore Lucrate Extra</td>';
        $r .= '         <td width="100" align="center">Ore Lucrate Total</td>';
        $r .= '    </tr>';
        
        $emp_names = array();
        $prj_hours = array();
        while( $query_result && $timesheet = $query_result->fetch_object() )
        {
            $emp_result = $db_connection->query("SELECT name FROM employee where id = '" . $timesheet->emp_id . "';");
            $emp_name = $emp_result->fetch_object()->name;
            array_push($emp_names, $emp_name);
            array_push($prj_hours, $timesheet->suma);
            $r .= ' <tr>';
            $r .= '     <td align="center">'. $emp_name .'</td>';
            $r .= '     <td align="center">'. $timesheet->suma .'</td>';
            $r .= '     <td align="center">'. $timesheet->suma_extra .'</td>';
            $r .= '     <td align="center">'. $timesheet->suma_total .'</td>';
            $r .= ' </tr>';
            $emp_result->close();
        }
        $r .= ' </table>';
        echo $r;
        $project_result->close();
        $query_result->close();
        if( count($emp_names) )
            savePie($emp_names, $prj_hours);
        
    }
    else
    {
        echo "Proiect Inexistent";
        return;
    }
}

if (isset($_POST["find"])) {
    showRaport();
}

?>