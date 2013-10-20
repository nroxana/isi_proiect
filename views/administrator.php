 <?php session_start();?>
 Hey, <b><?php echo $_SESSION['user_name']; ?></b>.
 <a href="..\index.php?logout">Logout</a>