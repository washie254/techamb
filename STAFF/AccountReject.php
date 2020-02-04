<?php
    include('connect-db.php');
    
    if (isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
        $stat ="REJECTED";

        if ($stmt = $mysqli->prepare("UPDATE members SET accountStatus='$stat' WHERE id= ? LIMIT 1"))
        {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->close();

            $sql = "SELECT * FROM members WHERE id='$id'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                $uid =$row[0];
                $uname =$row[1];
            }

            $reason = 'You did not qualify for an account with us';
            $cdate = date("y-m-d");

            $sql0 =  "INSERT INTO rejectedaccounts (userid, username, reason, date) 
                                            VALUES ('$uid','$uname','$reason','$cdate')";
            mysqli_query($conn, $sql0);

        }

        else {
            echo "ERROR: could not prepare SQL statement.";
        }

        $mysqli->close();

        header("Location:accounts.php");
    }
    else {
        header("Location: accounts.php");
    }
?>