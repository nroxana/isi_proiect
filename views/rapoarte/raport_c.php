<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<!-- <script type="text/javascript" src="javascript/script.js"></script> -->
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
//error_reporting(E_ALL & ~E_NOTICE);


function showRaport() {
	
	file_put_contents("pdf/data/c.txt", "");
	
	$_SESSION['c_start_date'] = $_POST['start_date'];
	$_SESSION['c_end_date'] = $_POST['end_date'];
	
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $project_result = $db_connection->query("SELECT id FROM projects;");

		$obj = $project_result->fetch_object();
		$query_result = $db_connection->query("SELECT emp_id, project_id, SUM(hours) suma, SUM(extra_hours) suma_extra, SUM(hours) + SUM(extra_hours) suma_total 
							FROM (SELECT * from timesheet where project_id in (SELECT id from projects where dept_id = '" . $_SESSION['dept_id'] . "')) as x where date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."' GROUP BY project_id;");
		
		$r = '';
        $r .= '<div class="component">';
        $r .= ' <table id="raportTable">';
		$r .= '<thead>';
        $r .= '    <tr style="background-color:#ccc;">';
		$r .= '         <th style="text-align:center" width="75	 align="center">Nume Proiect</th>';
        $r .= '         <th style="text-align:center" width="70" align="center">Ore Lucrate</th>';
        $r .= '         <th style="text-align:center" width="70" align="center">Ore Lucrate Extra</th>';
        $r .= '         <th style="text-align:center" width="100" align="center">Ore Lucrate Total</th>';
        $r .= '    </tr>';
		$r .= '</thead>';
        
        $emp_names = array();
        $prj_hours = array();
		$proj_names = array();
		$project_names = array();
		
		$inter = array();
        while( $query_result && $timesheet = $query_result->fetch_object() )
        {
            $emp_result = $db_connection->query("SELECT name FROM employee where id = '" . $timesheet->emp_id . "';");
            $emp_name = $emp_result->fetch_object()->name;
			
			$proj_result = $db_connection->query("SELECT name FROM projects where id = '" . $timesheet->project_id . "';");
			$proj_name = $proj_result->fetch_object()->name;
            
			array_push($emp_names, $emp_name);
            array_push($prj_hours, $timesheet->suma);
			array_push($proj_names, $timesheet->project_id);
			array_push($project_names, $proj_name);
           
		   $r .= ' <tr>';
			$r .= '     <td style="text-align:center" align="center">'. $proj_name .'</td>';
            $r .= '     <td style="text-align:center" align="center">'. $timesheet->suma .'</td>';
            $r .= '     <td style="text-align:center" align="center">'. $timesheet->suma_extra .'</td>';
            $r .= '     <td style="text-align:center" align="center">'. $timesheet->suma_total .'</td>';
            $r .= ' </tr>';
			
			$file = 'pdf/data/c.txt';
			$data = $proj_name . ";";
			$data .= $timesheet->suma . ";";
			$data .= $timesheet->suma_extra . ";";
			$data .= $timesheet->suma_total . "\n";
			file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
			
			$inter[] = array($proj_name, $timesheet->suma, $timesheet->suma_extra, $timesheet->suma_total);
			
            $emp_result->close();
        }
		
        $r .= ' <tr></tr></table>';
        echo $r;
		
        //$project_result->close();
        $query_result->close();
        if( count($project_names) )
            savePie($project_names, $prj_hours);
        
}
?>
<section class="color-2">
	<div style="text-align:center; padding: 0px;">
		<button class="btn2 btn-1 btn-1a" type="button" onclick="location.href = 'http://localhost/views/rapoarte/raport_c_sortAsc.php'">Sort asc</button>
		<button class="btn2 btn-1 btn-1a" type="button" onclick="location.href = 'http://localhost/views/rapoarte/raport_c_sortDesc.php'">Sort desc</button>
	</div>
</section>
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
				<input class="btn2 btn-1 btn-1a" type="button" name="PDF" value="PDF" onclick="location.href='pdf/pdf_c.php'">
			</td>
		</tr>
    </table>
</form>