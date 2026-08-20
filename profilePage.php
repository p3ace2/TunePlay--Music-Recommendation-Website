ok so the code works and all but puts the wrong userID:
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


        // Define the profile image path
            $profileImage = "uploads/default_profile.png";
            
            // Check if user has a custom profile picture in the session/database
            if(isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image'])) {
                $profileImage = $_SESSION['profile_image'];
            }

        // Fetch recently recommended songs for the logged-in user
        $userID = $_SESSION['user_id']; // Assuming user_id is stored in the session
        $sql = "SELECT Song, Artist, Genre, Year FROM recommendations WHERE userID = ? ORDER BY recomID DESC LIMIT 5"; // Display the 5 most recent recommendations
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are recommendations for the user
        $recentRecommendations = [];
        while ($row = $result->fetch_assoc()) {
            $recentRecommendations[] = $row;
        }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Profile</title>
        <link rel="stylesheet" href="style.css"> 
    </head>
    <body>
        <div class="logo-container">
                        <img src="TunePlay (2).png" alt="TunePlay Logo" class="logo">
                        <h2 class="brand-title">TunePlay</h2>
        </div>
        <div class="profile-container">

            <img src="<?php echo $profileImage; ?>" id="profile-pic" class="profile-picture">

            <h6 class="username"><?php echo ($_SESSION['username']); ?></h6>
            
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <div id="update">
                    <label for="input-file">Update Image</label>
                </div>
                <input type="file" accept="image/jpeg, image/png, image/jpg" id="input-file" name="profile_photo" class="hiddenfile">
                <button type="submit" id="save-photo" class="save-button">Save Photo</button>
            </form>

        <table id="recTable">
            <h2 class="favorites-title" id= "title">Recently Recommended</h2>
            
            <?php if (count($recentRecommendations) > 0): ?>
            <tr>
                <th>Song Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Year</th>
            </tr>

            <?php foreach ($recentRecommendations as $rec): ?>
                <tr>
                    <td><?php echo htmlspecialchars($rec['Song']); ?></td>
                    <td><?php echo htmlspecialchars($rec['Artist']); ?></td>
                    <td><?php echo htmlspecialchars($rec['Genre']); ?></td>
                    <td><?php echo htmlspecialchars($rec['Year']); ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
            <?php else: ?>
                <p class="no-recommendations">No recommendations yet.</p>
            <?php endif; ?>

        <div>
        <button onclick="confirmDelete()">Delete Account</button>
        </div>

        
        <div id="submitbutton" class="home">
            <a href="homePage.php">
                <button>Go Home</button>
            </a>
        </div>

         

    <script>
            let profilePic = document.getElementById("profile-pic");
            let inputFile = document.getElementById("input-file");
            
            inputFile.onchange = function() {
                // Create a temporary preview before form submission
                if(inputFile.files && inputFile.files[0]) {
                    profilePic.src = URL.createObjectURL(inputFile.files[0]);
                }
            }


            // Function to confirm account deletion
           function confirmDelete() {
                if(confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                    window.location.href = "deleteAccount.php";
                }

            }
    </script>
</body>
</html>