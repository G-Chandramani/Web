<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "login";

    try {
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM users WHERE username=? AND password=?";
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
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
