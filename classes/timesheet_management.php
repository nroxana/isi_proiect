<?php
require_once("../config/db.php");
require '..\PHPMailer-master\PHPMailerAutoload.php';
session_start();

function addLine() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_insert = $db_connection->query("INSERT INTO timesheet (emp_id, date, hours, project_id, description, extra_hours) 
        VALUES( '" . $_SESSION['user_id'] . "', 
                '" . $_POST['fill_date'] . "', 
                '" . $_POST['fill_interval'] . "', 
                '" . $_POST['fill_project'] . "', 
                '" . $_POST['fill_activity'] . $_POST['fill_description'] . "',
                '" . $_POST['fill_extra_interval']. "'
               );
    ");
}

function delLine() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM  timesheet ORDER BY id DESC;");
    if($query_result) {
        $obj = $query_result->fetch_object();
        $db_connection->query("DELETE FROM timesheet WHERE id='". $obj->id ."'");
    }
    
}

function submitTimesheet() {
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $current = $db_connection->query("SELECT * FROM timesheet_info 
        WHERE emp_id= '". $_SESSION['user_id'] ."' ORDER BY id DESC LIMIT 1;");
    $obj = $current->fetch_object();
    $query_result = $db_connection->query("UPDATE timesheet_info SET state='".SUBMIT."' 
        WHERE emp_id= '". $_SESSION['user_id'] ."' and month='". $obj->month ."' and year='". $obj->year ."';"); 
		
	$mail = new PHPMailer();

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
	$mail->Port=587;
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'blaravirobla@gmail.com';                            // SMTP username
	$mail->Password = 'passwordraviro';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

	$mail->From = $_SESSION['user_email'];
	$mail->FromName = $_SESSION['numeprenume'];
	
	$findMailQuery = $db_connection->query("SELECT email from employee where role_id = '2' AND dept_id = '" . $_SESSION['dept_id'] . "';");
	$findNameQuery = $db_connection->query("SELECT numeprenume from employee where role_id = '2' AND dept_id = '" . $_SESSION['dept_id'] . "';");

	$findMail = $findMailQuery->fetch_object();
	$findName = $findNameQuery->fetch_object();
	
	$mail->addAddress('necula.roxana@yahoo.com', 'Necula Roxana');
	$mail->addAddress('straticiuc_vicu@yahoo.com', 'Straticiuc Vicu');
	$mail->addAddress('rares1991petrescu@yahoo.com', 'Petrescu Rares');
	$mail->addAddress($findMail->email, $findName->numeprenume);

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Raport';
	$mail->Body    = 'Buna ziua! Aveti un raport de verificat. Echipa Raviro';
	$mail->AltBody = 'Buna ziua! Aveti un raport de verificat. Echipa Raviro';

	if(!$mail->send()) {
	   echo 'Mail could not be sent. \n';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}

	echo 'Mail has been sent\n';
}

if (isset($_POST["submit_btn"])) {
    submitTimesheet();
}

if (isset($_POST["add_line_btn"])) {
    addLine();
}

if (isset($_POST["del_line_btn"])) {
    delLine();
}
header('Location: ../views/my_raport.php');
?>