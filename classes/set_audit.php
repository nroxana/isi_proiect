<?php
require_once("../config/db.php");
require_once("logger.php");
session_start();

function setValues()
{
    $handle = fopen('../LOGGERs/audit_values.data', 'w');
    $datas = $_POST['director'] . $_POST['division'] . $_POST['dept'] . $_POST['angajat'];
    fwrite($handle, $datas);
    fclose($handle);
}

if (isset($_POST["set"])) {
    setValues();
}

header('Location: ../user_page.php');

?>