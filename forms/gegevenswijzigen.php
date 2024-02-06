<?php

require_once('../src/dbclass.php');
//Maak nieuwe sessie
session_start();
//Roep nieuwe gebruikers class op
$gebruiker = new Gebruikers();
//zet POST values in variablen
$voornaam = $_POST['voornaam'];
$tussenvoegsel = $_POST['tussenvoegsel'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$oudwachtwoord = $_POST['oudwachtwoord'];
$wachtwoord = $_POST['nww1'];
$wachtwoord2 = $_POST['nww2'];


//Als er op de submit button wordt geklikt.
if (isset($_POST['submit'])) {

    //check voornaam 
    if (!empty($voornaam)) {
        $naam_subject = $voornaam;
        $naam_patroon = '/^[a-zA-Z ]*$/';
        $naam_match = preg_match($naam_patroon, $naam_subject);
        if ($naam_match !== 1) {
            $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../gegevenswijzigen.php');
        //   echo $_SESSION['ERRORS'];  
    }

    //check achternaam
    if (!empty($achternaam)) {
        $naam_subject = $achternaam;
        $naam_patroon = '/^[a-zA-Z ]*$/';
        $naam_match = preg_match($naam_patroon, $naam_subject);

        if ($naam_match !== 1) {
            $error[] = "Achternaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../gegevenswijzigen.php');
        //   echo $_SESSION['ERRORS'];  
    }
    //check voornaam
    if (!empty($email)) {
        $email_subject = $email;
        $email_patroon = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $email_match = preg_match($email_patroon, $email_subject);
        if ($email_match !== 1) {
            $error[] = "E-mail moet een @ bevatten.";
        }
    }

    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../gegevenswijzigen.php');
        //   echo $_SESSION['ERRORS'];  
    }
}
if (!empty($oudwachtwoord)) {
    $uppercase = preg_match('@[A-Z]@', $oudwachtwoord);
    $lowercase = preg_match('@[a-z]@', $oudwachtwoord);
    $number    = preg_match('@[0-9]@', $oudwachtwoord);
    $specialChars = preg_match('@[^\w]@', $oudwachtwoord);
    //Waar het wachtwoord aan moet voldoen
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($oudwachtwoord) < 8) {
        $error[] = 'Vul een wachtwoord in van teminste  8 karakters die op zn minst 1 hoofdletter bevat, 1 kleine letter, een nummer en een speciale teken';
    }
} else {
    $error[] = "Vul een wachtwoord in";
}



if (isset($error)) {
    $_SESSION['ERRORS'] = implode('<br> ', $error);
    header('Location:../gegevenswijzigen.php');
    //   echo $_SESSION['ERRORS'];  
    //Creates new user if everything has been filled in correctly
} else {
    $updategebruiker = $gebruiker->update($voornaam, $tussenvoegsel, $achternaam, $email, $oudwachtwoord, $wachtwoord);
    header('Location: ../login.php');
}
//If 
if (!empty($wachtwoord)) {
    $uppercase = preg_match('@[A-Z]@', $wachtwoord);
    $lowercase = preg_match('@[a-z]@', $wachtwoord);
    $number    = preg_match('@[0-9]@', $wachtwoord);
    $specialChars = preg_match('@[^\w]@', $wachtwoord);
    //Waar het wachtwoord aan moet voldoen
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
        $error[] = 'Vul een wachtwoord in van teminste  8 karakters die op zn minst 1 hoofdletter bevat, 1 kleine letter, een nummer en een speciale teken';
    }
}


//If the information doesnt match!
if ($naam_match !== true && $achternaam_match !== true && $email_match !== true && $naam_match !== true && $wachtwoord !== $wachtwoord2) {
    $error[] = "De wachtwoorden komen niet overeen.";
}

if (isset($error)) {
    $_SESSION['ERRORS'] = implode('<br> ', $error);
    header('Location:../gegevenswijzigen.php');
    //   echo $_SESSION['ERRORS'];  
    //Creates new user if everything has been filled in correctly
} else {
    $updategebruiker = $gebruiker->update($voornaam, $tussenvoegsel, $achternaam, $email, $oudwachtwoord, $wachtwoord);
    header('Location: ../login.php');
}

// //Zet variablen op NULL voor isset check
// if (empty($email)) {
//     $email = NULL;
// }

// if (empty($wachtwoord)) {
//     $wachtwoord = NULL;
// }

// if (empty($wachtwoord2)) {
//     $wachtwoord2 = NULL;
// }

// //Check of identiek is
// if (isset($email)) {
//     //update voor nieuwe email
//     $updategebruiker = $gebruiker->update($voornaam, $tussenvoegsel, $achternaam, $email, $oudwachtwoord, $wachtwoord);
//     header('Location: ../login.php');
//     session_destroy();
// }
// //Check of identiek is
// //Update voor nieuw wachtwoord
// if (isset($wachtwoord) && isset($wachtwoord2) && ($wachtwoord == $wachtwoord2)) {

//     $updategebruiker = $gebruiker->update($voornaam, $tussenvoegsel, $achternaam, $email, $oudwachtwoord, $wachtwoord);
//     session_destroy();
// }
// //Voer ook uit als geen nieuw wachtwoord of email zijn ingevoerd
// $updategebruiker = $gebruiker->update($voornaam, $tussenvoegsel, $achternaam, $email, $oudwachtwoord, $wachtwoord);

// //Volgende locatie
// header('Location: ../login.php');
