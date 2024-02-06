<?php
//Roep class bestand op
require_once ('../src/dbclass.php');
//unpack session
$gebruiker = unserialize($_SESSION['gebruiker_data']);
//Zet sessie id in variable
$user_id = $gebruiker->id;
//Roep class op
$DagboekID = new Dagboeken();
//Voer dagboek id functie uit
$DagboekID->getDagboekID($user_id);
//Zet array om in strings
foreach($DagboekID as $dagboekid){
	$dbid = $dagboekid['id_dagboek'];
}
?>