<?php
// Database connection
$conn = new mysqli("localhost", "root", "password#.#", "student_admission");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Table if not exists
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    photo VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $gender = htmlspecialchars(trim($_POST['gender']));

    // Handle photo upload
    $photoPath = null; // Default value if no photo is uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['photo'];
        $uploadDir = __DIR__ . "/uploads/";

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory with appropriate permissions
        }

        // Generate unique file name and save the file
        $photoPath = "uploads/" . uniqid() . "-" . basename($photo['name']);
        if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
            die("Failed to upload file.");
        }
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, dob, gender, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $dob, $gender, $photoPath);

    if ($stmt->execute()) {
        echo "Student successfully registered!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
