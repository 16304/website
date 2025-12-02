<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'db.php';

// Initialize messages
$success = $error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        
        // Prepare and execute SQL insert
        $sql = "INSERT INTO contact_us (name, email, subject, message) 
                VALUES (:name, :email, :subject, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            $success = "Form submitted successfully!";
            // Clear form values
            $name = $email = $subject = $message = "";
        } else {
            $error = "Error submitting the form.";
        }
    }
}
?>

<!-- HTML Form -->
<div id="contact-page">
    <div class="form-container">
        <?php
        if (!empty($success)) { echo "<p style='color:green;'>$success</p>"; }
        if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; }
        ?>
        <form action="contact.php" method="post">
            <label>Name:</label><br>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"><br><br>

            <label>Subject:</label><br>
            <input type="text" name="subject" value="<?php echo isset($subject) ? $subject : ''; ?>"><br><br>

            <label>Message:</label><br>
            <textarea name="message"><?php echo isset($message) ? $message : ''; ?></textarea><br><br>

            <input type="submit" value="Send Message">
        </form>
    </div>
</div>
