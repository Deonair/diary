<?php
    require_once('dbclass.php');//call class file
    require_once('session.php');// call session file

    // put the user in user_logout
    $user_logout = new Gebruikers();

    // If the user is already logged in
    if($user_logout->is_loggedin()!="")
    {
        header('home.php');
    }
    if(isset($_GET['logout']) && $_GET['logout']=="true") //if logout is true then logout out user and send them to the page login.php
    {
        $user_logout->doLogout();
        header('Location: ../login.php');
    }
?>