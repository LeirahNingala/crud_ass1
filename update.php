<?php
    // Connect to the database
    require_once "connection.php";
    require_once "uploadupdate.php";
    $id = 0;
     $fname    = $mname    = $lname    = $bday   = $today =  $getage = $age= $add1 = $add2 = $region    =  $city    ="";
    // Get contact details
    if (isset($_GET["id"])) {
        $id = preg_replace('/\D/', '', $_GET["id"]); //Accept numbers only
        $result = $con->query("SELECT * from contacts WHERE id ='$id'") or die($mysqli->error);
        if (count(array($result))==1) {
        # code...
            $row = $result->fetch_array();
            $id    = $row['id'];
         $fname    = $row['fname'];
        $mname    = $row['mname'];
        $lname    = $row['lname'];
        $bday   = $row['bday'];
       
        $add1 = $row['add1'];
        $add2 = $row['add2'];
        $region    = $row['region'];
        $city    = $row['city'];
    }
    } else {
        $msg = '<div class="msg msg-update">Student details updated successfully.</div>';
        header("Location: index.php?p=update&err=no_id");
    }
    

    // Update contact details

    
  
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
            <form action="uploadupdate.php" method="POST" class="frmUpdate">
                <input type="hidden" name="id"  value="<?php echo $id; ?>">
                 <input type="text" name="txtfName" placeholder="First Name" required value="<?php echo $fname; ?>">
                <input type="text" name="txtmName" placeholder="Middle Name" required value="<?php echo $mname; ?>">
                <input type="text" name="txtlName" placeholder="Surname Name" required value="<?php echo $lname; ?>">
                <input type="date" name="txtday" placeholder="Birthday" required value="<?php echo $bday; ?>">
                <input type="text" name="txtadd1" placeholder="Address1" required value="<?php echo $add1; ?>">
                <input type="text" name="txtadd2" placeholder="Address2" required value="<?php echo $add2; ?>">
                <input type="text" name="txtreg" placeholder="Region" required value="<?php echo $region; ?>">
                <input type="text" name="txtlcity" placeholder="City" required value="<?php echo $city; ?>">
                
                <div class="btnWrapper">
                    <button type="submit" name="upd" class="btnUpdate" title="Update contact details">Update</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>