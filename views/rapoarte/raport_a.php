<?php
require_once("../../config/db.php");
session_start();
include("../common.php");


function showRaport() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT project_id, SUM(hours) suma FROM timesheet where emp_id='". $_POST['emp_id'] ."' AND date
BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."' GROUP BY project_id;");
    $r = '';
    $r .= ' <table id="raportTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Nume Proiect</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate</td>';
    $r .= '    </tr>';
    
    $prj_names = array();
    $prj_hours = array();
    while( $query_result && $timesheet = $query_result->fetch_object() )
    {
        $project_result = $db_connection->query("SELECT name FROM projects where id = '" . $timesheet->project_id . "';");
        $project_name = $project_result->fetch_object();
        array_push($prj_names, $project_name->name);
        array_push($prj_hours, $timesheet->suma);
        $r .= ' <tr>';
        $r .= '     <td align="center">"'. $project_name->name .'"</td>';
        $r .= '     <td align="center">"'. $timesheet->suma .'"</td>';
        $r .= ' </tr>';
    }
    $r .= ' </table>';
    echo $r;
    if( count($prj_names) )
        savePie($prj_names, $prj_hours);
}

function savePie($prj_names, $prj_hours) {
    // Standard inclusions   
    include("../../pChart/pData.class");
    include("../../pChart/pChart.class");

    // Dataset definition 
    $DataSet = new pData;
    $DataSet->AddPoint($prj_hours, "Serie1");
    $DataSet->AddPoint($prj_names, "Serie2");
    $DataSet->AddAllSeries();
    $DataSet->SetAbsciseLabelSerie("Serie2");

    // Initialise the graph
    $Test = new pChart(420,250);
    $Test->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
    $Test->drawRoundedRectangle(5,5,415,245,5,230,230,230);

    // Draw the pie chart
    $Test->setFontProperties("../../Fonts/tahoma.ttf",8);
    $Test->AntialiasQuality = 0;
    $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
    $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

    // Write the title
    $Test->setFontProperties("../../Fonts/MankSans.ttf",10);
    $Test->drawTitle(10,20,"Statistica",100,100,100);
    $Test->Render("example10.png");
    echo '<img src="example10.png">';
}

if (isset($_POST["find"])) {
    showRaport();
}
?>