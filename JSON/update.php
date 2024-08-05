<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVZ Update Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/ulo.png">
</head>
<body>
    <img src="img/jj.jpg" alt="" class="balloon">
    <section id="update">

    <?php
        session_start();

        function getUsersFromFile($file_path) {
            if (file_exists($file_path)) {
                $json_data = file_get_contents($file_path);
                return json_decode($json_data, true);
            } else {
                return [];
            }
        }

        function saveUsersToFile($users, $file_path) {
            $json_data = json_encode($users, JSON_PRETTY_PRINT);
            file_put_contents($file_path, $json_data);
        }

        if (!isset($_SESSION['valid'])) {
            header("Location: login.php");
            exit();
        }

        if (isset($_POST['submit'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $new_player_name = $_POST['player_name'];
            $password = $_POST['password'];

            $current_player_name = $_SESSION['valid'];

            // Read current user data from JSON file
            $file_path = 'users.json';
            $users = getUsersFromFile($file_path);

            // Find user by player name and update data
            foreach ($users as &$user) {
                if ($user['player_name'] === $current_player_name) {
                    $user['first_name'] = $first_name;
                    $user['last_name'] = $last_name;
                    $user['email'] = $email;
                    $user['age'] = $age;
                    $user['player_name'] = $new_player_name;
                    $user['password'] = $password; 
                    break;
                }
            }

            // Save updated user data back to JSON file
            saveUsersToFile($users, $file_path);

            // Update session with new player name
            $_SESSION['valid'] = $new_player_name;

            // Confirmation message and redirection
            echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
            echo "<a href='home.php'><button class='btn'>Go Home</button></a>";
        } else {
            // Display form with current user data
            $current_player_name = $_SESSION['valid'];

            // Read current user data from JSON file
            $file_path = 'users.json';
            $users = getUsersFromFile($file_path);

            // Find user by player name
            $user = null;
            foreach ($users as $u) {
                if ($u['player_name'] === $current_player_name) {
                    $user = $u;
                    break;
                }
            }

            if ($user) {
                $res_Fname = $user['first_name'];
                $res_Lname = $user['last_name'];
                $res_Email = $user['email'];
                $res_Age = $user['age'];
                $res_player_name = $user['player_name'];
                $res_password = $user['password']; // Note: Insecure, consider not displaying passwords in UI
        ?>
        <form action="" method="post">
            <h1>Plants vs. Zombies</h1>
            <p class="update">Update Profile</p>
            <div id="container">
                <div id="personal">
                    <div class="name">
                        <label for="#" class="note">Full Name</label><br>
                        <input type="text" name="first_name" placeholder="First Name" value="<?php echo $res_Fname; ?>" required>
                        <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $res_Lname; ?>" required>
                    </div>
                </div>
                <div id="info">
                    <div class="email">
                        <label for="#" class="note">E-mail</label><br>
                        <input type="email" name="email" placeholder="...@gmail.com" value="<?php echo $res_Email; ?>" required>
                    </div>
                    <div class="age">
                        <label for="" class="note">Age</label><br>
                        <input type="number" name="age" placeholder="Age" value="<?php echo $res_Age; ?>" required>
                    </div>
                </div>
                <div id="create">
                    <label for="" class="note">New Player Name</label><br>
                    <input type="text" name="player_name" placeholder="Player Name" value="<?php echo $res_player_name; ?>" required>     
                </div>
                <div id="passw">
                    <label for="" class="note">New Password</label><br>
                    <input type="password" name="password" placeholder="Password" value="<?php echo $res_password; ?>" pattern=".{8,}" required>     
                </div>
                <div class="submit">
                    <button type="submit" name="submit">Update</button>
                </div>
                <div class="hvacc">
                    <p>Cancel progress? <a href="home.php">Cancel</a></p>
                </div>
            </div>
        </form>
        <?php } ?>
        <?php } ?>
    </section>
</body>
</html>
