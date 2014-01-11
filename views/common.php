<head>
    <link href="../../css/global.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<a href="http://localhost/index.php"><img src="http://localhost/images/cooltext1.png" width="240" height="60"></a> <br>
</head>
<body>
<b>Bine ati venit <?php echo $_SESSION['numeprenume']; ?></b>.<br>
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
</body>