<?php
session_start();

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Function to fetch user data from JSON file
function getUserData($player_name) {
    $file_path = 'users.json';

    // Check if the JSON file exists
    if (file_exists($file_path)) {
        // Read the JSON file
        $json_data = file_get_contents($file_path);
        $data = json_decode($json_data, true);

        // Loop through each user in the JSON data
        foreach ($data as $user) {
            if ($user['player_name'] === $player_name) {
                return $user; 
            }
        }
    }

    return null;
}

// Get user data from JSON based on session player_name
$player_name = $_SESSION['valid'];
$user = getUserData($player_name);

if (!$user) {
    echo "User not found.";
    exit();
}

// Extract user data from JSON
$res_Fname = $user['first_name'];
$res_Lname = $user['last_name'];
$res_Email = $user['email'];
$res_Age = $user['age'];
$res_player_name = $user['player_name']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVZ Home</title>
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="img/ulo.png">
</head>
<body>
    <img src="img/hand.png" alt="" class="hand">

    <div id="nav">
        <div class="logo">
            <img src="img/brain.png" alt="" class="icon">
            <p>Plants vs. Zombies</p>
        </div>

        <div class="link">
            <a href="update.php"><button class="up">Update Profile</button></a>
            <a href="login.php"><button>Log Out</button></a>
        </div>
    </div>

    <main>
        <div class="mainbox">
            <div class="top">
                <div class="bx">
                    <p>Welcome to Plants vs. Zombies, <b><?php echo htmlspecialchars($res_player_name); ?></b>!</p>
                </div>

                <div class="bx">
                    <p>Your age: <b><?php echo htmlspecialchars($res_Age); ?></b></p>
                </div>
            </div>

            <div class="bottom">
                <div class="bx">
                    <p>Player Name: <b><?php echo htmlspecialchars($res_player_name); ?></b></p>
                </div>

                <div class="bx">
                    <p>Full Name: <b><?php echo htmlspecialchars($res_Fname) . ' ' . htmlspecialchars($res_Lname); ?></b></p>
                </div>

                <div class="bx">
                    <p>E-mail: <b><?php echo htmlspecialchars($res_Email); ?></b></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
