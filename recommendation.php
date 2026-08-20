<?php
    // Start session and enable error reporting
    session_start();

    // Error reporting for debugging
    error_reporting(E_ALL);
    ini_set("display_errors", 1);


    // Check if user is logged in
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
        include('database.php');
    } 
    else {
         // redirect to login pag
        header("Location: index.html");
        exit;
    }

    // Database connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Retrieve data from GET request
    $genre = $_GET['genre'] ?? '';
    $Artist1 = $_GET['Artist1'] ?? '';
    $Artist2 = $_GET['Artist2'] ?? '';
    $Artist3 = $_GET['Artist3'] ?? '';
    $year = $_GET['year'] ?? '';
    $userID = $_SESSION['user_id'];

    // Insert survey answers
    $stmt = $mysqli->prepare("INSERT INTO surveyAnswers (userID, Genre, Artist1, Artist2, Artist3, Year) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $userID, $genre, $Artist1, $Artist2, $Artist3, $year);

    if (!$stmt->execute()) {
        die("Error inserting survey answers: " . $stmt->error);
    }
    $stmt->close();

    // Query for 20 recommendations
    $sql = "SELECT s.songID, s.Artist, s.Song, s.Genre, s.Year,
            (CASE WHEN s.Genre = ? THEN 5 ELSE 0 END +
             CASE WHEN s.Artist = ? OR s.Artist = ? OR s.Artist = ? THEN 3 ELSE 0 END +
             CASE WHEN s.Year = ? THEN 1 ELSE 0 END) AS Scores
            FROM songs s
            ORDER BY Scores DESC, RAND()
            LIMIT 20";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $genre, $Artist1, $Artist2, $Artist3, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Error executing query: " . $mysqli->error);
    }

    // Store all 20 recommendations in an array
    $all_recommendations = [];
    while ($row = $result->fetch_assoc()) {
        $all_recommendations[] = $row;
    }
    $stmt->close();

    // Save 5 random songs to the database
    shuffle($all_recommendations);
    $selected_recommendations = array_slice($all_recommendations, 0, 5);

    $insertStmt = $mysqli->prepare("INSERT INTO recommendations (userID, Song, Artist, Genre, Year) VALUES (?, ?, ?, ?, ?)");

    // Insert 5 songs with error handling
    foreach ($selected_recommendations as $row) {
        $insertStmt->bind_param("issss", $userID, $row['Song'], $row['Artist'], $row['Genre'], $row['Year']);
        
        if (!$insertStmt->execute()) {
            echo "Error inserting recommendation: " . $mysqli->error . "<br>";
        }
    }
    $insertStmt->close();
    $mysqli->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recommendations Page</title>
        <link rel="stylesheet" href="style.css"> 
    </head>
    <body>
        <div class="logo-container">
                <img src="TunePlay (2).png" alt="TunePlay Logo" class="logo">
                <h2 class="brand-title">TunePlay</h2>
        </div>
        <h2 id="title">Recommended Songs</h2>
        <table id="recTable">
            <tr>
                <th>Song Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Year</th>
            </tr>

            <!-- Display all 20 recommendations -->
            <?php foreach ($all_recommendations as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Song']); ?></td>
                    <td><?php echo htmlspecialchars($row['Artist']); ?></td>
                    <td><?php echo htmlspecialchars($row['Genre']); ?></td>
                    <td><?php echo htmlspecialchars($row['Year']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div id="submitbutton" class="home">
            <a href="homePage.php">
                <button>Go Home</button>
            </a>
        </div>

        <div id="retake" class="mainText">
            <h2>Unsatisfied with the recommendations?</h2>
            <a href="surveyPage.php">
                <button>Retake Survey</button>
            </a>
        </div>
    </body>
</html>
