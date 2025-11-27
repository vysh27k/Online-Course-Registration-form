<?php
include 'db_Connection.php';

if (isset($_POST['submit'])) {
    // Collect form inputs
    $Student_Name = $conn->real_escape_string($_POST['Student_Name']);
    $USN = $conn->real_escape_string($_POST['USN']);
    $Registered_Date = $conn->real_escape_string($_POST['Registered_Date']);
    $Elective = $conn->real_escape_string($_POST['Elective']);
    $Counsellor_Name = $conn->real_escape_string($_POST['Counsellor_Name']);

    // Define valid electives
    $validElectives = ['22CST741', '22CST742', '22CST743'];

    // Check if elective is valid
    if (!in_array($Elective, $validElectives)) {
        echo "<script>
                alert('Invalid elective selected. Please choose 22CST141, 22CST142, or 22CST143.');
                window.location.href='registration_form.php';
              </script>";
        exit();
    }

    // Check if the student is already registered
    $checkQuery = "SELECT * FROM registered_std7 WHERE USN = '$USN'";
    $result = $conn->query($checkQuery);

    if ($result && $result->num_rows > 0) {
        // Student is already registered
        echo "<script>
                alert('This student has already registered.');
                window.location.href='loginpage.php';
              </script>";
        exit();
    } else {
        // Handle file upload
        $uploadsDir = "uploads/";
        $filePath = '';
        if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $_FILES['fileUpload']['tmp_name'];
            $fileName = basename($_FILES['fileUpload']['name']);
            $filePath = $uploadsDir . $fileName;

            // Ensure the upload directory exists
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }

            // Move the file to the server
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                echo "<script>
                        alert('Error uploading file. Please try again.');
                        window.location.href='registration_form.php';
                      </script>";
                exit();
            }
        }

        // Insert data into the database
        $sql = "INSERT INTO registered_std7 (Student_Name, USN, Registered_Date, Elective, Counsellor_Name, Uploaded_File)
                VALUES ('$Student_Name', '$USN', '$Registered_Date', '$Elective', '$Counsellor_Name', '$filePath')";

        if ($conn->query($sql) === TRUE) {
            // Success message and redirect
            echo "<script>
                    alert('Registration successful!');
                    window.location.href='loginpage.php';
                  </script>";
        } else {
            // Database insertion error
            echo "<script>
                    alert('Error: " . $conn->error . "');
                    window.location.href='registration_form.php';
                  </script>";
        }
    }

    $conn->close();
}
?>
