<?php
//start session
session_start();
//Call Class File
require_once '../src/dbclass.php';
//Put title in variable
$naam = $_POST['titel'];
//Takes session out gebruiker data
$user = unserialize($_SESSION['gebruiker_data']);
//Put id in user id
$user_id = $user->id;
//use when title has a value
if(isset($_POST['titel'])){
//Call class
$setDiary = new Dagboeken();
//Activate function
$setDiary->setDiary($naam, $user_id);
//Next Location
header('Location: ../newstory.php');
}
?>