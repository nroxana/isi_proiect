<?php
require_once("../config/db.php");
session_start();
include("common.php");
function displayRaport(){
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM timesheet where emp_name = '" . $_SESSION['user_id']. "';");
    
    $r = '';
    $r .= ' <table border="2">';
    $r .= '    <tr style="background-color:#ccc;">';
    $r .= '         <td width="100" align="center">Data</td>';
    $r .= '         <td width="100" align="center">Interval</td>';
    $r .= '         <td width="150" align="center">Nume proiect</td>';
    $r .= '         <td width="450" align="center">Descrierea lucrului</td>';
    $r .= '    </tr>';
    while( $query_result && $timesheet = $query_result->fetch_object() )
    {
        $r .= ' <tr>';
        $r .= '     <td width="100" align="center">"'. $timesheet->date .'"</td>';
        $r .= '     <td width="100" align="center">"'. $timesheet->hours .'"</td>';
        $r .= '     <td width="150" align="center">"'. $timesheet->project_id .'"</td>';
        $r .= '     <td width="450" align="center">"'. $timesheet->description .'"</td>';
        $r .= ' </tr>';
    }
    $r .= '     <tr>';
    $r .= '         <td><input type="date" name="fill_date"></td>';
    $r .= '         <td><input type="number" name="fill_interval"></td>';
    $r .= '         <td><input type="text" name="fill_project"></td>';
    $r .= '         <td><textarea rows="2" cols="50"></textarea></td>';
    $r .= '     </tr>';
    $r .= ' </table>';
    return $r;
}
?>

 <table>
    <tr>
        <td width = "100">
            <?php
            if( $_SESSION['tip_angajat'] != 4 )//director
                echo ('<input type="button" onclick="location.href = "http://localhost/views/my_raport.php";" value="Raport">');
            ?>
            <?php
            if( $_SESSION['tip_angajat'] != 1 )//angajat
                echo '<input type="button" name="check_btn" value="Verifica rapoarte">';
            ?>
            <input type="button" onclick="location.href = 'http://localhost/index.php?logout';" value="Logout">
        </td>
        <td width = "800">
            <?php echo displayRaport(); ?>
        </td>
    </tr>
    <tr>
        <td width="100">&nbsp;</td>
        <td align="right">
            <input type="button" name="export_btn" value="Exporta">
            <input type="button" name="add_line_btn" value="Adauga linia">
            <input type="button" name="del_line_btn" value="Sterge linia">
            <input type="button" name="send_btn" value="Trimite spre verificare">
        </td>
    </tr>
 </table>