<?php
// Database connection
$conn = new mysqli("localhost", "root", "password", "student_admission");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from URL
$studentId = $_GET['id'] ?? null;

if ($studentId) {
    // Fetch student record
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Invalid student ID");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Admission Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Admission Details</h1>
        <?php if ($student): ?>
            <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $student['phone']; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $student['dob']; ?></p>
            <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
            <p><strong>Photo:</strong><br><img src="<?php echo !empty($student['photo']) ? $student['photo'] : 'placeholder.png'; ?>" alt="Photo" width="150"></p>
        <?php else: ?>
            <p>Student not found.</p>
        <?php endif; ?>
        <a href="list.php">Back to List</a>
    </div>
</body>

</html>