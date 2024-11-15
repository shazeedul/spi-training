<?php
// Database connection
$conn = new mysqli("localhost", "root", "password#.#", "student_admission");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all student records
$sql = "SELECT id, name, email, phone, dob, gender, photo FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 900px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Admission List</h1>
            <a href="index.html" class="add-student-btn">Add New Student</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['dob']; ?></td>
                                <td><?php echo $row['gender']; ?></td>
                                <td>
                                    <img src="<?php echo !empty($row['photo']) ? $row['photo'] : 'placeholder.png'; ?>" alt="Photo" width="50">
                                </td>
                                <td>
                                    <a href="view.php?id=<?php echo $row['id']; ?>" class="view-btn">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No admissions found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php $conn->close(); ?>