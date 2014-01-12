<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {

	file_put_contents("pdf/data/a.txt", "");
	$_SESSION['a_start_date'] = $_POST['start_date'];
	$_SESSION['a_end_date'] = $_POST['end_date'];
	$_SESSION['a_emp_id'] = $_POST['emp_id'];
	
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT emp_id, project_id, SUM(hours) suma, SUM(extra_hours) suma_extra, SUM(hours) + SUM(extra_hours) suma_total FROM timesheet where emp_id='". $_POST['emp_id'] ."' AND date
BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."' GROUP BY project_id;");
    $r = '';
    $r .= ' <table id="raportTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
	$r .= '			<td width="100" align="center">Nume angajat</td>';
    $r .= '         <td width="100" align="center">Nume Proiect</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate Extra</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate Total</td>';
    $r .= '    </tr>';
    $prj_names = array();
    $prj_hours = array();
    while( $query_result && $timesheet = $query_result->fetch_object() )
    {
        $project_result = $db_connection->query("SELECT name FROM projects where id = '" . $timesheet->project_id . "';");
		$nume_angajat = $db_connection->query("SELECT  numeprenume FROM  employee where  id = '". $timesheet->emp_id . "';");
        $project_name = $project_result->fetch_object();
		$emp_name = $nume_angajat->fetch_object();
        array_push($prj_names, $project_name->name);
        array_push($prj_hours, $timesheet->suma);
        $r .= ' <tr>';
		$r .= '		<td align="center">'. $emp_name->numeprenume . '</td>';
        $r .= '     <td align="center">'. $project_name->name .'</td>';
        $r .= '     <td align="center">'. $timesheet->suma .'</td>';
        $r .= '     <td align="center">'. $timesheet->suma_extra .'</td>';
        $r .= '     <td align="center">'. $timesheet->suma_total .'</td>';
        $r .= ' </tr>';
        $project_result->close();
		$nume_angajat->close();
		
		$file = 'pdf/data/a.txt';
		$data = $emp_name->numeprenume . ";";
		$data .= $project_name->name . ";";
		$data .= $timesheet->suma . ";";
		$data .= $timesheet->suma_extra . ";";
		$data .= $timesheet->suma_total . "\n";
		file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
		
    }
    $r .= ' <tr></tr></table>';
    echo $r;
    $query_result->close();
    if( count($prj_names) )
        savePie($prj_names, $prj_hours);
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
            <td align="right">
                <input type="button" name="export_btn" value="Exporta" onclick="tableToExcel('raportTable')">
            </td>
        </tr>
		<tr>
			<td align="right">
				<p>[<a href="pdf/pdf_a.php" title="PDF [new window]" target="_blank">PDF</a>]<p>
			</td>
		</tr>
    </table>
</form>r