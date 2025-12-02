<?php
include 'db.php'; // connect to database

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare SQL query
    $sql = "INSERT INTO contact_us (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Message Sent Successfully!</h2>";
        echo "<p>Thank you, $name. We will reply soon.</p>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
