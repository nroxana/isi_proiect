<!-- here include just buttons for this kind of user -->
<input type="button" onclick="location.href = 'http://localhost/views/my_raport.php';" value="Raport">
<input type="button" name="check_btn" value="Verifica rapoarte">
<input type="button" onclick="location.href = 'http://localhost/views/addProject_form.php';" value="Adauga proiect">
<input type="button" onclick="location.href = 'http://localhost/register.php';" value="Adauga utilizatori">
<input type="button" onclick="location.href = 'http://localhost/views/delete.php';" value="Sterge utilizatori">

<nav id="main-nav">
    <ul id="nav-primary">
        <li><a href="#">Menu 1</a>
            <ul class="subnav">
                <li><a href="http://localhost/views/rapoarte/raport_a_form.php">punctul a</a>
                </li>
                <li><a href="http://localhost/views/rapoarte/raport_b_form.php">punctul b</a>
                </li>
                <li><a href="http://localhost/views/rapoarte/raport_c_form.php">punctul c</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<input type="button" onclick="location.href = 'http://localhost/index.php?logout';" value="Logout">
