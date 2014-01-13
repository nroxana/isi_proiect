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
        <thead>
            <!--<th> Nivelul de logare poate fi 1, 2, 3. La 1 se inregistreaza totul. </th>	-->
			<strong>Nivelul de logare poate fi 1, 2, 3. La 1 se inregistreaza totul.</strong>
        </thead>
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
                <input class="btn3 btn-2 btn-2a" type="submit" name="set" value"Seteaza">
            </td>
        </tr>
    </table>
</form>