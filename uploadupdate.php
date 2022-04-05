<?php
echo "sdfasa";
require_once "connection.php";
if (isset($_POST["upd"])) {
    echo "sdfasa";
    $id    = $_POST["id"];
        $fname    = $_POST["txtfName"];
        $mname    =$_POST["txtmName"];
        $lname    =$_POST["txtlName"];
        $bday   =$_POST["txtday"];
        $today = date("Y-m-d");
        $getage = date_diff(date_create($bday), date_create($today));
        $age= $getage->format('%y');
        $add1 =$_POST["txtadd1"];
        $add2 =$_POST["txtadd2"];
        $region    =$_POST["txtreg"];
        $city    = $_POST["txtlcity"];

        $con->query("UPDATE `contacts` SET `fname`='$fname',`mname`='$mname',`lname`='$lname',`bday`='$bday',`age`=$age,`add1`='$add1',`add2`='$add2', `region`='$region', `city`=' $city' WHERE `id`= '$id'") or die($con->error);

    header("location: index.php");

}
       
    

?>