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
if ($stmt = $mysqli->prepare("UPDATE registrationpayments SET status='$stat' WHERE id= ? LIMIT 1"))
{
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
    $query0 = "SELECT * FROM registrationpayments WHERE id='$id' ";
    $result0 = mysqli_query($conn, $query0);
    while($row = mysqli_fetch_array($result0, MYSQLI_NUM))
    {
        $userid = $row[1];  //get the loan being paid
        $paidamount = $row[3]; //get the paid amount
    }
    
    $query1 = "SELECT * FROM accountpayment WHERE userid='$userid' ";
    $result1 = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_array($result1, MYSQLI_NUM))
    {
        $req =  $row[3];
        $paid = $row[4];
        $bal =  $row[5];
    }

    $tbalance = $bal - $paidamount;
    $tpaid = $paid + $paidamount;

    $query ="UPDATE accountpayment SET paid='$tpaid', balance='$tbalance' WHERE userid='$userid'";
    $results = mysqli_query($conn, $query);

}
// IF  DELETION FAILS 
else {
    echo "ERROR: could not prepare SQL statement.";
}
$mysqli->close();
// redirect user after delete is successful
header("Location:accountpayments.php");
}
else
// if the 'id' variable isn't set, redirect the user
{
header("Location: loanpayments.php");
}
?>