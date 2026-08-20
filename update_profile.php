<?php
    session_start();
    include('database.php');

    // Error reporting for debugging
       // error_reporting(E_ALL);
        //ini_set("display_errors", 1);

        //External link to css//
        echo '<link rel="stylesheet" href="style.css">';


    if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
        $image = $_FILES['profile_photo']['tmp_name'];
        $imgContent= file_get_contents($image);

        // Create unique filename using username to 
            $username = $_SESSION['username'];
            $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
            $new_filename = "uploads/profile_" . $username . "_" . time() . "." . $ext;
            
            // Create uploads directory if it doesn't exist
            //if(!file_exists('uploads')) {
            //    mkdir('uploads', 0777, true);
            //}

            //var_dump($_SESSION);
            
            // Move uploaded file to target destination
            if(move_uploaded_file($image,$new_filename)){
                echo("File moved");
                // Update the profileimg field in the user table
                $sql="UPDATE user SET profileimg= ? WHERE userID= ? LIMIT 1;" ;
                $statement = $mysqli -> prepare($sql);
                //echo("Query successfull");
                $statement -> bind_param('ss',$new_filename, $_SESSION['userID']);
                //var_dump($statement);
                $current_id = $statement->execute() or die("<b>Error:</b> Problem updating profile image<br/>" . mysqli_connect_error());
                //echo("Query successfull");

                


                  if ($current_id) {
            // Update session with new image path
            $_SESSION['profile_image'] = $new_filename;
            echo "Profile image updated successfully.";
        } else {
            echo "Profile image update failed, please try again.";
        }
    } else {
        echo "Failed to save the uploaded image.";
    }
} else {
    echo "Please select an image file to upload.";
}

// Redirect back to the profile page after a short delay
header("Refresh: 2; URL=profilePage.php");

// Close the database connection

?>