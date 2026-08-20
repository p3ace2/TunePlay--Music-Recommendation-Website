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
        <title>Survey Page</title>
        <link rel="stylesheet" href="style.css"> 
    </head>

    <body>
        <div class="logo-container">
            <img src="TunePlay (2).png" alt="TunePlay Logo" class="logo">
            <h2 class="brand-title">TunePlay</h2>
        </div>

        <div class="survey-container">
            <!-- Question 1: Genre Question --> 
            <div id="genreQuestion" class="question">
                <label>What genre of music do you enjoy the most?</label>
                <div class="options1">
                    <button class="optionButton1" onclick="selectGenre('Pop')">Pop</button>
                    <button class="optionButton1" onclick="selectGenre('Hip Hop')">Hip Hop</button>
                    <button class="optionButton1" onclick="selectGenre('Afrobeats')">Afrobeats</button>
                    <button class="optionButton1" onclick="selectGenre('R&B')">R&B</button>
                    <button class="optionButton1" onclick="selectGenre('Rock')">Rock</button>
                    <button class="optionButton1" onclick="selectGenre('Country')">Country</button>
                    <button class="optionButton1" onclick="selectGenre('Metal')">Metal</button>  
                </div>
                <!-- Genre Question Navigation -->
                <div class="survey-navigation">
                    <!--<button id="backButton" class="back-button" onclick="goBack()">Back</button>-->
                    <button id="homeButton" class="home-button" onclick="showWarning()">Home</button>
                    <button id="nextButton" class="next-button" onclick="displayArtists()">Next</button>
                </div>
            </div>

            <!-- Question 2: Artists Question --> 
            <div id="artistQuestion" class="question" style="display: none;">
                <label>Select your top 3 favorite artists from this genre:</label>
                <div id="artistButtons" class="options1"></div>
                <!-- Artist Question Navigation -->
                <div class="survey-navigation">
                    <button id="backButton2" class="back-button" onclick="goBack()">Back</button>
                    <button id="homeButton2" class="home-button" onclick="showWarning()">Home</button>
                    <button id="nextButton2" class="next-button" onclick="displayYear()">Next</button>
                </div>
            </div>

            <!-- Question 3: Year Question -->
            <div id="yearQuestion" class="question" style="display: none;">
                <label>What era of music are you looking for?</label>
                <div class="options1">
                    <button class="optionButton2" onclick="selectYear('2000s')">2000s</button>
                    <button class="optionButton2" onclick="selectYear('2010s')">2010s</button>
                    <button class="optionButton2" onclick="selectYear('2020s')">2020s</button>
                </div>
                <!-- Year Question Navigation -->
                <div class="survey-navigation">
                    <button id="backButton3" class="back-button" onclick="goBack()">Back</button>
                    <button id="homeButton3" class="home-button" onclick="showWarning()">Home</button>
                    <button id="submitButton" class="submit-button" onclick="generateRecommendations()">Submit</button>
                </div>
            </div>
        </div>

        <!-- Home Warning Pop Up -->
        <div id="warningPopUp" class="modal">
            <div class="content">
                <h3>Warning</h3>
                <p>Clicking home will reset your progress. Are you sure you would like to continue?</p>
                <div class="popUp-buttons">
                    <button class="popUpbutton confirm" onclick="goHome()">Go home</button>
                    <button class="popUpbutton cancel">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Link to external JavaScript file -->
        <script src="survey.js"></script>
    </body>
</html>