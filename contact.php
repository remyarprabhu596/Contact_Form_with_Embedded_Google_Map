<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $message = $_POST['message'];

    // Connect to the database
    $servername = "localhost"; // Change this if your database is hosted elsewhere
    $username = "root"; // Replace with your database username
    $password = " "; // Replace with your database password
    $dbname = "contact_form"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, phoneno, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phoneno, $message);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Success message
        echo "New record created successfully";

        // Send email notification
        $to = "remyarprabhu596@gmail.com"; // Replace with your email address
        $subject = "New Contact Form Submission";
        $email_body = "Name: $name\nEmail: $email\nPhone: $phoneno\nMessage:\n$message";
        $headers = "From: $email";

        mail($to, $subject, $email_body, $headers);
    } else {
        // Error message
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
