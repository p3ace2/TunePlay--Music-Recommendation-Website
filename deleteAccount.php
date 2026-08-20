<?php
    // Start the session
    session_start();

    // Include database connection
    include('database.php');

    //External link to css//
    echo '<link rel="stylesheet" href="style.css">';

    // Get user ID from session
    $userID = $_SESSION['user_id'];

    // Not actually deleting the record, just "soft deleting" by setting active=0 and clearing username
    $sql = "UPDATE user SET active = 0 WHERE userID = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $userID);

    if ($stmt->execute()) {
        // Destroy session
        session_unset();
        session_destroy();
        
        // Redirect to the login page
        header("Location: index.html");
        exit;
    } else {
        // Handle error
        echo "Error: " . $mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
?>