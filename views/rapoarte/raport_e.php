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

	file_put_contents("pdf/data/e.txt", "");
	
    $r = '';
    $r .= '<div class="component">';
    $r .= ' <table id="raportTable">';
	$r .= '<thead>';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <th style="text-align:center" width="75	 align="center">ID</th>';
    $r .= '         <th style="text-align:center" width="75	 align="center">Nume Angajat</th>';
    $r .= '         <th style="text-align:center" width="75	 align="center">Functie</th>';
    $r .= '         <th style="text-align:center" width="75	 align="center">e-mail</th>';
    $r .= '    </tr>';
	$r .= '</thead>';
    
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT emp.id, emp.numeprenume, rol.name functia, email FROM employee emp 
                                            left join role rol on rol.id = emp.role_id where dept_id = '" . $_POST['dept_id'] . "';");
    while( $query_result && $emp = $query_result->fetch_object() )
    {
        $r .= ' <tr>';
        $r .= '     <td style="text-align:center" align="center">'. $emp->id .'</td>';
        $r .= '     <td style="text-align:center" align="center">'. $emp->numeprenume .'</td>';
        $r .= '     <td style="text-align:center" align="center">'. $emp->functia .'</td>';
        $r .= '     <td style="text-align:center" align="center">'. $emp->email .'</td>';
        $r .= ' </tr>';
		
		$file = 'pdf/data/e.txt';
		$data = $emp->id . ";";
		$data .= $emp->numeprenume . ";";
		$data .= $emp->functia . ";";
		$data .= $emp->email . "\n";
		file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
    }
    $r .= ' <tr></tr></table>';
    echo $r;
    $query_result->close();
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
				<input class="btn2 btn-1 btn-1a" type="button" name="PDF" value="PDF" onclick="location.href='pdf/pdf_e.php'">
            </td>
		</tr>
    </table>
</form>