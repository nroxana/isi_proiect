<!-- errors & messages --->
<?php

// show negative messages
if ($login->errors) {
    foreach ($login->errors as $error) {
        echo $error;    
    }
}

// show positive messages
if ($login->messages) {
    foreach ($login->messages as $message) {
        echo $message;
    }
}

?>
<!-- errors & messages --->

<!-- login form box -->
<!--<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
        <form name="loginform" method="post" action="index.php">
            <td>
                <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                    <tr>
                        <td colspan="3"><strong>Member Login </strong></td>
                    </tr>
                    <tr>
                        <td width="78">Username</td>
                        <td width="6">:</td>
                        <td width="294"><input name="user_name" type="text"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input name="user_password" type="password"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="login" value="Login"></td>
                    </tr>
                </table>
            </td>
        </form>
    </tr>
</table>-->
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<form class="form-1" name="loginform" method="post" action="index.php">
	<p class="field">
		<input type="text" name="user_name" placeholder="Username or email">
		<i class="icon-user icon-large"></i>
		</p>
		<p class="field">
			<input type="password" name="user_password" placeholder="Password">
			<i class="icon-lock icon-large"></i>
	</p>
	<p class="submit">
		<button type="submit" name="login"><i class="icon-arrow-right icon-large"></i></button>
	</p>
</form>
