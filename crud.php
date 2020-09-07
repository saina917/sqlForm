<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "familytree";

$conn = mysqli_connect($servername, $username, $password, $dbName);
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_errno());
}
$fName_error = $mName_error = $lName_error = $rlship_error = $gender_error = $dob_error = $mstatus_error =
    $tel_error = $email_error = $occ_error = $child_error = $res_error = "";
$firstName = $middleName = $lastName = $relationship = $gender = $dob = $maritalStatus = $telephoneNo =
    $emailAddress = $occupation = $children = $residence = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['FirstName'])) {
        $fName_error = "First name is required";
    } else {
        $firstName = test_input($_POST['FirstName']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
            $fName_error = "Only letters and white space allowed";
        }
    }

    $middleName = $_POST['MiddleName'];

    if (empty($_POST['LastName'])) {
        $lName_error = "Last Name required";
    } else {
        $lastName = test_input($_POST['LastName']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
            $lName_error = "Only letters and white space allowed";
        }
    }

    if (empty($_POST['Relationship'])) {
        $rlship_error = "Relationship required";
    } else {
        $relationship = test_input($_POST['Relationship']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship)) {
            $rlship_error = "Only letters and white space allowed";
        }
    }

    if (empty($_POST['Gender'])) {
        $gender_error = "Gender required";
    } else {
        $gender = $_POST['Gender'];
    }

    if (empty($_POST['DateOfBirth'])) {
        $dob_error = "DoB required";
    } else {
        $dob = $_POST['DateOfBirth'];
    }

    if (empty($_POST['MaritalStatus'])) {
        $mstatus_error = "Marital Status required";
    } else {
        $maritalStatus = $_POST['MaritalStatus'];
    }

    if (empty($_POST['TelephoneNumber'])) {
        $tel_error = "Telephone required";
    } else {
        $telephoneNo = test_input($_POST['TelephoneNumber']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[0-9,+]{13}$/", $relationship)) {
            $tel_error = "Invalid format";
        }
    }

    if (empty($_POST['EmailAddress'])) {
        $email_error = "Email required";
    } else {
        $emailAddress = test_input($_POST['EmailAddress']);
        // check if e-mail address is well-formed
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email format";
        }
    }
    if (empty($_POST['Occupation'])) {
        $occ_error ="";
    } else {
        $occupation = $_POST['Occupation'];
    }    

    if (empty($_POST['NoOfChildren'])) {
        $child_error = "Number required";
    } else {
        $children = $_POST['NoOfChildren'];
    }

    if (empty($_POST['Residence'])) {   
        $res_error = "Residence required";
    } else {
        $residence = $_POST['Residence'];
    }


    $conn->query("INSERT INTO myfamily (FirstName, MiddleName, LastName, Relationship, Gender, DateOfBirth, 
    MaritalStatus, TelephoneNumber, EmailAddress, Occupation, NoOfChildren, Residence) 
    VALUES('$firstName', '$middleName', '$lastName', '$relationship', '$gender', '$dob', '$maritalStatus',
    '$telephoneNo', '$emailAddress', '$occupation', '$children', '$residence')") or die($conn->error);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
    <script src="js/bootstrap.min.js"> </script>
    <link rel="stylesheet" href="style.css">

    <title>CRUD</title>
</head>


<body>
    <?php
    echo "<div class='container'>";
    echo "<table class='table-bordered table-hover'>";
    echo "<tr colspan='23'>CRETE READ UPDATE DELETE</tr>";
    $query = "SELECT * FROM myfamily";
    $result = mysqli_query($conn, $query);
    $i = 0;
    while ($i < mysqli_num_fields($result)) {
        $headers = mysqli_fetch_field($result);
        echo "<th>$headers->name</th>";
        $i++;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($row as $tableRow) {
            echo "<td>$tableRow</td>";  
        }
        echo "<tr>";
    }
    echo "</table>" . "<br>";
    echo "</div>";

    ?>
    
    <div class="container">
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="col-xs-2">
                <label>First Name</label>
                <input type="text" name="FirstName" class="form-control" placeholder="Enter First Name" value="<?php echo $firstName; ?>">
                <span class="error small">* <?php echo $fName_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Middle Name</label>
                <input type="text" name="MiddleName" class="form-control" placeholder="Enter Middle Name" value="<?php echo $middleName; ?>">
            </div>
            <div class="col-xs-2">
                <label>Last Name</label>
                <input type="text" name="LastName" class="form-control" placeholder="Enter Last Name" value="<?php echo $lastName; ?>">
                <span class="error small">* <?php echo $lName_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Relationship</label>
                <input type="text" name="Relationship" class="form-control" placeholder="Enter Relationship" value="<?php echo $relationship; ?>">
                <span class="error small">* <?php echo $rlship_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Gender</label>
                <select name="Gender" id="inputGender" class="form-control" value="<?php echo $gender; ?>">
                    <option></option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
                <span class="error small">* <?php echo $gender_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>DateOfBirth</label>
                <input type="date" name="DateOfBirth" class="form-control" placeholder="Enter Date of Birth" value="<?php echo $dob; ?>">
                <span class="error small">* <?php echo $dob_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Marital Status</label>
                <select name="MaritalStatus" class="form-control" value="<?php echo $maritalStatus; ?>">
                    <option></option>
                    <option>Single</option>
                    <option>Married</option>
                </select>
                <span class="error small">* <?php echo $mstatus_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Telephone</label>
                <input type="text" name="TelephoneNumber" class="form-control" placeholder="Enter Phone Number" value="<?php echo $telephoneNo; ?>">
                <span class="error small">* <?php echo $tel_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Email Address</label>
                <input type="email" name="EmailAddress" class="form-control" placeholder="Enter Email" value="<?php echo $emailAddress; ?>">
                <span class="error small">* <?php echo $email_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Occupation</label>
                <input type="Occupation" name="Occupation" class="form-control" placeholder="Enter Occupation" value="<?php echo $occupation; ?>">
            </div>
            <div class="col-xs-2">
                <label>No. Of Children</label>
                <input type="No. Of Children" name="NoOfChildren" class="form-control" placeholder="Enter No Of Children" value="<?php echo $children; ?>">
                <span class="error small">* <?php echo $child_error; ?></span>
            </div>
            <div class="col-xs-2">
                <label>Residence</label>
                <input type="Residence" name="Residence" class="form-control" placeholder="Enter Residence" value="<?php echo $residence; ?>">
                <span class="error small">* <?php echo $res_error; ?></span>
            </div>
            <div class="col-xs-2">
                <br><button type="submit" class="btn btn-primary" name="save">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>