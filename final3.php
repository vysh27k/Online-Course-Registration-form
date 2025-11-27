<?php
include 'db_connection.php';

// Fetch all registered students with their details and statuses
$registeredQuery = "SELECT USN, Student_Name, Elective, Counsellor_Name, Status FROM registered_std3";
$registeredResult = $conn->query($registeredQuery);

$registeredUsers = [];
while ($row = $registeredResult->fetch_assoc()) {
    // Exclude students with "Rejected" status
    if ($row['Status'] !== 'Rejected') {
        $registeredUsers[$row['USN']] = [
            'name' => $row['Student_Name'],
            'elective' => $row['Elective'],
            'counsellor' => $row['Counsellor_Name'],
            'status' => $row['Status']
        ];
    }
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

// List of all courses
$courses = [
    "22CST31", "22CSI32", "22CST33",
    "22CSL35", "22CSL36", "22CSP37", "22CST37", "22UHV38", "22NS39"
];

// Identify not registered students
$remainingUsers = array_diff_key($totalUsers, $registeredUsers);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration Status</title>
    <style>
        h1{
            text-align:center;
           
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            text-align:center;
        }
        th {
            background-color: #4aedb9;
        }
        
        .registered {
            color: green;
            font-weight: bold;
        }
        .not-registered {
            color: orange;
        }
    </style>
</head>
<body>

<h1>Student Registration Status</h1>
<table>
    <thead>
        <tr>
            <th>USN</th>
            <th>Name</th>
            <th>Elective</th>
            <th>Counsellor</th>
            <?php foreach ($courses as $course): ?>
                <th><?= htmlspecialchars($course) ?></th>
            <?php endforeach; ?>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($totalUsers as $USN => $data): ?>
            <tr>
                <td><?= htmlspecialchars($USN) ?></td>
                <td><?= htmlspecialchars($data['name']) ?></td>
                <td>
                    <?= isset($registeredUsers[$USN]) ? htmlspecialchars($registeredUsers[$USN]['elective']) : '-' ?>
                </td>
                <td>
                    <?= isset($registeredUsers[$USN]) ? htmlspecialchars($registeredUsers[$USN]['counsellor']) : '-' ?>
                </td>
                <?php foreach ($courses as $course): ?>
                    <td>
                        <?php
                        // If the student is registered, mark all courses as ✔
                        if (isset($registeredUsers[$USN])) {
                            echo '<span class="registered">✔</span>';
                        } else {
                            echo '<span class="not-registered">✖</span>';
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
                <td>
                    <?php
                    if (isset($registeredUsers[$USN])) {
                        echo '<span class="registered">✔ Registered</span>';
                    } else {
                        echo '<span class="not-registered">Not Registered</span>';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $conn->close(); ?>

</body>
</html>
