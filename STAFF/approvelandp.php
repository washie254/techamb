<?php

// connect to the database
include('connect-db.php');

// confirm that the 'id' variable has been set
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// get the 'id' variable from the URL
$id = $_GET['id'];
$stat ="APPROVED";

// delete record from database
if ($stmt = $mysqli->prepare("UPDATE landpayments SET status='$stat' WHERE id= ? LIMIT 1"))
{
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
    $query0 = "SELECT * FROM landpayments WHERE id='$id' ";
    $result0 = mysqli_query($conn, $query0);
    while($row = mysqli_fetch_array($result0, MYSQLI_NUM))
    {
        $landid = $row[3];  //get the loan being paid
        $paidamount = $row[4]; //get the paid amount
        $mem = $row[2];
    }
    
    $query1 = "SELECT * FROM landapplications WHERE id='$landid' AND memberid='$mem' ";
    $result1 = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_array($result1, MYSQLI_NUM))
    {
        $bal = $row[3]; // CURRENT BALANCE OF THE LAND
    }

    $camount = $bal-$paidamount;

    $query ="UPDATE landapplications SET cost='$camount' WHERE id='$landid' AND memberid='$mem' ";
    mysqli_query($conn, $query);

}
// IF  DELETION FAILS 
else {
    echo "ERROR: could not prepare SQL statement.";
}
$mysqli->close();
// redirect user after delete is successful
header("Location:landpayments.php");
}
else
// if the 'id' variable isn't set, redirect the user
{
header("Location: landpayments.php");
}
?>