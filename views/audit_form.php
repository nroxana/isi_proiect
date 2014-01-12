<?php
session_start();
include("common.php");
require_once("../config/db.php");

$handle = 0;
$data   = 0;

function getValues($functia)
{
    $handle = fopen('../logs/audit_values.data', 'r');
    $data = fread($handle,filesize('../logs/audit_values.data'));
    fclose($handle);
    return $data[$functia];
}
getValues(1);
?>

<form method = "post" action = "../classes/set_audit.php" name="auditform">
    <table>
        <tr>
            Nivelulu de logare poate fi 1, 2, 3. La 1 se inregistreaza totul
        </tr>
        <tr style="background-color:#ccc;">
            <td>
                Functia :
            </td>
            <td>
                Nivel de logare :
            </td>
        </tr>
        <tr>
            <td>
                Director
            </td>
            <td>
                <input type="number" name="director" value="<?php echo getValues(3); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Sef Divizie
            </td>
            <td>
                <input type="number" name="division" value="<?php echo getValues(2); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Sef departament
            </td>
            <td>
                <input type="number" name="dept" value="<?php echo getValues(1); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Angajat
            </td>
            <td>
                <input type="number" name="angajat" value="<?php echo getValues(0); ?>">
            </td>
        </tr>
        <tr> 
            <td>
                <input type="submit" name="set" value"Seteaza">
            </td>
        </tr>
    </table>
</form>