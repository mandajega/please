<?php
// Replace these credentials with your own MySQL database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "momandme";

// Establish the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session (if not already started)
session_start();

// Function to escape and sanitize input
function sanitize_input($input, $conn) {
    return $conn->real_escape_string($input);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_SESSION['user_id']; // Assuming the session variable is set after login
    $days = sanitize_input($_POST['Days'], $conn);
    $dd = sanitize_input($_POST['dd'], $conn);
    $mm = sanitize_input($_POST['nn'], $conn);
    $yyyy = sanitize_input($_POST['yyyy'], $conn);

    // Prepare and execute the INSERT statement for the 'planningqs' table
    $date = "$yyyy-$mm-$dd";
    $sql_planningqs = "INSERT INTO planningqs (user_id, cycle, periodDate) VALUES ('$user_id', '$days', '$date')";
    if ($conn->query($sql_planningqs) === TRUE) {
        header("Location: planintro.html"); // Redirect to a success page
        exit();
    } else {
        echo "Error: " . $sql_planningqs . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
