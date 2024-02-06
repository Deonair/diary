    <?php
//requires de class file 
require_once 'src/dbclass.php'; 

session_start();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/login.css">
    <title>Log in</title>
</head>

<body>

    <nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="diary.php"><img src="img/diarylogo.png" width="50px" height="62"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><img src="img/person.png">Login</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="newdiary.php"><img src="img/plus.png">Create Diary</a>
                    </li>



                </ul>
            </div>
        </div>

    </nav>
    <br>
 

    <div class="loginbox">
        <img src="img/orangeicon.png" class="avatar">
        <h1>Log In</h1>
        <form action="forms/login.php" method="post" name="gebruikers">
            <input type="text" name="email" placeholder="E-mail" />
            <input type="password" name="wachtwoord" placeholder="Password" />
            <input name="submit" type="submit" value="Login" />
            <a href="register.php">Don't have a account? Click Here</a><br>
            <?php//display error mesage
            if (isset($_SESSION['ERRORS'])) {
                echo $_SESSION['ERRORS'];
                unset($_SESSION['ERRORS']);
            }


            ?>
        </form>

    </div>

</body>

</html>