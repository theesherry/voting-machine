<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if session 'userdata' is set
if (!isset($_SESSION['userdata'])) {
    header("Location: ../login.html");
    exit();  // Use exit to ensure script stops after the redirect
}

$userdata = $_SESSION['userdata'];
$status = ($_SESSION['userdata']['status'] == 0) ? '<b style="color:red">Not voted</b>' : '<b style="color:green">Voted</b>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <style>
        :root {
            --bg-color-light: #f9f9f9;
            --text-color-light: #333;
            --card-bg-light: #ffffff;
            --button-bg-light: #007bff;
            --button-hover-bg-light: #0056b3;

            --bg-color-dark: #2c2c2c;
            --text-color-dark: #f9f9f9;
            --card-bg-dark: #444444;
            --button-bg-dark: #28a745;
            --button-hover-bg-dark: #218838;

            --border-radius: 10px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--bg-color-light);
            color: var(--text-color-light);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background-color: var(--bg-color-dark);
            color: var(--text-color-dark);
        }

        .main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: var(--button-bg-light);
            color: white;
            box-shadow: var(--box-shadow);
        }

        body.dark-mode .main {
            background-color: var(--button-bg-dark);
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .main a button {
            background-color: var(--button-bg-light);
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 14px;
        }

        .main a button:hover {
            background-color: var(--button-hover-bg-light);
        }

        body.dark-mode .main a button {
            background-color: var(--button-bg-dark);
        }

        body.dark-mode .main a button:hover {
            background-color: var(--button-hover-bg-dark);
        }

        .profile, .group {
            background-color: var(--card-bg-light);
            padding: 20px;
            margin: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        body.dark-mode .profile, body.dark-mode .group {
            background-color: var(--card-bg-dark);
        }

        .profile img {
            border-radius: 50%;
            border: 4px solid var(--button-bg-light);
            width: 250px;  /* Increased image size */
            height: 250px; /* Increased image size */
        }

        body.dark-mode .profile img {
            border-color: var(--button-bg-dark);
        }

        .views {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Adjusted for larger items */
            gap: 20px;
            padding: 20px;
        }

        button {
            background-color: var(--button-bg-light);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--button-hover-bg-light);
        }

        body.dark-mode button {
            background-color: var(--button-bg-dark);
        }

        body.dark-mode button:hover {
            background-color: var(--button-hover-bg-dark);
        }

        /* Toggle Switch */
        .toggle-container {
            display: flex;
            justify-content: flex-end;
            padding: 20px;
        }

        .toggle-button {
            background-color: var(--button-bg-light);
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            border-radius: var(--border-radius);
            transition: background-color 0.3s ease;
        }

        body.dark-mode .toggle-button {
            background-color: var(--button-bg-dark);
        }

        /* Style for group images */
        .group img {
            border-radius: 10px;
            width: 200px;  /* Larger group image */
            height: 200px; /* Larger group image */
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="main">
    <h1>Online Voting System - Dashboard</h1>
    <a href="../api/logout.php"><button id="btn">Logout</button></a>
</div>

<!-- Toggle Button for Light/Dark Mode -->
<div class="toggle-container">
    <button class="toggle-button" id="toggle-button">Toggle Dark Mode</button>
</div>

<div class="profile">
    <h3>Your Profile</h3>
    <img src="../uploads/<?php echo $_SESSION['userdata']['photo']; ?>" alt="Profile Picture">
    <div class="profile-info">
        <p>Name: <?php echo $_SESSION['userdata']['name']; ?></p>
        <p>Address: <?php echo $_SESSION['userdata']['address']; ?></p>
        <p>Mobile: <?php echo $_SESSION['userdata']['mobile']; ?></p>
        <p>Role: <?php echo $_SESSION['userdata']['role']; ?></p>
        <p>Status: <?php echo $status; ?></p>
    </div>
</div>

<div class="views">
    <h1>Groups</h1>
    <?php
    if (isset($_SESSION['groupsdata'])) {
        $groupsdata = $_SESSION['groupsdata'];

        // Check if the user has already voted
        $hasVoted = $_SESSION['userdata']['status'] == 1;

        // Loop through the groups data and display each group's name
        for ($i = 0; $i < count($groupsdata); $i++) {
            ?>
            <div class="group">
                <img src="../uploads/<?php echo $groupsdata[$i]['photo']; ?>" height="200" width="200" alt="Group Image">
                <div class="group-info">
                    <p>Name: <?php echo $groupsdata[$i]['name']; ?></p>
                    <p>Mobile: <?php echo $groupsdata[$i]['mobile']; ?></p>
                    <p>Role: <?php echo $groupsdata[$i]['role']; ?></p>
                    <p>Address: <?php echo $groupsdata[$i]['address']; ?></p>
                    <p>Votes: <?php echo $groupsdata[$i]['votes']; ?></p>
                </div>
                <form action="../api/vote.php" method="POST">
                <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['votes']; ?>">
                <input type="hidden" name="gss" value="<?php echo $groupsdata[$i]['id']; ?>">
                    <button type="submit" <?php echo $hasVoted ? 'disabled' : ''; ?>>
                        <?php echo $hasVoted ? 'Voted' : 'Vote'; ?>
                    </button>
                </form>
            </div>
            <?php
        }
    } else {
        echo "<p>No groups found.</p>";
    }
    ?>
</div>

<script>
// Toggle between Light and Dark mode
const toggleButton = document.getElementById('toggle-button');
const body = document.body;

toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
});

// Check and apply stored mode preference
window.onload = function() {
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'enabled') {
        body.classList.add('dark-mode');
    }
};
</script>

</body>
</html>
