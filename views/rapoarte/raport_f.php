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

	file_put_contents("pdf/data/f.txt", "");

    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $timpTotalProiecte = 0;
    $r = '';
	$r = '<h2 style="text-align:center">Afiseaza clientii din perioada introdusa</h2>';
	
    $r .= '<div class="component">';
    $r .= ' <table id="raportTable">';
	$r .= '<thead>';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <th style="text-align:center" width="75	 align="center">Client</th>';
    $r .= '         <th style="text-align:center" width="75	 align="center">Nume Proiect</th>';
    $r .= '         <th style="text-align:center" width="75	 align="center">Ore Lucrate</th>';
    $r .= '         <th style="text-align:center" width="75	 align="center">% din total</th>';
    $r .= '    </tr>';
	$r .= '</thead>';
    
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
        $r .= '     <td style="text-align:center" align="center">'. $obj2->client_name .'</td>';
        $r .= '     <td style="text-align:center" align="center">'. $obj2->prj_name .'</td>';
        $r .= '     <td style="text-align:center" align="center">'. $obj2->suma_total .'</td>';
		$r .= '     <td style="text-align:center" align="center">'. number_format((float)$obj2->suma_total / $timpTotalProiecte * 100 , 2, '.', '') .'</td>';
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
            <td id="footer" align="right" style="text-align:center; background:green;">
                <input class="btn2 btn-1 btn-1a" type="button" name="export_btn" value="Exporta" onclick="tableToExcel('raportTable')">
				<input class="btn2 btn-1 btn-1a" type="button" name="PDF" value="PDF" onclick="location.href='pdf/pdf_f.php'">
            </td>
		</tr>
    </table>
</form>