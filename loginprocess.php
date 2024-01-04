<?php
session_start();
require_once "config.php";
alert("hello");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Update these values with your database credentials
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "car";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM login WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Valid login
        $_SESSION['username'] = $username;
        echo "Login successful. Redirecting...";
        header("Location: BasicTags2.html"); // Redirect to the dashboard page
        exit();
    } else {
        // Invalid login
        echo "Invalid login credentials";
    }

    $stmt->close();
    $conn->close();
}
?>
