<?php
require_once("../../config/db.php");
session_start();
include("../common.php");


function showRaport() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT project_id, SUM( hours ) suma FROM  `timesheet` GROUP BY project_id;");
    
    $r = '';
    $r .= ' <table id="raportTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Proiect</td>';
    $r .= '         <td width="100" align="center">Ore lucrate</td>';
    $r .= '    </tr>';
    while( $query_result && $timesheet = $query_result->fetch_object() )
    {
        $project_result = $db_connection->query("SELECT name FROM projects where id = '" . $timesheet->project_id . "';");
        $project_name = $project_result->fetch_object();
        $r .= ' <tr>';
        $r .= '     <td align="center">"'. $project_name->name .'"</td>';
        $r .= '     <td align="center">"'. $timesheet->suma .'"</td>';
        $r .= ' </tr>';
    }
    $r .= ' </table>';
    return $r;
}

if (isset($_POST["find"])) {
    echo showRaport();
}
?>