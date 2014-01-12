<?php
// Standard inclusions   
include("../../pChart/pData.class");
include("../../pChart/pChart.class");

function savePie($prj_names, $prj_hours) {
    // Dataset definition 
    $DataSet = new pData;
    $DataSet->AddPoint($prj_hours, "Serie1");
    $DataSet->AddPoint($prj_names, "Serie2");
    $DataSet->AddAllSeries();
    $DataSet->SetAbsciseLabelSerie("Serie2");

    // Initialise the graph
    $Test = new pChart(600,350);
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
    $Test->Render("example10.jpeg");
    echo '<img src="example10.jpeg">';
}

?>