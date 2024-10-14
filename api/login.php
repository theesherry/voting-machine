<?php
session_start();
include("connect.php");

// Retrieve form data
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

// Correct SQL query: Add column names or use * to select all
$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile='$mobile' AND role='$role'");

if (mysqli_num_rows($check) > 0) {
    // Fetch the user data
    $userdata = mysqli_fetch_array($check);

    // Fetch all groups (assuming role=2 is for groups)
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    // Store user and groups data in session

    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;
    
    // Redirect to dashboard
    echo '
    <script>
        alert("Login successful!");
        window.location = "../routes/dashboard.php";
    </script>';
} else {
    // Login failed
    echo '
    <script>
        alert("Login not successful. Please check your credentials.");
    </script>';
}

?>
