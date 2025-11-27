<?php
include 'db_connection.php';

// Handle form submission for updating statuses
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedStatus = json_decode($_POST['statuses'], true);
    foreach ($updatedStatus as $USN => $status) {
        // Update the database with the new status
        $stmt = $conn->prepare("UPDATE registered_std3 SET Status = ? WHERE USN = ?");
        $stmt->bind_param('ss', $status, $USN);
        $stmt->execute();
    }
}

// Fetch all registered students with their file information and statuses
$registeredQuery = "SELECT USN, Student_Name, Uploaded_File, Status FROM registered_std3";
$registeredResult = $conn->query($registeredQuery);

$registeredUsers = [];
while ($row = $registeredResult->fetch_assoc()) {
    $registeredUsers[$row['USN']] = [
        'name' => $row['Student_Name'],
        'file' => $row['Uploaded_File'],
        'status' => $row['Status'] 
    ];
}

// Fetch all total students
$totalQuery = "SELECT USN, Student_Name FROM total_students3";
$totalResult = $conn->query($totalQuery);

$totalUsers = [];
while ($row = $totalResult->fetch_assoc()) {
    $totalUsers[$row['USN']] = [
        'name' => $row['Student_Name']
    ];
}

// Identify remaining students
$remainingUsers = array_diff_key($totalUsers, $registeredUsers);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration and Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #333;
        }
        th, td {
            border: 2px solid #555;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .tot {
            background-color: yellow;
            padding: 15px;
        }
        .reg {
            color: green;
            font-weight: bold;
        }
        .notreg {
            color: red;
            font-weight: bold;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .accept, .reject {
            padding: 5px 10px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
        }
        .accept {
            background-color: #28a745;
        }
        .reject {
            background-color: #dc3545;
        }
        span.accepted {
            color: #28a745;
            font-weight: bold;
        }
        span.rejected {
            color: #dc3545;
            font-weight: bold;
        }
        .save-button-container {
            text-align: center;
            margin-top: 20px; 
        }
        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
           
            transform: scale(1.05);
        }
        button:active {
            background-color: #004085;
        }
        button:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
    <script>
        const statuses = {}; // Object to track statuses

        function handleAction(button, action, usn) {
            const row = button.closest("tr");
            const statusCell = row.querySelector(".status");

            // Update the status object
            statuses[usn] = action.charAt(0).toUpperCase() + action.slice(1);

            // Update the UI to show the new status
            statusCell.innerHTML = `<span class="${action}">${action.charAt(0).toUpperCase() + action.slice(1)}</span>`;

            // Optionally hide action buttons once selected
            const buttonsDiv = row.querySelector(".buttons");
            buttonsDiv.innerHTML = "";  // Remove action buttons after selection
        }

        function submitStatuses() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'statuses';
            input.value = JSON.stringify(statuses);

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>

<h2 class="tot">Student Registration List</h2>
<div class="container">
    <table>
        <tr>
            <td>
                <h2 class="reg"><u>Registered Students</u></h2>
                <table>
                    <tr>
                        <th>USN</th>
                        <th>Name</th>
                        <th>View File</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    foreach ($registeredUsers as $USN => $data) {
                        // Set the initial status
                        $status = htmlspecialchars($data['status']);
                        $statusClass = strtolower($status);
                        
                        echo "<tr>
                                <td>" . htmlspecialchars($USN) . "</td>
                                <td>" . htmlspecialchars($data['name']) . "</td>";
                        if (!empty($data['file']) && file_exists($data['file'])) {
                            echo "<td><a href='" . htmlspecialchars($data['file']) . "' target='_blank'>View</a></td>";
                        } else {
                            echo "<td>No File</td>";
                        }
                        echo "<td class='status'><span class='{$statusClass}'>{$status}</span>
                                <div class='buttons'>";

                        // Display the action buttons if the status is not 'Accepted' or 'Rejected'
                        if ($status !== 'Accepted' && $status !== 'Rejected') {
                            echo "<button onclick=\"handleAction(this, 'accepted', '$USN')\" class='accept'>Accept</button>
                                  <button onclick=\"handleAction(this, 'rejected', '$USN')\" class='reject'>Reject</button>";
                        }

                        echo "</div></td>
                        </tr>";
                    }
                    ?>
                </table>
            </td>
            <td>
                <h2 class="notreg"><u>Not Registered Students</u></h2>
                <table>
                    <tr><th>USN</th><th>Name</th></tr>
                    <?php
                    foreach ($remainingUsers as $USN => $data) {
                        echo "<tr>
                                <td>" . htmlspecialchars($USN) . "</td>
                                <td>" . htmlspecialchars($data['name']) . "</td>
                              </tr>";
                    }
                    ?>
                </table>
            </td>
        </tr>
    </table>
</div>
        <div class="save-button-container">
            <button onclick="submitStatuses()">Save Changes</button>
        </div>
</body>
</html>

<?php
$conn->close();
?>
