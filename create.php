<?php
    // Delete Table data
    if (isset($_POST["btnSave"])) {
        // Connect to the database
        require_once "connection.php";

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



        if ($stmt = $con->prepare("INSERT INTO `contacts`(`fname`,`mname`,`lname`,`bday`,`age`,`add1`,`add2`, `region`, `city`) VALUES ('$fname','$mname','$lname', '$bday','$age','$add1','$add2','$region','$city')")) {
            
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-create">Contact details saved successfully.</div>';
        } else {
            $msg = '<div class="msg">Prepare() failed: '.htmlspecialchars($con->error).'</div>';
        }

        // Close database connection
        $con->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Data | Student Profile </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
            <h1>&#187;Create Data | Student Profile&#171;</h1>
            
        </div>
        <div class="wrapper">
            <div class="title create">
                <h2>Create New Student</h2>
                <hr>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="frmCreate">
                <input type="text" name="txtfName" placeholder="First Name" required>
                <input type="text" name="txtmName" placeholder="Middle Name" required>
                <input type="text" name="txtlName" placeholder="Surname Name" required>
                <input type="date" name="txtday" placeholder="Birthday" required>
                <input type="text" name="txtadd1" placeholder="Address1" required>
                <input type="text" name="txtadd2" placeholder="Address2" required>
                <input type="text" name="txtreg" placeholder="Region" required>
                <input type="text" name="txtlcity" placeholder="City" required>
                
                <div class="btnWrapper">
                    <button type="submit" name="btnSave" title="Save contact details">Save</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>