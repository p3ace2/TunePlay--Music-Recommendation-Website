<?php
// Database connection for Login Page.
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        
        <!External link to css>
        <link rel="stylesheet" href="style.css"> 

	</head>
		<body>
			<?php
                //include('database.php');
            //DB Connection;
            //$mysqli = require __DIR__."/database.php";
                
            //Not working
                //if(isset($_SESSION['loggedIN'] AND $_GET['username'])){
                    //echo("A user is logged in");
                   //$_SESSION['loggedIn'] = True;
                 //header("refresh:5;url=index.php");
                      //if(isset($_SESSION['loggedIN'])){
                        //echo("<h1> Welcome" . $_SESSION['realName'] . "</h1>");
                        //echo("session was detected");
                    //}
                //} 
                
            
            
            //Checks if user is logged in
            
                 if(isset($_SESSION['loggedIN'])) {
                    if(isset($_SESSION['loggedIN'])){
                        echo("<h1> Welcome" . $_SESSION['realName'] . "</h1>");
                        echo("session was detected");
                        echo('<a href="LogoutSession.php" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-log-out"></span> Log out</a>');
                    }
                }
                       
                       //<a href="#" class="btn btn-info btn-lg">
                    //echo(span class="glyphicon glyphicon-log-out"></span> Log out);
                //</a>
      
                
                       
            
                       
				else if (isset($_GET['username'])) {
                    //echo("GET was detected");
                    $username = $_GET['username'];
                    //$password = $_GET['password'];
                    //Hashing Password
                    
                    echo($password_hash);
                    
                    $firstSQLquery= mysqli_query($con, "SELECT userid, password FROM user WHERE username = '" . $username . "'; " ) OR DIE(MYSQI_ERROR());             
                    //echo("DB query made");
                    
                    // expected data - userID 	name =	7 	Peace
                    
                    if(mysqli_num_rows($firstSQLquery)> 0 ){
                        while ($rowdata = mysqli_fetch_array($firstSQLquery, MYSQLI_NUM)){
                            //check password WITH password_verify
                            $password_hash = password_verify($_POST["password"], $rowdata[0][1]);
                            if (password_verify($_POST['password']= $rowdata[0][1])){
                                echo("yes");

                            }
                            
                            else{echo("no");
                            }


                            var_dump($rowdata);
                            //header("Location: homePage.html");
                            // exit;
                             
        

                                    //Not working
                                    //echo('<a href="LogoutSession.php" class="btn btn-info btn-lg">
                                        //<span class="glyphicon glyphicon-log-out"></span> Log out </a>');
                            $_SESSION['loggedIn'] = True;
                            $_SESSION['userid'] = $rowdata[0];
                            $_SESSION['realName'] = $rowdata[1]; 
                            

                        }
                        
                    }
                }
          
                else{
                    echo("You are not logged in ");
                    //unset($_SESSION[loggedIn]);
                    $_SESSION['loggedIn'] = False;
                    header("refresh:5;url=index.php");
                }
             
            ?>
    </body>
</html>
