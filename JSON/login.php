<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVZ Log In</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/ulo.png">
</head>
<body>
    <img src="img/plants.jpg" alt="" class="plants">

    <section id="reg2">
        <?php 
     
         // Function to check if a user exists in the JSON data
         function userExists($player_name, $password) {
             $file_path = 'users.json';
     
             // Check if the JSON file exists
             if (file_exists($file_path)) {
                 // Read the existing data from the JSON file
                 $json_data = file_get_contents($file_path);
                 $data = json_decode($json_data, true);
     
                 // Loop through each user in the JSON data
                 foreach ($data as $user) {
                     if ($user['player_name'] === $player_name && $user['password'] === $password) {
                         return $user; 
                     }
                 }
             }
     
             return null; // Return null if user not found
         }
     
         if (isset($_POST['submit'])) {
             $player_name = $_POST['player_name'];
             $password = $_POST['password'];
     
             // Check if the user exists in the JSON data
             $user = userExists($player_name, $password);
     
             if ($user) {
                 $_SESSION['valid'] = $user['player_name'];
                 $_SESSION['first_name'] = $user['first_name'];
                 $_SESSION['last_name'] = $user['last_name'];
                 $_SESSION['age'] = $user['age'];
                 $_SESSION['email'] = $user['email'];
     
                 header("Location: home.php");
                 exit();
             } else {
                 echo "<div class='message'>
                         <p>Wrong Player Name or Password</p>
                       </div> <br><br>";
                 echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
             }
         } else {
     ?>
        <form action="" method="post"> <!-- POST & GET -->
            <header>Plants vs. Zombies</header>
            <p class="acc">Account Log In</p>
  
            <div id="container">
                <div class="username">
                    <label for="player_name" class="note2">Player Name</label><br>
                    <input type="text" name="player_name" id="player_name" placeholder="Player Name" required>
                </div><br>
                <div class="pw">
                    <label for="password" class="note2">Password</label><br>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>

                <div class="login">
                    <button type="submit" name="submit">Log In</button>
                </div>

                <div class="noacc">
                    <p>Don't have an account yet? <a href="register.php">Create an account now!</a></p>
                </div>
            </div>
        </form>
        <?php } ?>
    </section>
</body>
</html>
