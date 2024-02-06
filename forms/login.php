<?php
require_once('../src/dbclass.php');
//start sessie
session_start();
//Maak nieuw Dagboek
$gebruiker = new Dagboeken();
//passed post variables
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];

//filter emails naar lowerstring
$email = strtolower($email);
//Voer inlog functie uit
$ingelogd = $gebruiker->login($email, $wachtwoord);

if (is_bool($ingelogd)) {
    //Zet user values in sessie
    $_SESSION['gebruiker_data'] = serialize($gebruiker); 
    file_put_contents('dstore', $_SESSION['gebruiker_data']);
    //Volgende pagina
    header('Location: ../welkom.php');
} elseif(is_string($ingelogd)) {
    echo $ingelogd;
    
}else{
    $_SESSION['ERRORS'] = "Het ingevoerde email en/of wachtwoord zijn onjuist.";
    //Volgende pagina
    header('Location: ../login.php');
}

if (isset($_POST['submit'])) {
    //check voornaam
    if (!empty($email)) {
        $email_subject = $email;
        $email_patroon = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $email_match = preg_match($email_patroon, $email_subject);
        if ($email_match !== 1) {
            $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "Vul E-mail in";
    }
   
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location: ../login.php');
        //   echo $_SESSION['ERRORS'];  
    }

    if (!empty($wachtwoord)) {
        //Capital Letters
        $uppercase = preg_match('@[A-Z]@', $wachtwoord);
        //Lowercase letters
        $lowercase = preg_match('@[a-z]@', $wachtwoord);
        //Numbers
        $number    = preg_match('@[0-9]@', $wachtwoord);
        //Special characters like !@#$%^&*()
        $specialChars = preg_match('@[^\w]@', $wachtwoord);
    } else {
        $error[] = "Vul een wachtwoord in";
    }
        //Waar het wachtwoord aan moet voldoen
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
            $error[] = 'Vul een wachtwoord in van teminste  8 karakters die op zn minst 1 hoofdletter bevat, 1 kleine letter, een nummer en een speciale teken';
        }
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location: ../login.php');
        //   echo $_SESSION['ERRORS'];  
    }
    else {
        //If everything is correct send user to welcome page
        $ingelogd = $gebruiker->login($email, $wachtwoord);
                header('Location: ../welkom.php');
    }
}
