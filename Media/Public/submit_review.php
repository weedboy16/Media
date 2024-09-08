<?php
include 'components/db_connect.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $pro_id = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : 0;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $feedback_text = isset($_POST['feedback_text']) ? trim($_POST['feedback_text']) : '';

    // Validate input
    if ($pro_id <= 0 || $rating < 1 || $rating > 5 || empty($feedback_text)) {
        echo "Invalid input.";
        exit;
    }

    // Prepare SQL statement
    $sql = "INSERT INTO feedback (pro_id, rating, feedback_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("iis", $pro_id, $rating, $feedback_text);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the PRO profile page after successful review submission
        header("Location: pro_profile.php?id=" . $pro_id);
        exit();
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
