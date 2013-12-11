<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $r = '';
    $r .= ' <table id="raportTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Nume Departament</td>';
    $r .= '         <td width="100" align="center">Nume Proiect</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate Extra</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate Total</td>';
    $r .= '    </tr>';
    
    $query = $db_connection->query("SELECT division_id from department where id='". $_SESSION['dept_id'] . "';");

    $division_id = $query->fetch_object()->division_id;
    $query_result = $db_connection->query("select dept.name dept_name, prj.name prj_name , SUM(time.hours) suma, SUM(time.extra_hours) suma_extra, 
                                                  SUM(time.hours) + SUM(time.extra_hours) suma_total
                            from timesheet time
                            left join employee emp on time.emp_id = emp.id
                            left join projects prj on prj.id = time.project_id
                            left join department dept on emp.dept_id = dept.id
                            left join divizion divi on dept.division_id = divi.id 
                            where divi.id='". $division_id ."' AND 
                            time.date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."'
                            GROUP BY time.project_id;");
    
    $prj_names = array();
    $prj_hours = array();
    while( $query_result && $obj = $query_result->fetch_object() )
    {
        array_push($prj_names, $obj->prj_name);
        array_push($prj_hours, $obj->suma_total);
        $r .= ' <tr>';
        $r .= '     <td align="center">"'. $obj->dept_name .'"</td>';
        $r .= '     <td align="center">"'. $obj->prj_name .'"</td>';
        $r .= '     <td align="center">"'. $obj->suma .'"</td>';
        $r .= '     <td align="center">"'. $obj->suma_extra .'"</td>';
        $r .= '     <td align="center">"'. $obj->suma_total .'"</td>';
        $r .= ' </tr>';
    }
    $r .= ' </table>';
    echo $r;
    $query_result->close();
    if( count($prj_names) )
        savePie($prj_names, $prj_hours);
}

if (isset($_POST["find"])) {
    showRaport();
}
?>