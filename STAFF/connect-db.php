<?php
// server info
$server = 'localhost';
$user = 'africand_muchemi';
$pass = 'Muchemi254';
$db = 'africand_kentour';

// connect to the database
$mysqli = new mysqli($server, $user, $pass, $db);
$conn = new mysqli($server, $user, $pass, $db);

// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);

?>