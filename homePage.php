<?php
    // Start the session
    session_start();

        // Check if user is logged in
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            include('database.php');
        } 
        else {
            // redirect to login page
            header("Location: index.html");
            //exit;
        }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>

    <!-- External link to css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="TunePlay (2).png" alt="TunePlay Logo" class="logo">
            <h2 class="brand-title">TunePlay</h2>
        </div>

        <ul>
            <li><a href="LogOut.php">Log Out</a></li>
            <li><a href="profilePage.php">Profile</a></li>
            <li><a href="homePage.php">Home</a></li>
        </ul>
    </header>

    <div class="mainText">
        <h2>Welcome <?php echo ($_SESSION['username']); ?> !</h2>
        <h3>Want to get music Recommendations?</h3>
        <h3>Click Here To Start The Survey</h3>
        <div id="submitbutton">
            <a href="surveyPage.php">
                <button>Start Survey</button>
            </a>
        </div>
    </div>

</body>

</html>
