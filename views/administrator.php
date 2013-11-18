 <?php session_start();?>
 Hey, <b><?php echo $_SESSION['user_name']; ?></b>.<br>
 <a href="..\index.php?logout">Logout</a>
 <a href="..\register.php">Register new account</a>