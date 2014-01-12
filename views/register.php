<!-- errors & messages --->
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<?php
include("common.php");
// show negative messages
if ($registration->errors) {
    foreach ($registration->errors as $error) {
        echo $error;    
    }
}

// show positive messages
if ($registration->messages) {
    foreach ($registration->messages as $message) {
        echo $message;
    }
}

function displayForm(){
	$r = '';
	$r .= '<form method = "post" action = "register.php" name="registerform">';
    $r .= ' <table>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_username">Username (from 2 to 64 characters)</label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .= '             <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />';            
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_email">User\'s email</label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .= '             <input id="login_input_email" class="login_input" type="email" name="user_email" required />';            
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_password_new">Password (min. 6 characters)</label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .= '             <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />';            
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_password_repeat">Repeat password</label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .= '             <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />';            
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_numeprenume">First and last name</label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .= '             <input id="login_input_numeprenume" class="login_input" type="text" pattern="[ a-zA-Z]{2,50}" name="numeprenume" required />';            
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_tip_angajat">Selecteaza tip angajat: </label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .=               getEmployeeRole();           
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <label for="login_input_department">Selecteaza departamentul/divizia: </label>';            
    $r .= '         </td>';
    $r .= '         <td>';
    $r .=               getEmployeeDept();          
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= '     <tr>';
    $r .= '         <td>';
    $r .= '             <input type="submit"  name="register" value="Register" />';            
    $r .= '         </td>';
    $r .= '     </tr>';
    $r .= ' </table>';
    $r .= '</form>';
	return $r; 
} 

function getEmployeeRole(){
	$r = '';
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM role;");
    
    $role_ids = array();
    $role_names = array();    
	
    while($obj = $query_result->fetch_object()){ 
        array_push($role_ids, $obj->id);
        array_push($role_names, $obj->name); 
    }

	$r .= '<select name="tip_angajat">';
    for($i = 0; $i < count($role_ids); $i++) {
        $r .= '<option value="' . $role_ids[$i] . '">' . $role_names[$i] . '</option>';
    }
	$r .= '</select>';
	return $r;

}

function getEmployeeDept(){
	$r = '';

    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query_result = $db_connection->query("SELECT * FROM department;");
    
    $role_ids = array();
    $role_names = array();  
    while($obj = $query_result->fetch_object()){ 
        array_push($role_ids, $obj->id);
        array_push($role_names, $obj->name); 
    }
	
	$r .= '<select name="dept_id">';
	for($i = 0; $i < count($role_ids); $i++) {
        $r .= '<option value="' . $role_ids[$i] . '">' . $role_names[$i] . '</option>';
	}
	$r .= '</select>';
	return $r;

}

?>
<div>
    <?php echo displayForm() ?>
</div>