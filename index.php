<?php
    // Connect to the database
    require_once "connection.php";

    // Delete Table data
    if (isset($_GET["del"])) {
        $id = preg_replace('/\D/', '', $_GET["del"]); //Accept numbers only
        if ($stmt = $con->prepare("DELETE FROM `contacts` WHERE `id`=?")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-delete">Contact details deleted successfully.</div>';
        } else {
            die('prepare() failed: ' . htmlspecialchars($con->error));
        }
    }

    // Display Table data
    $tabledata = "";
    $sqlsearch = "";
    if (isset($_POST["btnSearch"])) {
        $keywords = $con->real_escape_string($_POST["txtSearch"]);
        $searchTerms = explode(' ', $keywords);
        $searchTermBits = array();
        foreach ($searchTerms as $key => &$term) {
            $term = trim($term);
            $searchTermBits[] = " `fname` LIKE '%$term%' OR `id` LIKE '%$term%' OR `lname` LIKE '%$term%'";
        }
        $sqlsearch = " WHERE " . implode(' AND ', $searchTermBits);
    }

    if ($stmt = $con->prepare("SELECT * FROM `contacts` $sqlsearch")) {
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tabledata .= '<tr>
                <td>'.$row["fname"].'</td>
                <td>'.$row["mname"].'</td>
                <td>'.$row["lname"].'</td>
                <td>'.$row["bday"].'</td>
                <td>'.$row["age"].'</td>
                <td>'.$row["add1"].'</td>
                <td>'.$row["add2"].'</td>
                <td>'.$row["region"].'</td>
                <td>'.$row["city"].'</td>
                <td>
                                    <a href="update.php?id='.$row["id"].'" class="btnAction btnUpdate" title="Update contact details">&#9998;</a>
                                    <a href="index.php?del='.$row["id"].'" class="btnAction btnDelete" title="Delete contact details">&#10006;</a>
                                </td>
                            </tr>';
            }
        } else {
            $tabledata= '<tr><td colspan="4" style="text-align: center; padding:30px 0;">Nothing to display</td></tr>';
        }

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
    <title>Student Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
            <h1>&#187;Student Profile&#171;</h1>
            
        </div>
        <div class="wrapper">
            <a href="create.php" class="btnCreate" title="Create new contact">Create New Student Profile</a>
        </div>
        <div class="wrapper">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="txtSearch" value="<?php if(isset($keywords)){ echo $keywords; }?>" title="Input keywords here" required>
                <button type="submit" name="btnSearch" class="btnSearch" title="Search keywords">Search</button>
                <a href="index.php" class="btnReset" title="Reset search">Reset</a>
            </form>
        </div>
        <div class="wrapper">
            <table>
                <thead>
                    <tr>
                        <th>First Name:</th>
                        <th>Middle Name:</th>
                        <th>Last Name:</th>
                        <th>Bday:</th>
                        <th>Age:</th>
                        <th>Address1:</th>
                        <th>Address2:</th>
                        <th>Region:</th>
                        <th>City:</th>
                        <th>Action:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        echo $tabledata;
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>