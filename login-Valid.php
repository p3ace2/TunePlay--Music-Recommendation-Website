<?php
	session_start();
		include('database.php');

		// Error reporting for debugging
		error_reporting(E_ALL);
		ini_set("display_errors", 1);

		//External link to css//
		echo '<link rel="stylesheet" href="style.css">';

		//$_SESSION['loggedIn'] = false;

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
	    // Debug: Print POST data
	    //echo "POST data received:<br>";
	    //print_r($_POST);
	    //echo "<br><br>";

	    // Verify a username and password has been entered
	    if (!isset($_POST['username']) && !isset($_POST['password'])) {
	        die("Username or password not provided");
	    }

	    // Connect to database
	    $mysqli = require __DIR__ . "/database.php";
	    if (!$mysqli) {
	        die("Database connection failed");
	    }

	    // Prepare statement
	    $sql = "SELECT * FROM user WHERE username = ?";
	    $stmt = $mysqli->prepare($sql);
	    if (!$stmt) {
	        die("SQL prepare failed: " . $mysqli->error);
	    }

	    // Bind and execute
	    $stmt->bind_param("s", $_POST['username']);
	    $stmt->execute();
	    
	    // Get result
	    $result = $stmt->get_result();
	    $user = $result->fetch_assoc();

	    // Print found user 
	    echo "<br> Username or Password is Invalid </br>";
	    echo "<button onclick=\"window.location.href='index.html'\">Try Again</button>";
	    //print_r($user);
	    //echo "<br><br>";

	    if ($user) {
	    // Debug: Show password comparison
	    //echo "Sign Up Failed";

	    
	    if (($_POST['password'] == $user['password'] && $user['active']== 1)) {
	        // Login successful
	        $_SESSION['loggedIn']= true;
	        $_SESSION['user_id'] = $user['userID'];
	        $_SESSION['username'] = $user['username'];

	        //echo "Login successful! Redirecting...";
	        header("Location: homePage.php");
	        exit;
	    } else {
	    	//$_SESSION['loggedIn']= false;
	        echo "Username or password Invalid";
	        echo "<button onclick=\"window.location.href='index.html'\">Try Again</button>";
	    }
	}

		}
	?>
