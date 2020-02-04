<?php

// connect to the database
include('connect-db.php');

// confirm that the 'id' variable has been set
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// get the 'id' variable from the URL
$id = $_GET['id'];
$stat ="REJECTED";

// delete record from database
if ($stmt = $mysqli->prepare("UPDATE landapplications SET status='$stat' WHERE id= ? LIMIT 1"))
{
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    $sql = "SELECT * FROM landapplications WHERE id='$id' ";
    $result0 = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result0, MYSQLI_NUM))
    {	
        $landid = $row[1];
    }

    $query1 ="UPDATE land SET status='AVAILABLE' WHERE lid='$landid'";
    mysqli_query($conn, $query1);

}
// IF  DELETION FAILS 
else {
    echo "ERROR: could not prepare SQL statement.";
}
$mysqli->close();
// redirect user after delete is successful
header("Location:landapps.php");
}
else
// if the 'id' variable isn't set, redirect the user
{
header("Location: landapps.php");
}
?>