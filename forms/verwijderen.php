<?php
//Laad class bestand
require_once('../src/dbclass.php');
//Start sessie
session_start();
//unpack session
$user = unserialize($_SESSION['gebruiker_data']);
//Zet sessie id in user id
$user_id = $user->id;
//Zet sessie email in email
$email = $user->email;
//Roep delete functie op
$deletegebruiker = $user->delete($user_id, $email);
//Volgende pagina
header('Location: ../login.php');
?>