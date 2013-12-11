<!-- here include just buttons for this kind of user -->
<input type="button" onclick="location.href = 'http://localhost/views/my_raport.php';" value="Raport">
<input type="button" name="check_btn" value="Verifica rapoarte">
<input type="button" name="add_project_btn" value="Adauga proiect">

<nav id="main-nav">
    <ul id="nav-primary">
        <li><a href="#">Menu 1</a>
            <ul class="subnav">
                <li><a href="http://localhost/views/rapoarte/raport_a_form.php">punctul a</a>
                </li>
                <li><a href="http://localhost/views/rapoarte/raport_b_form.php">punctul b</a>
                </li>
                <li><a href="#">punctul c</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<input type="button" onclick="location.href = 'http://localhost/index.php?logout';" value="Logout">
