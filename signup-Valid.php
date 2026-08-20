<?php
    session_start();
        include('database.php');

        // Error reporting for debugging
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        // External CSS
        echo '<link rel="stylesheet" href="style.css">';

    // Username Validation
    $valid = true;

    if (!isset($_POST["username"]) || empty(trim($_POST["username"]))) {
        echo("<br>You have not entered a username</br>");
        $valid = false;
    }

    if(!isset($_POST["username"]) || strlen($_POST["username"])<6){
        echo("<br> Username must be at least 6 characters</br>");
        echo "<button onclick=\"window.location.href='signup.html'\">Try Again</button>";
          
        $valid = false;
    }

    // Password Validation
    if (!isset($_POST["password"]) || strlen($_POST["password"]) < 8) {
        echo("<br>Password must be at least 8 characters</br>");
        $valid = false;
    }

    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        echo("<br>Password must contain at least one letter</br>");
        $valid = false;
    }

    if (!preg_match("/[0-9]/", $_POST["password"])) {
        echo("<br>Password must contain at least one number </br>");
        $valid = false;
    }

    if ($_POST["password"] !== $_POST["passwordVerify"]) {
        echo("<br>Passwords must match</br>");
        $valid = false;
    }

     // DB Connection
    $mysqli = require __DIR__ . "/database.php";
    if ($valid === true) {
        
        // Hash the password
        //$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


        // New users are active by default
        $active = 1; 

        // Default profile image
        $profileimg = 'default_profile.png';

        // SQL Query using WHERE NOT EXISTS
        $sql = "INSERT INTO user (username, password, active, profileimg)
                SELECT ?, ?, ?, ?
                WHERE NOT EXISTS (SELECT 1 FROM user WHERE username = ?)";
        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            echo("SQL error: " . $mysqli->error);
        }
        
        // Binding Parameters 
        $stmt->bind_param("ssiss", $_POST['username'], $_POST['password'], $active, $profileimg, $_POST['username']);
        
        $_SESSION['username'] = $_POST['username'];
        if ($stmt->execute()) {
            if ($mysqli->affected_rows > 0) {
                $_SESSION['loggedIn']= true;
                header("Location: homePage.php");
                //exit;
            } 
            else {
                echo("<br> Username is already taken.</br>");
                echo "<button onclick=\"window.location.href='signup.html'\">Try Again</button>";
            }
        } 
        else {
            echo("Failed to sign up: " . $stmt->error);
            echo "<button onclick=\"window.location.href='signup.html'\">Try Again</button>";
        }
    }
    else {
                //echo("<br>Failed to sign up</br>");
                echo "<button onclick=\"window.location.href='signup.html'\">Try Again</button>";
            }
?>
