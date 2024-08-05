<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVZ Registration</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/ulo.png">
</head>
<body>
    <img src="img/balloon.jpg" alt="" class="brand">
    <section id="reg">
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $player_name = $_POST['player_name'];
            $password = $_POST['password'];

            $file_path = 'users.json';

            // Check if the JSON file exists
            if (file_exists($file_path)) {
                // Read the existing data from the JSON file
                $json_data = file_get_contents($file_path);
                $data = json_decode($json_data, true);
            } else {
                $data = [];
            }

            $player_name_exists = false;
            foreach ($data as $user) {
                if ($user['player_name'] == $player_name) {
                    $player_name_exists = true;
                    break;
                }
            }

            if ($player_name_exists) {
                echo "<div class='message'>
                          <p>This player name is already taken. Please choose another one.</p>
                      </div> <br><br>";
                echo "<a href='register.php'><button class='btn'>Go Back</button></a>";
            } else {
                // Add new user data to the array
                $new_user = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'age' => $age,
                    'player_name' => $player_name,
                    'password' => $password, 
                ];

                $data[] = $new_user;

                // Encode the data back to JSON and save it to the file
                file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));

                echo "<div class='message'>
                          <p>Registration successful!</p>
                      </div> <br>";
                echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
            }
        } else{
        ?>

        <form action="" method="post">
            <h1>Plants vs. Zombies</h1>
            <p class="reg">Account Registration</p>
    
            <div id="container">
                <div id="personal">
                    <div class="name">
                        <label for="#" class="note">Full Name</label><br>
                        <input type="text" name="first_name" placeholder="First Name" required>
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>

                <div id="info">
                    <div class="email">
                        <label for="#" class="note">E-mail</label><br>
                        <input type="email" name="email" placeholder="...@gmail.com" required>
                    </div>

                    <div class="age">
                        <label for="" class="note">Age</label><br>
                        <input type="number" name="age" placeholder="Age" required>
                    </div>
                </div>

                <div id="create">
                    <label for="" class="note">Create Player Name</label><br>
                    <input type="text" name="player_name" placeholder="Player Name" required>     
                </div>

                <div id="passw">
                    <label for="" class="note">Create Password</label><br>
                    <input type="password" name="password" placeholder="Password (should be at least 8 characters)" pattern=".{8,}" required>     
                </div>

                <div class="submit">
                    <button type="submit">Register</button>
                </div>

                <div class="hvacc">
                    <p>Already have an account? <a href="login.php">Log In</a></p>
                </div>
            </div>
        </form>
        <?php } ?>
    </section>
</body>
</html>
