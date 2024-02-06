<?php
//Start sessie
session_start();
//Roep class bestand op
require_once ('../src/dbclass.php');
//Zet POST value in variable
$dagboekid = $_POST['id_dagboek'];
// die ($dagboekid);
//unpack session
$gebruiker = unserialize($_SESSION['gebruiker_data']);
//Zet sessie id in variable
$user_id = $gebruiker->id;
//Roep dagboeken class op
$dagboek = new Dagboeken();
//Voer deleteDiary functie uit
$dagboek->deleteDiary($dagboekid, $user_id);
//volgende pagina
header("Location: ../library.php");
?>