    <?php
    require_once '../src/dbclass.php';

    session_start();

    //Roep class gebruikers op
    $user = new Gebruikers();
    //Zet POST values in variablen
    $post = $_POST;
    $voornaam = $post['voornaam'];
    $tussenvoegsel = $post['tussenvoegsels'];
    $achternaam = $post['achternaam'];
    $email = $post['email'];
    $wachtwoord = $post['wachtwoord'];
    $wachtwoord2 = $post['wachtwoord2'];

    //Hoofdletters naar kleine letters
    $email = strtolower($email);

    //Als er op de submit button wordt gedrukt.
    if (isset($_POST['submit'])) {

        //check voornaam
        if (!empty($voornaam)) {
            $naam_subject = $voornaam;
            $naam_patroon = '/^[a-zA-Z ]*$/';
            $naam_match = preg_match($naam_patroon, $naam_subject);
            if ($naam_match !== 1) {
                $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
            }
        } else {
            // Displays this error message when you dont fill in a Firstname
            $error[] = "Vul uw voornaam in.";
        }
        if (isset($error)) {
            $_SESSION['ERRORS'] = implode('<br> ', $error);
            header('Location:../gegevenswijzigen.php');
            //   echo $_SESSION['ERRORS'];  
        }
    }

    //check achternaam
    if (!empty($achternaam)) {
        $naam_subject = $achternaam;
        $naam_patroon = '/^[a-zA-Z ]*$/';
        $naam_match = preg_match($naam_patroon, $naam_subject);

        if ($naam_match !== 1) {
            $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "Vul uw achternaam in.";
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
            $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "Vul E-mail in";
    }

    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../register.php');
        //   echo $_SESSION['ERRORS'];  
    }
    //Checks if input is empty
    if (!empty($wachtwoord)) {
        $uppercase = preg_match('@[A-Z]@', $wachtwoord);
        $lowercase = preg_match('@[a-z]@', $wachtwoord);
        $number    = preg_match('@[0-9]@', $wachtwoord);
        $specialChars = preg_match('@[^\w]@', $wachtwoord);
    } else {
        $error[] = "Vul een wachtwoord in";
    }

    //Waar het wachtwoord aan moet voldoen
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
        $error[] = 'Vul een wachtwoord in van teminste  8 karakters die op zn minst 1 hoofdletter bevat, 1 kleine letter, een nummer en een speciale teken';
    }

    //If the information doesnt match!
    if ($naam_match !== true && $achternaam_match !== true && $email_match !== true && $naam_match !== true && $wachtwoord !== $wachtwoord2) {
        $error[] = "De wachtwoorden komen niet overeen.";
    }
//If error send display error message on register
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../register.php');
        //   echo $_SESSION['ERRORS'];  
        //Creates new user if everything has been filled in correctly
    } else {
        //If everything is correct create user and send them to the login form
        $user->create($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $wachtwoord2);
        header('Location: ../login.php');
    }
    ?>



