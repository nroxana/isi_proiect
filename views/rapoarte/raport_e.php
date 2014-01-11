<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {
    $r = '';
    $r .= ' <table id="raportTable" border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">ID</td>';
    $r .= '         <td width="100" align="center">Nume Angajat</td>';
    $r .= '         <td width="100" align="center">Functie</td>';
    $r .= '         <td width="100" align="center">e-mail</td>';
    $r .= '    </tr>';
    
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT emp.id, emp.name, rol.name functia, email FROM employee emp 
                                            left join role rol on rol.id = emp.role_id where dept_id = '" . $_POST['dept_id'] . "';");
    while( $query_result && $emp = $query_result->fetch_object() )
    {
        $r .= ' <tr>';
        $r .= '     <td align="center">'. $emp->id .'</td>';
        $r .= '     <td align="center">'. $emp->name .'</td>';
        $r .= '     <td align="center">'. $emp->functia .'</td>';
        $r .= '     <td align="center">'. $emp->email .'</td>';
        $r .= ' </tr>';
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
            <td align="right">
                <input type="button" name="export_btn" value="Exporta" onclick="tableToExcel('raportTable')">
            </td>
        </tr>
    </table>
</form>