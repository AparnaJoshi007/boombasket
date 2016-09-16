<?php
session_start();
include 'allfunctions.php';
if(isset($_POST['aircraft'])){
addaircraft();
}
else
header("Location:aircraft.php");
?>
