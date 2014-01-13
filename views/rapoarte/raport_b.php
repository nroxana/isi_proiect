<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<head>
    <link href="../../css/global.css" rel="stylesheet" type="text/css">
	<link href="../../css/style.css"     rel="stylesheet" type="text/css">
	
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Raviro</title>
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="../../css/buttons/default.css" />
	<link rel="stylesheet" type="text/css" href="../../css/buttons/component.css" />
	<script src="../../javascript/modernizr.custom.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../../css/tables/normalizeTable.css" />
	<link rel="stylesheet" type="text/css" href="../../css/tables/demoTable.css" />
	<link rel="stylesheet" type="text/css" href="../../css/tables/componentTable.css" />
</head>
<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {
	file_put_contents("pdf/data/b.txt", "");
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $project_result = $db_connection->query("SELECT id FROM projects where name = '" . $_POST['prj_name'] . "';");
    if( $project_result &&  ($obj = $project_result->fetch_object()) )
    {
        $project_id = $obj->id;
        $query_result = $db_connection->query("SELECT emp_id, SUM(hours) suma, SUM(extra_hours) suma_extra, SUM(hours) + SUM(extra_hours) suma_total FROM timesheet where project_id='". $project_id ."' AND date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."' GROUP BY emp_id;");
        $r = '';
		$r .= '<div class="component">';
        $r .= ' <table id="raportTable">';
		$r .= '<thead>';
        $r .= '    <tr style="background-color:#ccc;">';
        $r .= '         <th style="text-align:center" width="100" align="center">Nume Angajat</th>';
        $r .= '         <th style="text-align:center" width="100" align="center">Ore Lucrate</th>';
        $r .= '         <th style="text-align:center" width="100" align="center">Ore Lucrate Extra</th>';
        $r .= '         <th style="text-align:center" width="100" align="center">Ore Lucrate Total</th>';
        $r .= '    </tr>';
		$r .= '</thead>';
        
        $emp_names = array();
        $prj_hours = array();
        while( $query_result && $timesheet = $query_result->fetch_object() )
        {
            $emp_result = $db_connection->query("SELECT numeprenume FROM employee where id = '" . $timesheet->emp_id . "';");
            $emp_name = $emp_result->fetch_object()->numeprenume;
            array_push($emp_names, $emp_name);
            array_push($prj_hours, $timesheet->suma);
            $r .= ' <tr>';
            $r .= '     <td style="text-align:center" align="center">'. $emp_name .'</td>';
            $r .= '     <td style="text-align:center" align="center">'. $timesheet->suma .'</td>';
            $r .= '     <td style="text-align:center" align="center">'. $timesheet->suma_extra .'</td>';
            $r .= '     <td style="text-align:center" align="center">'. $timesheet->suma_total .'</td>';
            $r .= ' </tr>';
            $emp_result->close();
			
			
			$file = 'pdf/data/b.txt';
			$data = $emp_name . ";";
			$data .= $timesheet->suma . ";";
			$data .= $timesheet->suma_extra . ";";
			$data .= $timesheet->suma_total . "\n";
			file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
        }
        $r .= ' <tr></tr></table>';
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

?>
<script src="../../javascript/raport_export.js"></script>
<form method="post" action="../../classes/timesheet_management.php" name="raportform">
    <table>
        <tr>
            <td width = "800">
                <?php 
					if (isset($_POST["find"])) {
						showRaport();
					} 
				?>
            </td>
        </tr>
        <tr>
            <td id="footer" align="right" style="text-align:center; background:green;">
                <input class="btn2 btn-1 btn-1a" type="button" name="export_btn" value="Exporta" onclick="tableToExcel('raportTable')">
				<input class="btn2 btn-1 btn-1a" type="button" name="PDF" value="PDF" onclick="location.href='pdf/pdf_b.php'">
		</tr>
    </table>
	</div>
</form>