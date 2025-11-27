<?php
include 'db_Connection.php';

if (isset($_POST['submit'])) {
    // Validate required fields
    if (isset($_POST['Student_Name'], $_POST['USN'], $_POST['Registered_Date'], $_POST['Annual_Fees_Paid'], $_POST['Fees_Receipt_No'], $_POST['Counsellor_Name'])) {
        // Sanitize inputs
        $Student_Name = $conn->real_escape_string($_POST['Student_Name']);
        $USN = $conn->real_escape_string($_POST['USN']);
        $Registered_Date = $conn->real_escape_string($_POST['Registered_Date']);
        $Elective = $conn->real_escape_string($_POST['Elective'] ?? ''); 
        $Annual_Fees_Paid = $conn->real_escape_string($_POST['Annual_Fees_Paid']);
        $Fees_Receipt_No = $conn->real_escape_string($_POST['Fees_Receipt_No']);
        $Counsellor_Name = $conn->real_escape_string($_POST['Counsellor_Name']);

        // Prepare SQL query
        $sql = "INSERT INTO registred_std1 (Student_Name, USN, Registered_Date, Elective, Annual_Fees_Paid, Fees_Receipt_No, Counsellor_Name)
                VALUES ('$Student_Name', '$USN', '$Registered_Date', '$Elective', '$Annual_Fees_Paid', '$Fees_Receipt_No', '$Counsellor_Name')";

        // Execute query
        if ($conn->query($sql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: Missing required fields.";
    }

    $conn->close();
}
?>
