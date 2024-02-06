<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Diary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/diary.css">
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
                        <?php
                        session_start();
                        if (isset($_SESSION['gebruiker_data'])) {
                            echo ' <a class="nav-link" href="src/uitloggen.php?logout=true"><img src="img/person.png">Loguit</a>';
                        } else {
                            echo '<a class="nav-link" href="login.php"><img src="img/person.png">Login</a>';
                        } ?>
                    </li>


                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['gebruiker_data'])) {
                            echo '  <a class="nav-link" href="welkom.php"><img src="img/home.png">Welcome</a>';
                        } else {
                            echo '<a class="nav-link" href="newdiary.php"><img src="img/plus.png">Create a diary!</a>';
                        } ?>
                    </li>



                </ul>
            </div>
        </div>

    </nav>
    <h1>Diary</h1>

    <div class="container">
        <h1>Welcome to the Diary site!</h1>
        <img src="img/bggrey.jpg" width="100%" height="">
        <p>Everyone can have their own personal diary or journal on the Internet - it's free at my-diary.org!
            Our focus is on security and privacy, and all diaries are private by default.
            Go ahead and register your own public or private diary today.</p>
    </div>
    <br>
    <a href="welkom.php">.</a>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>