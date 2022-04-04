<?php
    // Connect to the database
    require_once "connection.php";
    
    // Get contact details
    if (isset($_GET["id"])) {
        $id = preg_replace('/\D/', '', $_GET["id"]); //Accept numbers only
    } else {
        header("Location: index.php?p=update&err=no_id");
    }

    // Update contact details
    if (isset($_POST["btnUpdate"])) {
        $fname    = $con->real_escape_string($_POST["txtfName"]);
        $mname    = $con->real_escape_string($_POST["txtmName"]);
        $lname    = $con->real_escape_string($_POST["txtlName"]);
        $bday   = $con->real_escape_string($_POST["txtday"]);
        $today = date("Y-m-d");
        $getage = date_diff(date_create($bday), date_create($today));
        $age= $getage->format('%y');
        $add1 = $con->real_escape_string($_POST["txtadd1"]);
        $add2 = $con->real_escape_string($_POST["txtadd2"]);
        $region    = $con->real_escape_string($_POST["txtreg"]);
        $city    = $con->real_escape_string($_POST["txtlcity"]);


        if ($stmt = $con->prepare("UPDATE `contacts` SET `fname`=`fname`,`mname`=`mname`,`lname`=`lname`,`bday`=`bday`,`age`=`age`,`add1`=`add1`,`add2`=`add2`, `region`=`region`, `city`= `city` WHERE `id`=?")) {
           
           
            $stmt->close();
            $msg = '<div class="msg msg-update">Student details updated successfully.</div>';
        } else {
            $msg = '<div class="msg">Prepare() failed: '.htmlspecialchars($con->error).'</div>';
        }
    }

    
    if ($stmt = $con->prepare("SELECT `fname`,`mname`,`lname`,`bday`,`age`,`add1`,`add2`, `region`, `city` FROM `contacts` WHERE `id`=? LIMIT 1")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result ($fname,$mname,$lname, $bday,$age, $add1,$add2,$region,$city);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    } else {
        die('prepare() failed: ' . htmlspecialchars($con->error));
    }
    
    // Close database connection
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data | Student Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
            <h1>&#187;Update Data&#171;</h1>
            
        </div>
        <div class="wrapper">
            <div class="title update">
                <h2>Update Student Profile</h2>
                <hr>
            </div>
            <form action="<?=$_SERVER['PHP_SELF']."?id=".$id;?>" method=$_POST class="frmUpdate">
                 <input type="text" name="txtfName" placeholder="First Name" required>
                <input type="text" name="txtmName" placeholder="Middle Name" required>
                <input type="text" name="txtlName" placeholder="Surname Name" required>
                <input type="date" name="txtday" placeholder="Birthday" required>
                <input type="text" name="txtadd1" placeholder="Address1" required>
                <input type="text" name="txtadd2" placeholder="Address2" required>
                <input type="text" name="txtreg" placeholder="Region" required>
                <input type="text" name="txtlcity" placeholder="City" required>
                
                <div class="btnWrapper">
                    <button type="submit" name="btnUpdate" class="btnUpdate" title="Update contact details">Update</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>