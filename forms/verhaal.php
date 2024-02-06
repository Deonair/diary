<?php
//Sessie starten
session_start();
//Roep class bestand op
require_once '../src/dbclass.php';
//Pass POST variable
$posts = $_POST['posts'];
$dagboekid = $_POST['id_dagboek'];
//unpack session
$user = unserialize($_SESSION['gebruiker_data']);
print_r($dagboekid);
//Zet sessie id in user id
$user_id = $user->id;
//Roep nieuwe gebruikers class op
$verhaal = new Dagboeken();
//Zet datum
$datum = date('Y-m-d');
//Voer verhaal functie uit;
$verhaal->setStory($dagboekid, $posts, $datum);
//Volgendelocatie
header('Location: ../library.php');

?>