<?php

echo '
<nav>
<ul>
    <li class="minarem">
        <a href="index.php"'; if ($activePage =="index") { print 'class="active"';} echo'>Home</a>
    </li>
    <li>
        <a href="onama.php"'; if ($activePage =="onama") { print 'class="active"';} echo'>O nama</a>
    </li>
    <li>
        <a href="unos.php"'; if ($activePage =="unos") { print 'class="active"';} echo'>Unos</a>
    </li>
    <li>
        <a href="proizvodi.php"'; if ($activePage =="proizvodi") { print 'class="active"';} echo'>Proizvodi</a>
    </li>';
    
    echo'
        <li>
            <a href="https://www.tvz.hr/" target="_blank">TVZ</a>
        </li>';

    if(isset($_SESSION['username'])){

        if($_SESSION['level'] == '1'){
            echo '
            <li class="admir">
                <a href="administrator.php"'; if ($activePage =="administrator") { print 'class="active"';} echo'>Administrator</a>
            </li>';
        }
        echo'
        <li id="right" class="srednji">
            <a href="logout.php"'; echo'>Log Out</a>
        </li>

        <li id="right" class="srednji">
            <a href="#"';print 'class="active">'; echo htmlspecialchars($_SESSION['username']); echo '</a>
        </li>';

    } 
    else{
        echo'
        <li id="right" class="srednji">
            <a href="register.php"'; if ($activePage =="reg") { print 'class="active"';} echo'>Register</a>
        </li>
        <li id="right" class="srednji">
            <a href="login.php"'; if ($activePage =="log") { print 'class="active"';} echo'>Log IN</a>
        </li>';
    }
    
echo'</ul>
</nav>';