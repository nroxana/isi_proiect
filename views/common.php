<head>
    <link href="../../css/global.css" rel="stylesheet" type="text/css">
	<link href="../css/style.css"     rel="stylesheet" type="text/css">
	
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Raviro</title>
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="../css/buttons/default.css" />
	<link rel="stylesheet" type="text/css" href="../css/buttons/component.css" />
	<script src="../javascript/modernizr.custom.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../css/tables/normalizeTable.css" />
	<link rel="stylesheet" type="text/css" href="../css/tables/demoTable.css" />
	<link rel="stylesheet" type="text/css" href="../css/tables/componentTable.css" />
	
</head>


<body>

<section class="color-6" style ="padding:0px;">
	 <div style="top: 20px; left: 35px; text-align:left; position: relative;"><img src="http://logotypemaker.com/files/free_logos/52d358c0eee66gYb4L4M7gH.png" />.<br></div>
	 <div style="top: 20px; right: 35px; text-align:right; position: relative; color: #FFFFFF; font-size: 20px;"><b>Bine ati venit, <?php echo $_SESSION['numeprenume']; ?></b>.<br></div>
	 <div style="top: 20px; right: 35px; text-align:right; position: relative; color: #FFFFFF">Statutul: <?php echo $_SESSION['role_name']; ?><br></div><br><br>
</section>	
	
<!--<table style="float:left;">
    <tr>
        <td width = "100">-->
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
       <!-- </td>
    </tr>
</table>-->
</body>