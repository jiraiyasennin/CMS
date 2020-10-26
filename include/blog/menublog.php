<nav class = "navbar navbar-default">
    <div class = "container-fluid">
        <div class = "navbar-header">
            <button type = "button" class = "navbar-toggle" data-toggle = "collapse" data-target = "#colapsa">
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
            </button>
            <img id = "logoblog" src = "blogImages/Fibonacci_spiral.svg">
        </div>
        <div class = "collapse navbar-collapse" id = "colapsa">
            <ul id = "navegacionblog" class = "nav navbar-nav">
                <li class = "<?php echo ($_SERVER['PHP_SELF'] == "/CMS/blog.php" ? "active" : ""); ?>"><a href = "blog.php">Home</a></li>
                <li class = ""><a href = "https://dflps.000webhostapp.com/mail.php">Contacto</a></li>
                <li><a href = "login.php" data-toggle = "modal" data-target = "#login-modal"><span class = "glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
            <form class = "navbar-form navbar-right" action = "" method = "GET">
                <div class = "input-group">
                    <input type = "text" class = "form-control" name = "search" placeholder = "Search">
                    <div class = "input-group-btn">
                        <button class = "btn btn-default" name = "submit" type = "submit">
                            <i class = "glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</nav> 
