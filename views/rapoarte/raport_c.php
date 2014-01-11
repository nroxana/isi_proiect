<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<!-- <script type="text/javascript" src="javascript/script.js"></script> -->
<?php
require_once("../../config/db.php");
session_start();
include("../common.php");
include("../../classes/chart_functions.php");

function showRaport() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $project_result = $db_connection->query("SELECT id FROM projects;");
    /*if( $project_result &&*/  //($obj = $project_result->fetch_object()) )
    //{*/
		$obj = $project_result->fetch_object();
        //S$project_id = $obj->id;
        $query_result = $db_connection->query("SELECT emp_id, project_id, SUM(hours) suma, SUM(extra_hours) suma_extra, SUM(hours) + SUM(extra_hours) suma_total 
							FROM timesheet where date BETWEEN '". $_POST['start_date'] ."' AND '". $_POST['end_date'] ."' GROUP BY project_id;");
        $r = '';
        $r .= ' <table id="raportTable" border="2">';
        $r .= '    <tr style="background-color:#ccc;">';
		$r .= '         <td width="100" align="center">Nume Proiect</td>';
        $r .= '         <td width="100" align="center">Ore Lucrate</td>';
        $r .= '         <td width="100" align="center">Ore Lucrate Extra</td>';
        $r .= '         <td width="100" align="center">Ore Lucrate Total</td>';
        $r .= '    </tr>';
        
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
			$r .= '     <td align="center" id=>'. $proj_name .'</td>';
            $r .= '     <td align="center">'. $timesheet->suma .'</td>';
            $r .= '     <td align="center">'. $timesheet->suma_extra .'</td>';
            $r .= '     <td align="center">'. $timesheet->suma_total .'</td>';
            $r .= ' </tr>';
			
			$inter[] = array($proj_name, $timesheet->suma, $timesheet->suma_extra, $timesheet->suma_total);
			
            $emp_result->close();
        }
		//echo $inter;
		$counttoken = count($inter);
		$k=count($inter[0]);
		for($i=0; $i<$counttoken;$i++)
		{
			for($j=0; $j<$k; $j++)
				echo $inter[$i][$j];
		}
		
        $r .= ' <tr></tr></table>';
        echo $r;
        //$project_result->close();
        $query_result->close();
        if( count($project_names) )
            savePie($project_names, $prj_hours);
        
    //}
    /*else
    {
        echo "Proiect Inexistent";
        return;
    }*/
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