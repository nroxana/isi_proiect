<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {

	file_put_contents("pdf/data/f.txt", "");

    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $timpTotalProiecte = 0;
    $r = '';
	$r = '<h2>Afiseaza clientii din perioada introdusa</h2>';
	
    $r .= ' <table id="raportTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Client</td>';
    $r .= '         <td width="100" align="center">Nume Proiect</td>';
    $r .= '         <td width="100" align="center">Ore Lucrate</td>';
    $r .= '         <td width="100" align="center">% din total</td>';
    $r .= '    </tr>';
    
    $query = $db_connection->query("SELECT client from projects;");

    $query_result = $db_connection->query("select dept.name dept_name, prj.name prj_name , SUM(time.hours) suma, SUM(time.extra_hours) suma_extra, 
                                                  SUM(time.hours) + SUM(time.extra_hours) suma_total
                            from timesheet time
                            left join employee emp on time.emp_id = emp.id
                            left join projects prj on prj.id = time.project_id
                            left join department dept on emp.dept_id = dept.id
                            where time.date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."'
                            GROUP BY time.project_id;");
    $prj_names = array();
    $prj_hours = array();
	while( $query_result && $obj = $query_result->fetch_object() ) {
		$timpTotalProiecte += $obj->suma_total;
	}
	$query->close();
	$query_result->close();
	$query2 = $db_connection->query("SELECT client from projects;");

    $query_result2 = $db_connection->query("select prj.client client_name, dept.name dept_name, prj.name prj_name , SUM(time.hours) suma, SUM(time.extra_hours) suma_extra, 
                                                  SUM(time.hours) + SUM(time.extra_hours) suma_total
                            from timesheet time
                            left join employee emp on time.emp_id = emp.id
                            left join projects prj on prj.id = time.project_id
                            left join department dept on emp.dept_id = dept.id
                            where time.date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."'
                            GROUP BY time.project_id;");
	
    while( $query_result2 && $obj2 = $query_result2->fetch_object() )
    {
        array_push($prj_names, $obj2->prj_name);
        array_push($prj_hours, $obj2->suma_total);
        $r .= ' <tr>';
        $r .= '     <td align="center">'. $obj2->client_name .'</td>';
        $r .= '     <td align="center">'. $obj2->prj_name .'</td>';
        $r .= '     <td align="center">'. $obj2->suma_total .'</td>';
		$r .= '     <td align="center">'. number_format((float)$obj2->suma_total / $timpTotalProiecte * 100 , 2, '.', '') .'</td>';
		$r .= ' </tr>';
		
		$file = 'pdf/data/f.txt';
		$data = $obj2->client_name . ";";
		$data .= $obj2->prj_name . ";";
		$data .= $obj2->suma_total . ";";
		$data .= number_format((float)$obj2->suma_total / $timpTotalProiecte * 100 , 2, '.', '') . "\n";
		file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
    }
    $r .= ' <tr></tr></table>';
    echo $r;
    $query_result2->close();
    if( count($prj_names) ){
        //savePie($prj_names, $prj_hours);
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
            <td align="right">
                <input type="button" name="export_btn" value="Exporta" onclick="tableToExcel('raportTable')">
            </td>
        </tr>
		<tr>
			<td align="right">
				<p>[<a href="pdf/pdf_f.php" title="PDF [new window]" target="_blank">PDF</a>]<p>
			</td>
		</tr>
    </table>
</form>