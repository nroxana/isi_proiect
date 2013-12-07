<head>
    <link href="../../css/global.css" rel="stylesheet" type="text/css">
</head>
<b>Bine ati venit <?php echo $_SESSION['user_name']; ?></b>.<br>
 Statutul: <?php echo $_SESSION['role_name']; ?><br>
 
<table style="float:left;">
    <tr>
        <td width = "100">
            <?php
            // redirect users by their types
            switch ($_SESSION['tip_angajat']) {
                case 1: 
                    include("angajat.php");
                    break;
                case 2: 
                    include("sefDepartament.php");
                    break;
                case 3: 
                    include("sefDivizie.php");
                    break;
                case 4: 
                    include("director.php");
                    break;
                case 5: 
                    include("administrator.php");
                    break;
                }?>
        </td>
    </tr>
</table>