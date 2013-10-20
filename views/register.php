<!-- errors & messages --->
<?php

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

echo displayForm();

function displayForm(){
	$r = '';

	$r .= '<form method = "post" action = "register.php" name="registerform">';

	//<!-- the user name input field uses a HTML5 pattern check -->
    $r .= '<label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>';
    $r .= '<input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /><br>';
    
    //<!-- the email input field uses a HTML5 email type check -->
    $r .= '<label for="login_input_email">User\'s email</label>    ';
    $r .= '<input id="login_input_email" class="login_input" type="email" name="user_email" required /><br>';
    
    $r .= '<label for="login_input_password_new">Password (min. 6 characters)</label>';
    $r .= '<input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /><br>';
    
    $r .= '<label for="login_input_password_repeat">Repeat password</label>';
    $r .= '<input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /><br>';
    
	$r .= '<label for="login_input_tip_angajat">Selecteaza tip angajat</label>';
	$r .= getAngajat();
	
	$r .= '<input type="submit"  name="register" value="Register" />';

	return $r; 
} 

function getAngajat(){
	$r = '';

	$choices = array('' => '------', 'angajat' => 'Angajat', 'sefDivizie' => 'Sef de divizie', 'sefDepartament' => 'Sef de departmanet', 'director' => 'Director', 'administrator' => 'Administrator de aplicatie');
	@$payment = $_SESSION['tip_angajat'];

	$r .= '<select name="tip_angajat">';
	if(count($choices)>0) {
		foreach($choices as $key => $value) {
			//find out if it is selected
			if($key == $payment){
				$selectedAttribute = 'selected = "selected"';
			} else {
				$selectedAttribute = '';
			}
				
			$r .= '<option value="' . $key . '"' . $selectedAttribute . '>' . $value . '</option>';
		}

	}

	$r .= '</select>';

	return $r;

}

?>
<!-- errors & messages --->

<!-- backlink -->
<a href="index.php">Back to Login Page</a>